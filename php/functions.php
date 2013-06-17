<?php
if (get_magic_quotes_gpc()==1)
	{
	$_GET = stripArray($_GET);
	$_POST = stripArray($_POST);
	$_COOKIE = stripArray($_COOKIE);
	}
function stripArray($ar)
	{
	foreach ($ar as $_k=>$_v)
		{
		$ar[$_k] = (is_array($_v)) ? stripArray($_v): stripslashes($_v);
		}
	return $ar;
	}


        // runs the function to check email format
function isValidEmail($email)
	{
	// Checks if email is in proper format
	return (eregi("^([a-zA-Z0-9_\-])+(\.([a-zA-Z0-9_\-])+)*@((\[(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5]))\]))|((([a-zA-Z0-9])+(([\-])+([a-zA-Z0-9])+)*\.)+([a-zA-Z])+(([\-])+([a-zA-Z0-9])+)*))$", $email, $check));
	}
// Collect email details to parse through the server
function getAddress()
	{
	if(!empty($_SERVER['HTTP_CLIENT_IP_ADDRESS']))
		{
		$ip_expl = explode('.', $_SERVER['HTTP_CLIENT_IP']);
		$referer = explode('.', $_SERVER['REMOTE_ADDR']);
		if($referer[0] != $ip_expl[0])
			{
			$ip = array_reverse($ip_expl);
			$return = implode('.', $ip);
			}
		else
			{
			$return = $client_ip;
			}
		}
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
		if(strstr($_SERVER['HTTP_X_FORWARDED_FORWARD_TO'], ','))
			{
			$ip_expl = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$return = end($ip_expl);
			}
		else
			{
			$return = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}
	else
		{
		$return = $_SERVER['REMOTE_ADDR'];
		}
	return $return;
	}
?>