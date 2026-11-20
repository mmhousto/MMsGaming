"""
One-time conversion: replace each PHP page's copy of the old Google
Analytics tag with an include of templates/analytics.php.

Run from the repository root with the pages to convert as arguments:
    python3 tests/scripts/use-shared-analytics.py page1.php dir/page2.php ...
"""
import pathlib
import re
import sys

ROOT = pathlib.Path(__file__).resolve().parents[2]

TAG = re.compile(
    r'(?:<!--\s*Global site tag \(gtag\.js\) - Google Analytics\s*-->\s*)?'
    r'<script async src="https://www\.googletagmanager\.com/gtag/js\?id=UA-162871090-1"></script>\s*'
    r'<script>\s*window\.dataLayer = window\.dataLayer \|\| \[\];\s*'
    r'function gtag\(\)\{dataLayer\.push\(arguments\);\}\s*'
    r"gtag\('js', new Date\(\)\);\s*"
    r"gtag\('config', 'UA-162871090-1'\);\s*</script>"
)

changed = 0
for arg in sys.argv[1:]:
    page = (ROOT / arg).resolve()
    rel = page.relative_to(ROOT)
    text = page.read_bytes().decode('utf-8')
    up = '/..' * (len(rel.parts) - 1)
    new, count = TAG.subn(f"<?php include __DIR__ . '{up}/templates/analytics.php'; ?>", text, count=1)
    if count:
        page.write_bytes(new.encode('utf-8'))
        changed += 1
    else:
        print(f'  NOT FOUND in {rel}')
print(f'Converted {changed} pages.')
