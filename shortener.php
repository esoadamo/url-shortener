<?php
/*
Basic URL shorter
Usage:
to create new link add parameter link and key to your request
link - target long url
key - your api key you specified in this script below
Returns: short url
*/
$shortened_url_prefix = "/42"; // The url prefix pointing to this script
$count_random_characters = 6; // How many number characters will be in new link
$data_file = "urls.json"; // File with saved url database
$url_404 = "/404";  // Where to redirect when short link is not found in database
$use_ssl = false;  // Will the returned url start with http// or https://
$api_key = "YOUR_KEY_HERE"; // Key you to provide your permission to create links
$settings_done = false; // Set this to true when you complete your settings

if ( !$settings_done ) {
	print("Setting is not completed. Please edit this file and finish the settings.");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_AR = $_POST;
} else {
        $_AR = $_GET;
}

function saveArray($arr){
	global $data_file;
	$json = json_encode($arr);
	file_put_contents($data_file, $json, $LOCK_EX);
}

function generateDefaultDataFile(){
	$default_data_content = array($shortened_url_prefix . "/" => "/");
	saveArray($default_data_content);
}

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ( ! file_exists($data_file) ) {
	generateDefaultDataFile();
}

$array_urls = json_decode(file_get_contents($data_file), true);

if ( isset($_AR['link']) ) {
	//Ok, now check the API key
	if ( !isset($_AR['key']) || ($_AR['key'] != $api_key ) ) {
		print('Wrong API key');
		exit(0);
	}

	$protocol = $use_ssl ? "https://" : "http://";

	$long_link = $_AR['link'];
	if ( in_array($long_link, $array_urls) ) { // Check if link already exists
		print($protocol . $_SERVER["HTTP_HOST"] . array_search ($long_link, $array_urls));
		exit(0);
	}

	while ( true ) { // Create new unique link
		$new_short_url = $shortened_url_prefix . generateRandomString(6);
		if ( !array_key_exists($new_short_url, $array_urls) )
			break;
	}
	$array_urls[$new_short_url] = $long_link;
	saveArray($array_urls);
	print($protocol . $_SERVER["HTTP_HOST"] . $new_short_url);
	exit(0);
}

$short_url = $_SERVER["REQUEST_URI"];

if ( !array_key_exists($short_url, $array_urls) ) {
	header("Location: " . $url_404);
	exit();
}

$long_url = $array_urls[$short_url];
header("Location: " . $long_url);
exit();

?>
