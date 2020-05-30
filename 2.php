<?php
@ini_set("output_buffering", "Off");
@ini_set('implicit_flush', 1);
@ini_set('zlib.output_compression', 0);
@ini_set('max_execution_time',1200);
header( 'Content-type: text/html; charset=utf-8' );

include 'api.php';


	$username = $_GET['username'];
	$password = $_GET['password'];
	if(empty($username) && empty($password)){ 
die(json_encode(array('status' => 'ready')));

}
	
$ua = iphone();
$phoneid=generate_guid(true);
$crstoken=get_csrftoken();
$guid=generate_guid(true);
$deviceid=generate_device_id(true);
$uuid=generate_guid(true);
$devid = generate_device_id(true);
	
	
	$login = json_encode([
            'phone_id' => $phoneid,
            '_csrftoken' => $crstoken,
            'username' => $username,
            'guid' => $guid,
            'device_id' => $deviceid,
            'password' => $password
            
      ]);
        $login = proccess(1, $ua, 'accounts/login/', 0, hook($login));
		$data = json_decode($login[1]);
		if($data->status<>'ok')
		{
			
		
			die(json_encode(array('status' => 'fail', 'message' => 'Status: Username and Password wrong!', 'cookie' => 'null', 'ip' => $ip))); 	}else{
			preg_match_all('%Set-Cookie: (.*?);%',$login[0],$d);$cookie = '';
			for($o=0;$o<count($d[0]);$o++)$cookie.=$d[1][$o].";";
			$data = curl('https://www.instagram.com/'.$username);
    $data = preg_match('/window._sharedData = (.*?);<\/script>/', $data, $dielz) ? $dielz[1] : null;
    $json = json_decode($data);
    $data = $json->entry_data->ProfilePage[0];
    $id = $data->graphql->user->id;
    $cookie = $cookie;
    	if($data->graphql->user->full_name==null){
      		$name = 'null';
    	}else{
      		$name = $data->graphql->user->full_name;
    	}
    	$following = $data->graphql->user->edge_follow->count;
    	$followers = $data->graphql->user->edge_followed_by->count;
    	if($data->graphql->user->biography==null){
      		$biography = 'null';
    	}else{
      		$biography = $data->graphql->user->biography;
    	}
     $username = $data->graphql->user->username;
     $picture = $data->graphql->user->profile_pic_url;     
			die(json_encode(array('status' => 'ok', 
              
             'id' => $id,
             'cookie' => $cookie,
             'name' => $name,
             'following' => $following,
             'followers' => $followers,
             'biography' => $biography,
             'picture' => $picture,
             'username' => $username,)));
	
		}


//****************************************************************************

          exit();
          
