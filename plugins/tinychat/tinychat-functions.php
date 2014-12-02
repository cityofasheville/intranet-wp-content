<?php
function tinychat_get_file_content($url = '') {
	if(!empty($url)) {
        if(function_exists("curl_init")) {   	
			return curl_get_file_contents($url);
		} else {
			return filegetContents($url);
		}
	}
	return false;
}

function curl_get_file_contents($url) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_TIMEOUT, 10); 
	curl_setopt($c, CURLOPT_URL, $url);
	$contents = curl_exec($c);
	curl_close($c);
	if ($contents) return $contents;
	else return false;
}

function filegetContents($url) {
	$context = stream_context_create(array(
		'http' => array(
			'timeout' => 10      // Timeout in seconds
		)
	));
    return @file_get_contents($url,0,$context);
}

function tinychat_get_user_list($room = 'chat') {
    $auth = md5(get_option('tinychat_api_secret') . ":" . $room . ":" . "roominfo");
    $url = "http://tinychat.apigee.com/roominfo&result=json&withip=1&room=" . $room . "&key=" . get_option('tinychat_api_key') . "&auth=" . $auth;
    $data = tinychat_get_file_content( $url );
    if($data === FALSE) return false;
    
    $users = json_decode( $data, true );
	
    if($users == NULL) $users = array();
    return $users;
}
?>
