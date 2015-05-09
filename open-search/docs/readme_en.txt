// Developer : Ekrem KAYA
// Website   : http://e-piksel.com
// Extension : http://www.weblenti.com/opencart-opensearch-seo-s1-p80
// Version   : 1.0.0

=== E-PiKSEL OPENSEARCH SEO ===
All files in "upload" directory your root directory upload

=== OC MOD INSTALLATION ===
Upload ocmod.xml in xml-file on Extensions->Extension Installer
Click Refresh button on Extensions->Modifications

=== MANUEL INSTALLATION ===
catalog/controller/common/header.php in file

FIND
$data['home'] = $this->url->link('common/home');

ADD BEFORE
$data['opensearch'] = $this->url->link('product/opensearch', '', 'SSL');

-------------------------------------------------------

catalog/view/theme/*/template/common/header.tpl in file

FIND
<?php foreach ($links as $link) { ?>

ADD BEFORE
<link href="<?php echo $opensearch; ?>" rel="search" type="application/opensearchdescription+xml" title="<?php echo $name; ?>" />

----
Thanks