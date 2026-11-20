"""
One-time conversion: replace each page's copy of the site footer with
an include of templates/footer.php.

Run from the repository root:  python3 tests/scripts/use-shared-footer.py
Safe to run twice (already-converted pages are left alone).
"""
import pathlib
import re

ROOT = pathlib.Path(__file__).resolve().parents[2]
SKIP_DIRS = {'tests', 'lib', 'templates', 'node_modules', '.git'}

FOOTER = re.compile(
    r'<footer id="gradient" class="(footer2?)">\s*'
    r'<span class="alignLeft">[^<]*</span>'
    r'<span class="alignRight">'
    r'<a href="(?:\.\./)?sitemap\.xml">Sitemap</a> \| '
    r'<a href="(?:\.\./)?terms\.html">Terms & Conditions</a> \| '
    r'<a href="([^"]*)">Privacy Policy</a> \| '
    r'<a href="(?:\.\./)?contactform\.html?">Contact Me!</a></span>\s*'
    r'</footer>'
)


def replacement(page, match):
    rel = page.relative_to(ROOT)
    up = '/..' * (len(rel.parts) - 1)
    parts = []
    if match.group(1) != 'footer':
        parts.append(f"$footerClass = '{match.group(1)}';")
    privacy = match.group(2)
    if not re.fullmatch(r'(\.\./)?privacyPolicy\.html', privacy):
        # A page-specific privacy policy, relative to the page's folder.
        parts.append(f"$privacyUrl = '/{'/'.join(rel.parts[:-1] + (privacy,))}';")
    parts.append(f"include __DIR__ . '{up}/templates/footer.php';")
    return '<?php ' + ' '.join(parts) + ' ?>'


changed = 0
for page in sorted(ROOT.rglob('*.php')):
    if SKIP_DIRS & set(page.relative_to(ROOT).parts):
        continue
    text = page.read_bytes().decode('utf-8')
    new, count = FOOTER.subn(lambda m: replacement(page, m), text)
    if count:
        page.write_bytes(new.encode('utf-8'))
        changed += count
        print(f'  {page.relative_to(ROOT)}')
print(f'Replaced {changed} footers.')
