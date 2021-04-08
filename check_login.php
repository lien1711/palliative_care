<?php
	include( "./access_db.php" );
	session_start();
	$pass = $_POST[ 'password' ];
	$topic_id = $_SESSION[ 'topic_id' ];
	$mail = $_SESSION['mail'];
	$answer = $_SESSION[ 'answer' ];

	if( ($pass == '' ) || ( check_pass( $pass ) != 0 )) {
		$_SESSION[ 'message' ] = "Mật khẩu không đúng. Mời nhập lại!";
		$_SESSION[ 'link' ] = "./login.php";
		header( "Location: ./message.php" );

	} else { 
		new_answer( $topic_id, $answer, $mail );
		$_SESSION[ 'message' ] = "Câu trả lời của bạn đã được gửi.";
		$_SESSION[ 'link' ] = "./topic_no.php?q_id=$topic_id";
		header( "Location: ./message.php" );
	}
?>
