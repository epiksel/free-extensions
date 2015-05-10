<?php
// Developer : Ekrem KAYA
// Website   : http://e-piksel.com
// Extension : http://weblenti.com/opencart-spammerbye-spam-referrer-blocker-s1-p82
// GitHub    : https://github.com/epiksel/spammerbye
// Version   : 1.0.0

if (!defined('DIR_APPLICATION')) {
	header("Location: index.php");
	exit();
}

if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
	$refurl = getRefUrl($_SERVER['HTTP_REFERER']);

	$status = ($refurl == getRefUrl(HTTP_SERVER) || $refurl == getRefUrl(HTTPS_SERVER)) ? false : true;

	if ($status) {
		foreach (getBlacklist() as $spammer) {
			if ($refurl == $spammer) {
				$spammerBye = 'Location: http://' . $spammer;
				header($spammerBye);

				exit();
			}
		}
	}
}

function getBlacklist() {
	$blacklist_data = array();

	if (is_file(DIR_SYSTEM . 'blacklist.txt')) {
		$blacklist = DIR_SYSTEM . 'blacklist.txt';
	} else {
		$blacklist = 'https://raw.githubusercontent.com/epiksel/spammerbye/master/blacklist.txt';
	}

	$spammers = file($blacklist, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	foreach ($spammers as $spammer) {
		$blacklist_data[] = utf8_strtolower(getRefUrl(trim($spammer)));
	}

	return $blacklist_data;
}

function getRefUrl($url) {
	$hostname = @parse_url($url, PHP_URL_HOST);

	// If the URL can't be parsed, use the original URL
	// Change to "return false" if you don't want that
	if (!$hostname) {
		$hostname = $url;
	}

	// The "www." prefix isn't really needed if you're just using
	// this to display the domain to the user
	if (utf8_substr($hostname, 0, 4) == "www.") {
		$hostname = utf8_substr($hostname, 4);
	}

	// You might also want to limit the length if screen space is limited
	if (utf8_strlen($hostname) > 50) {
		$hostname = utf8_substr($hostname, 0, 47) . '...';
	}

	if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $hostname, $result)) {
		return $result['domain'];
	}

	return utf8_strtolower($hostname);
}