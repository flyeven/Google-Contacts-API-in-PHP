<?php 
	session_start();
	if(!isset($_SESSION['token'])) header('Location: index.php');
	include 'config.php';
	include 'functions.php';
	
	$email=$_POST['email'];
	$cid=$_POST['cid'];
	$etag=urldecode($_POST['etag']);
	$etag=substr($etag,1,strlen($etag)-2);
	$accesstoken=$_SESSION['token'];
	
	$url='https://www.google.com/m8/feeds/contacts/'.$email.'/full/'.$cid.'?alt=json&v=3.0&access_token='.$accesstoken;
	print_r($url);
	$headers = array('If-match: *');
	print_r(curl_delete($url,$headers));
?>
