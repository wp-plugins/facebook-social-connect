<?PHP
define("APP_ID",'fffdc04bfd261e555c5607ef55831f7e');
class Facebook
{


		function get_facebook_cookie() {
				$app_id = 'fffdc04bfd261e555c5607ef55831f7e';
				$application_secret = 'f5301585c116aa0f5e2305428f78d702';

				$args = array();
				
				parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
				ksort($args);
				print_r($args);
				$payload = '';
				foreach ($args as $key => $value) {
						if ($key != 'sig') {
							$payload .= $key . '=' . $value;
						}
				}
				if (md5($payload . $application_secret) != $args['sig']) {
						return null;
				}
				return $args;
    }
    function getApplicationId(){
	return APP_ID;
    }

    function getMyProfile($access_token){
	$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$access_token));
	return $user;
    }

    function getMyPhotos($access_token){
	$photos = json_decode(file_get_contents('https://graph.facebook.com/me/photos?access_token='.$access_token));
	return $photos;
    }

    function getMyFeed($access_token){
	$feed = json_decode(file_get_contents('https://graph.facebook.com/me/feed?access_token='.$access_token));
	return $feed;
    }
    function getMyfriends($access_token){
	$friends = json_decode(file_get_contents('https://graph.facebook.com/me/friends?access_token='.$access_token));
	return $friends;
    }

}
?>
