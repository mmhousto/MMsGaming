"""
One-time conversion: replace each page's copy of the top bar and main menu
with includes of templates/topbar.php and templates/menu.php, keeping each
page's own menu settings (highlighted tab, its JavaScript, Share or
Bookmark button, share address, menu icon style).

Run from the repository root:  python3 tests/scripts/use-shared-header.py
Safe to run twice (already-converted pages are left alone).
"""
import pathlib
import re
import sys

ROOT = pathlib.Path(__file__).resolve().parents[2]
SKIP_DIRS = {'tests', 'lib', 'templates', 'node_modules', '.git'}
ONLY = set(sys.argv[1:])  # optional: limit to these paths (relative to the repo root)

TOPBAR = re.compile(r'<div id="heading1" class="heading1">.*?<div id="logo".*?</div>\s*</div>\s*</div>', re.S)
MENU = re.compile(r'<header class="topnav" id="myTopnav">.*?</header>', re.S)
TAB = re.compile(r'<a class="tablink"([^>]*)>\s*(Home|Games|My Games|Store|Scoreboard|Blog|About)\s*</a>')
KEYS = {'Home': 'home', 'Games': 'games', 'My Games': 'mygames', 'Store': 'store',
        'Scoreboard': 'scoreboard', 'Blog': 'blog', 'About': 'about'}


def php_str(value):
    return "'" + value.replace('\\', '\\\\').replace("'", "\\'") + "'"


def menu_settings(block):
    settings = []
    tabs = TAB.findall(block)
    if [label for _, label in tabs] != list(KEYS):
        raise ValueError('unexpected menu tabs: %r' % [label for _, label in tabs])
    for attrs, label in tabs:
        if 'background-color: white' in attrs:
            settings.append(f"$menuActive = '{KEYS[label]}';")
            onclick = re.search(r'onclick="([^"]*)"', attrs)
            if onclick:
                settings.append(f'$menuActiveOnclick = "{onclick.group(1)}";')
            tab_id = re.search(r'\bid="([^"]*)"', attrs)
            if tab_id:
                settings.append(f"$menuActiveId = {php_str(tab_id.group(1))};")
    if 'id="bookmark-this"' in block:
        settings.append("$menuExtra = 'bookmark';")
    else:
        share = re.search(r'class="fb-share-button" data-href="([^"]*)"', block)
        if not share:
            raise ValueError('menu has neither a Share nor a Bookmark button')
        if share.group(1) != 'https://mms-gaming.com':
            settings.append(f"$shareUrl = {php_str(share.group(1))};")
    icon = re.search(r'<a href="javascript:void\(0\);" class="([^"]*)" onclick="myFunction\(\)">', block)
    if not icon:
        raise ValueError('menu icon not found')
    if icon.group(1) != 'icon':
        settings.append(f"$menuIconClass = {php_str(icon.group(1))};")
    return settings


changed = 0
problems = []
for page in sorted(ROOT.rglob('*.php')):
    rel = page.relative_to(ROOT)
    if SKIP_DIRS & set(rel.parts) or (ONLY and str(rel) not in ONLY):
        continue
    text = page.read_bytes().decode('utf-8')
    top = TOPBAR.search(text)
    menu = MENU.search(text)
    if not top and not menu:
        continue
    if not (top and menu):
        problems.append(f'{rel}: has only one of the top bar / menu, left unchanged')
        continue
    up = '/..' * (len(rel.parts) - 1)
    try:
        settings = menu_settings(menu.group(0))
    except ValueError as err:
        problems.append(f'{rel}: {err}, left unchanged')
        continue
    menu_php = '<?php ' + ' '.join(settings + [f"include __DIR__ . '{up}/templates/menu.php';"]) + ' ?>'
    top_php = f"<?php include __DIR__ . '{up}/templates/topbar.php'; ?>"
    # Replace the later block first so the earlier block's offsets stay valid.
    for match, replacement in sorted([(top, top_php), (menu, menu_php)], key=lambda x: -x[0].start()):
        text = text[:match.start()] + replacement + text[match.end():]
    page.write_bytes(text.encode('utf-8'))
    changed += 1
    print(f'  {rel}')

print(f'Converted {changed} pages.')
for problem in problems:
    print('  NOTE ' + problem)
