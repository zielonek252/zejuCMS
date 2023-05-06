<?php
$aktualny_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
<pre>
<?php echo "Sitemap:".$aktualny_link."/sitemap.xml"?>


User-agent: *
Disallow: /admin
Disallow: /panel
</pre>