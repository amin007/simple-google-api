<?php
# https://stackoverflow.com/questions/16601268/getting-several-contents-of-url-in-php-using-curl-google-cse
function cURL($url, $ref, $p) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_REFERER, $ref);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	if ($p) 
	{
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $p);
	}
	$result = curl_exec($ch);
	curl_close($ch);
	if ($result) { return $result; } else {  return ''; }
}
function mulakan($keyword)
{
	$cseNumber = '016724384925099384635:s9jmb6xrf-w'; // Key for the API thing
	$key = '016724384925099384635'; //Key for Nofriani's account: sorta a password
	$start = '1';
	/*$url = 'https://www.googleapis.com/customsearch/v1?key=' . $key . '&cx=' . $cseNumber 
		. '&q=' . $keyword . '&siteSearchFilter=i&alt=json&start=' . $start;
	$ref = 'https://www.googleapis.com/customsearch/v1?key=' . $key . '&cx=' . $cseNumber 
	. '&q=' . $keyword . '&siteSearchFilter=i&alt=json&start=' . $start;//*/
	$url = $ref = 'https://cse.google.com/cse?cx=' . $cseNumber 
		. '&q=' . $keyword . '&sort=date&alt=json';
	$p = '';
	$file = cURL($url, $ref, null);
	echo $file;
}

if (isset($_GET['keyword'])) 
{	
	$keyword = $_GET['keyword'];
	mulakan($keyword);
} 
else { 
	$keyword = '?keyword=sdcard';
	echo 'salah bro! keyword <a href=' . $keyword . '>' . $keyword . '</a>';
}

