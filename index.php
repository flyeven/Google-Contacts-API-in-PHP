<?php 
	session_start();
	include 'config.php';
	include 'functions.php';
	if(isset($_GET['logout']))
	{
		unset($_SESSION['token']);
		session_destroy();
		header("Location: login.php");
	}
	
	if(!isset($_SESSION['token']))
	{
		if(isset($_GET["code"]))
		{
			$auth_code = $_GET["code"];
			$fields=array(
				'code'=>  urlencode($auth_code),
				'client_id'=>  urlencode($client_id),
				'client_secret'=>  urlencode($client_secret),
				'redirect_uri'=>  urlencode($redirect_uri),
				'grant_type'=>  urlencode('authorization_code')
			);
			$post = '';
			foreach($fields as $key=>$value)
			{
				$post .= $key.'='.$value.'&';
			}
			$post = rtrim($post,'&');	
			$result = curl('https://accounts.google.com/o/oauth2/token',$post);	
			$response =  json_decode($result);
			$accesstoken = $response->access_token;
			$_SESSION['token']=$accesstoken;
			$url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$accesstoken;
			$xmlresponse =  curl($url);
	
			$temp = json_decode($xmlresponse,true);
		}
		else
		{
			header("Location: login.php");			
		}
	}
	else
	{
        $accesstoken = $_SESSION['token'];
		$_SESSION['token']=$accesstoken;
        $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$accesstoken;
        $xmlresponse =  curl($url);
		
        $temp = json_decode($xmlresponse,true);	
	}
?>

<html>
<head> 
    <title>Contacts | Google Contacts API in PHP</title> 
    <script>
		function di(img){img.onerror=null;img.src='images/default_image.jpg';}
		function del(id,email,cid,etag){
			$('#contact-'+id).addClass('hide');
			$.post(
				'delete.php',
				{'email':email,'cid':cid,'etag':etag},
				function(data,status){if(data==200)console.log('success'); else console.log('error');}
			);
		}
	</script>
</head>
<body>
	<h4 style="text-align:right;"><a href="<?php echo $redirect_uri.'?logout=true';?>">Logout</a> </h4>
	<?php printData($temp,$accesstoken);?>
  	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
</body>
</html>