<?php
/*
 * Google Analytics (GA4), shared by every PHP page. To change the
 * measurement ID, edit it here. The four plain-HTML pages (contactform,
 * thankyou, privacyPolicy, terms) carry their own copy of the tag.
 */
$mmsgAnalyticsId = 'G-5F2BTG9Z5H';
?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $mmsgAnalyticsId; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $mmsgAnalyticsId; ?>');
</script>
