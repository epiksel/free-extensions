// Geliştirici : Ekrem KAYA
// Website     : http://e-piksel.com
// Eklenti     : http://www.weblenti.com/opencart-opensearch-seo-s1-p80
// Versiyon    : 1.0.0

=== E-PiKSEL OPENSEARCH SEO ===
Upload klasörü içindeki tüm dosyaları ana dizine yükleyiniz.

=== OC MOD KURULUM ===
xml-file klasöründeki ocmod.xml dosyasını Eklentiler->Eklenti Yükle ile yükleyin.
Eklentiler->Modifikasyonlar sayfasındaki Yenile butonuna tıklayınız. 

=== ELLE KURULUM ===
catalog/controller/common/header.php dosyasında

BUL
$data['home'] = $this->url->link('common/home');

SONRASINA EKLE
$data['opensearch'] = $this->url->link('product/opensearch', '', 'SSL');

-------------------------------------------------------

catalog/view/theme/*/template/common/header.tpl dosyasında

BUL
<?php foreach ($links as $link) { ?>

ÖNCESİNE EKLE
<link href="<?php echo $opensearch; ?>" rel="search" type="application/opensearchdescription+xml" title="<?php echo $name; ?>" />

----
Thanks