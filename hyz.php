<?php
if($_GET){
    $data = curl('https://www.instagram.com/'.$_GET['username']);
    $data = preg_match('/window._sharedData = (.*?);<\/script>/', $data, $dielz) ? $dielz[1] : null;
    $json = json_decode($data);
    $data = $json->entry_data->ProfilePage[0];
    print json_encode($data);
}
function curl($url, $data=null) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $url);
	if($data != null){
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($c);
    curl_close($c);
    return $result;
}