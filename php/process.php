<?php
require_once("config.php");
require_once("functions.php");
?>
<?php
if($_POST['submit_check'] == 1)
	{
// checks and validates inputs put into the form

	$ip = getAddress();
	$php_version = phpversion();
	$body = "";
	$error_msg = "";

	$to = $to_email;

	if($_POST["$from_field"])
		{
		$from = $_POST[$from_field];
		}
	else
		{
		$from = $default_from_field;
		}

	if (eregi("\r", $from) || eregi("\n", $from))
		{
		die("Email headers manipulation detected");
		}


	if(!isValidEmail($from))
		{
		$error_msg .= "<li><font color=red>Email</font> Provided is not in valid format please check again and type it properly.</li>";
		}

	if(!$_POST[$subject_field])
		{
		$subject = $default_subject;
		}
	else
		{
		$subject = $_POST[$subject_field];
		}

// brings up users details in the body of the email

	$body .= "*******************************************************************************";
	$body .= "\nUSER AGENT: " .$_SERVER['HTTP_USER_AGENT'];
	$body .= "\nFORM PAGE: " .$_SERVER['HTTP_REFERER'];
	$body .= "\nDATE: " .date("l dS of F Y h:i:s A");
	$body .= "\nUSER IP ADDRESS: " .$ip;
	$body .= "\n*******************************************************************************\n";

	foreach($_POST as $k => $v)
		{
		if(is_array($v))
			{
			foreach($v as $k2 => $v2)
				{
				$body .= "$k: $v2 on" . "\n";
				}
			}

		if($k != 'submit_check')
			{
			if(!is_array($v))
				{
				$body .= "$k: $v" . "\n";
				}
			}
		}
	foreach($required as $k => $v)
		{
		if(!array_key_exists($k, $_POST) || empty($_POST[$k]))
			{
			$error_msg .= "<li>Field <font color=red>$v</font> must be filled in.</li>";
			}
		}

// outputs information in body of the email

	$headers = "From: $from\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
	$headers .= "X-Priority: $priority\r\n";
	$headers .= "X-Mailer: PHP $php_version\r\n";

	if(empty($error_msg))
		{
		if(mail($to, $subject, $body, $headers))
			{
			header("Location: $return_url");
			die();
			}
		else
			{
			die("email could not be sent");
			}
		}
	else
		{
		?>

                         <br /><br /><br />
                  <div align="center">
  <center>
  <table border="2" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="500" id="AutoNumber1" height="390">
    <tr>
      <td width="100%" height="390" valign="top">
      <p align="center"><br />
      ----------------------------------------------------------------------------------------<br>
      <font size="6" face="Verdana">A form error has occured!<br>
&nbsp;</font >

</p>
              <font size="2" face="Verdana">
      <p align="center">


       		<ul>
			<?php echo $error_msg; ?>
		</ul>

<br />

                <p align="center">Please use your browser's back button and correct it or click <a href="javascript:history.back();">Here</a>.</p></font>

             </font>
</p>
      <p>
      ----------------------------------------------------------------------------------------</p>
      <p align="center"><font size="2" color="black" face="verdana">Please contact admin@omcikusmarko.com</font></p>
      <p>&nbsp;</td>
    </tr>
</table>
 </center>
</div>
		<?php
		}
	}
?>