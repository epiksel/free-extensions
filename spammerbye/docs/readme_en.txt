// Developer : Ekrem KAYA
// Website   : http://e-piksel.com
// Extension : http://weblenti.com/opencart-spammerbye-spam-referrer-blocker-s1-p82
// GitHub    : https://github.com/epiksel/spammerbye
// Version   : 1.0.0

=== SpammerBye - Spam Referrer Blocker ===
All files in "upload" directory your root directory upload

=== OC MOD INSTALLATION ===
Upload ocmod.xml in xml-file on Extensions->Extension Installer
Click Refresh button on Extensions->Modifications

=== VQMOD INSTALLATION ===
Upload vqmod.xml in xml-file to root/vqmod/xml

=== MANUEL INSTALLATION ===
system/startup.php in file

FIND
require_once(DIR_SYSTEM . 'helper/utf8.php');

ADD AFTER
require_once(DIR_SYSTEM . 'helper/spammers.php');

Edit upload/system/blacklist.txt for custom blacklist
Delete blacklist.txt file or leave without editing for default blacklist

----
Thanks