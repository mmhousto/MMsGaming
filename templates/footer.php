<?php
/*
 * Site footer, shared by every page.
 * Optional before including: $footerClass (default "footer"),
 * $privacyUrl (default the site privacy policy).
 */
$footerClass = $footerClass ?? 'footer';
$privacyUrl = $privacyUrl ?? '/privacyPolicy.html';
?>
<footer id="gradient" class="<?php echo e($footerClass); ?>">
  <span class="alignLeft">© 2019-<?php echo date('Y'); ?> MM's Gaming Community LLC. All Rights Reserved.</span><span class="alignRight"><a href="/sitemap.xml">Sitemap</a> | <a href="/terms.html">Terms & Conditions</a> | <a href="<?php echo e($privacyUrl); ?>">Privacy Policy</a> | <a href="/contactform.html">Contact Me!</a></span>
</footer>
