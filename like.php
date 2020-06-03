<?php
if(@$_GET['id']||@$_GET['shortcode']||@$_GET['useragent']||@$_GET['cookie']){
    print like($_GET['id'],$_GET['shortcode'],$_GET['useragent'],$_GET['cookie']);
}
function curl($url, $data=null, $useragent=null, $cookie=null) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    if($data != null){
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    if($cookie != null){
        curl_setopt($c, CURLOPT_COOKIE, $cookie);
    }
    if($useragent != null){
        curl_setopt($c, CURLOPT_USERAGENT, $useragent);
    }
    $hmm = curl_exec($c);
    curl_close($c);
    return $hmm;
}

function like($id, $code, $useragent, $cookie) {
 preg_match('%sessionid=(.*?);%',$cookie,$a);
 preg_match('%csrftoken=(.*?);%',$cookie,$b);
	$headers = array();
	$headers[] = "cookie: sessionid=".$a[1].";csrftoken=".$b[1];
	$headers[] = "origin: https://www.instagram.com";
	$headers[] = "accept-encoding: gzip, deflate, br";
	$headers[] = "accept-language: en-US,en;q=0.9";
	$headers[] = "user-agent: ".$useragent."";
	$headers[] = "x-requested-with: XMLHttpRequest";
	$headers[] = "save-data: on";
	$headers[] = "x-csrftoken: ".$b[1];
	$headers[] = "pragma: no-cache";
	$headers[] = "x-instagram-ajax: 1";
	$headers[] = "content-type: application/x-www-form-urlencoded";
	$headers[] = "accept: */*";
	$headers[] = "cache-control: no-cache";
	$headers[] = "authority: www.instagram.com";
	$headers[] = "referer: https://www.instagram.com/";
        $headers[] = "content-length: 0";
 
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/web/likes/'.$id.'/like/');
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION,false);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "");
  $result = curl_exec($ch); 
  curl_close($ch);
  return $result;
}


echo $result;
