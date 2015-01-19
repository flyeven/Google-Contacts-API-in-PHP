<?php 
session_start();
if(isset($_SESSION['token'])) header('Location: index.php');
include 'config.php';
?>
<html>
<head> 
    <title>Contacts | Google Contacts API in PHP</title> 
    <script>
		function di(img){img.onerror=null;img.src='images/default_image.jpg';}
	</script>
</head>
<body>
	<a style="margin:100px 0 0 100px;" class="btn btn-primary btn-lg" href="https://accounts.google.com/o/oauth2/auth?client_id=<?php echo $client_id; ?>&redirect_uri=<?php echo $redirect_uri; ?>&scope=https://www.google.com/m8/feeds/&response_type=code" role="button">Import your google contacts</a>
</body>
</html>