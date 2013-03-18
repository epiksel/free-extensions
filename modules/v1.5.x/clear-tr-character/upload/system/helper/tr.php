<?php
/* Developer: Ekrem KAYA
Web Page: www.e-piksel.com */

function dosya_temizle($text) {
	$text = trim($text);

	$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
	$replace = array('c','c','g','g','i','i','o','o','s','s','u','u');

	$text = str_replace($search, $replace, $text);
	$text = preg_replace("@[^a-z0-9\-_ÇçĞğıİÖöŞşÜü.]+@i","-", $text);
	// Birden fazla olan boşlukları tek boşluk yap
    $text = preg_replace("/ +/", " ", $text);
    // Boşukları - işaretine çevir
    $text = preg_replace("/ /", "-", $text);

	return $text;
}

function url_temizle($text) {
	$text = trim($text);

	$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
	$replace = array('c','c','g','g','i','i','o','o','s','s','u','u');

	$text = str_replace($search, $replace, $text);
	$text = preg_replace("@[^a-z0-9\-_ÇçĞğıİÖöŞşÜü]+@i","-", $text);
	// Birden fazla olan boşlukları tek boşluk yap
    $text = preg_replace("/ +/", " ", $text);
    // Boşukları - işaretine çevir
    $text = preg_replace("/ /", "-", $text);

	return $text;
}
?>