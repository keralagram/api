<?php
if($_GET){
   // $data = curl('https://www.instagram.com/'.$_GET['username']);
    $url = 'https://www.instagram.com/'.$_GET['username'].'/?__a=1'; //URL to get
 $mydata=curl($url);
}

function curl($url) {
    $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
$response = curl_exec($ch);
$body = substr( $response, $header_size );
fclose($ch);
return $content;
}
echo$mydata;