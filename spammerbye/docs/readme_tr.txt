// Geliştirici : Ekrem KAYA
// Website     : http://e-piksel.com
// Eklenti     : http://weblenti.com/opencart-spammerbye-spam-referrer-blocker-s1-p82
// GitHub      : https://github.com/epiksel/spammerbye
// Versiyon    : 1.0.0

=== SpammerBye - Spam Referrer Blocker ===
Upload klasörü içindeki tüm dosyaları ana dizine yükleyiniz.

=== OCMOD KURULUM ===
xml-file klasöründeki ocmod.xml dosyasını Eklentiler->Eklenti Yükle ile yükleyin.
Eklentiler->Modifikasyonlar sayfasındaki Yenile butonuna tıklayınız.

=== VQMOD KURULUM ===
xml-file klasöründeki vqmod.xml dosyasını ana dizindeki vqmod/xml içine yükleyiniz.

=== ELLE KURULUM ===
system/startup.php dosyasında

BUL
require_once(DIR_SYSTEM . 'helper/utf8.php');

SONRASINA EKLE
require_once(DIR_SYSTEM . 'helper/spammers.php');

Kara liste için upload/system/blacklist.txt dosyasını düzenleyebilirsiniz.
Varsayılan kara liste için blacklist.txt dosyasını silin ya da düzenlemeden bırakınız.

----
Thanks