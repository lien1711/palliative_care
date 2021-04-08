<html lang="vn">
    <head>
        <meta charset="utf8">
        <title>Đăng nhập</title>
        <link rel="stylesheet" type="text/css" href="style.css" >
    </head>
    <body>
        <div id="top-bar"></div>
        <div class="normal-wrapper"> 
            <div id="logo-container">
                <img class="logo-icon" src="logo.png" height="100" />
                <h1>Chăm sóc giảm nhẹ</h1>
            </div>
            <ul id="navbar"> 
                <li><a href="index.html">Home</a></li> 
                <li><a href="about.html">About</a></li> 

                <li><a href="contact.html">Contact</a></li> 
                <li><a href="topics.php" class="last-link">Topics</a></li>
               </ul>
        </div>
	<div id="top-color-splash"></div>
        <div class="normal-wrapper">
            <div class="left">
		<form method="post" action="check_login.php">
		   <fieldset> <legend> Bạn cần nhập mật khẩu để gửi câu trả lời </legend>
			<table>

			   <tr> <td> Password </td>
				  <td> <input type="password" name="password" size="30"> </td> </tr>
			   <tr> <td colspan="2" align="center"> <input name="btn_submit" type="submit" value="Gửi"> </td> </tr>
			</table>
		   </fieldset>
		</form>
            </div>
            <div class="right"> </div>
</html>

<?php
	include( "./access_db.php" );
	session_start();
	$topic_id = $_SESSION[ 'topic_id' ];
	$mail = $_SESSION['mail'];
	$answer = $_SESSION[ 'answer' ];
	     	$_SESSION[ 'topic_id' ] = $topic_id;
		$_SESSION[ 'mail' ] = $mail;
		$_SESSION[ 'answer' ] = $answer;
?>

