<?php
if($_GET){
    $data = curl('https://www.instagram.com/'.$_GET['username'].'/?__a=1');
    print json_encode($data);
}
function curl($url) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($c);
    curl_close($c);
    return $result;
}