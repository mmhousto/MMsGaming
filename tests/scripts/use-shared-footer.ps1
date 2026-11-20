# One-time conversion: replace each page's copy of the site footer with an
# include of templates/footer.php. Same as use-shared-footer.py, for Windows
# PowerShell (no Python needed).
#
# Run from the repository root:
#   powershell -ExecutionPolicy Bypass -File tests\scripts\use-shared-footer.ps1
# Safe to run twice (already-converted pages are left alone).

$ErrorActionPreference = 'Stop'
$root = (Resolve-Path (Join-Path $PSScriptRoot '..\..')).Path
$skipDirs = @('tests', 'lib', 'templates', 'node_modules', '.git')
$utf8NoBom = New-Object System.Text.UTF8Encoding($false)

$pattern = '<footer id="gradient" class="(footer2?)">\s*' +
    '<span class="alignLeft">[^<]*</span>' +
    '<span class="alignRight">' +
    '<a href="(?:\.\./)?sitemap\.xml">Sitemap</a> \| ' +
    '<a href="(?:\.\./)?terms\.html">Terms & Conditions</a> \| ' +
    '<a href="([^"]*)">Privacy Policy</a> \| ' +
    '<a href="(?:\.\./)?contactform\.html?">Contact Me!</a></span>\s*' +
    '</footer>'
$regex = New-Object System.Text.RegularExpressions.Regex($pattern)

$changed = 0
Get-ChildItem -Path $root -Recurse -File -Filter '*.php' | Sort-Object FullName | ForEach-Object {
    $rel = $_.FullName.Substring($root.Length).TrimStart('\', '/') -replace '\\', '/'
    $parts = $rel.Split('/')
    if ($parts.Length -gt 1 -and $skipDirs -contains $parts[0]) { return }

    $text = [System.IO.File]::ReadAllText($_.FullName, $utf8NoBom)
    $found = $regex.Matches($text)
    if ($found.Count -eq 0) { return }

    $folders = @()
    if ($parts.Length -gt 1) { $folders = $parts[0..($parts.Length - 2)] }
    $up = '/..' * $folders.Count

    # Build the new text by hand (no script-block callbacks, works on all PowerShell versions).
    $sb = New-Object System.Text.StringBuilder
    $last = 0
    foreach ($m in $found) {
        [void]$sb.Append($text.Substring($last, $m.Index - $last))
        $pre = @()
        if ($m.Groups[1].Value -ne 'footer') { $pre += "`$footerClass = '$($m.Groups[1].Value)';" }
        $privacy = $m.Groups[2].Value
        if ($privacy -notmatch '^(\.\./)?privacyPolicy\.html$') {
            # A page-specific privacy policy, relative to the page's folder.
            $pre += "`$privacyUrl = '/" + (($folders + $privacy) -join '/') + "';"
        }
        $pre += "include __DIR__ . '$up/templates/footer.php';"
        [void]$sb.Append('<?php ' + ($pre -join ' ') + ' ?>')
        $last = $m.Index + $m.Length
    }
    [void]$sb.Append($text.Substring($last))

    [System.IO.File]::WriteAllText($_.FullName, $sb.ToString(), $utf8NoBom)
    $changed += $found.Count
    Write-Host "  $rel"
}
Write-Host "Replaced $changed footers."
