<?php
	session_start();
	include( "./access_db.php" );

	$topic_id = $_SESSION[ 'q_id' ];
	$f = $_GET['field'];
	$mail = $_POST['mail'];
	$answer = $_POST['detail'];
//echo $f;
	if ( ($mail == '') || ($answer == '') ){
		$_SESSION[ 'message' ] = "Bạn cần điền đầy đủ tất cả nội dung. Mời nhập lại!";
		$_SESSION[ 'link' ] = "./topic_no.php?q_id=$topic_id";
		header( "Location: ./message.php" );
	} else if ($f == 'specialty') {
	    if (check_user($mail)!=0) {
		/*$_SESSION[ 'message' ] = "Đây là câu hỏi liên quan đến chuyên ngành y tế, bạn cần có tài khoản để trả lời!";
		$_SESSION[ 'link' ] = "./topic_no.php?q_id=$topic_id";
		header( "Location: ./message.php" );*/
echo check_user($mail);
	     } else {
	     	$_SESSION[ 'topic_id' ] = $topic_id;
		$_SESSION[ 'mail' ] = $mail;
		$_SESSION[ 'answer' ] = $answer;
		header( "Location: ./login.php" );
	      }
	} else {
		new_answer( $topic_id, $answer, $mail );
		$_SESSION[ 'message' ] = "Câu trả lời của bạn đã được gửi.";
		$_SESSION[ 'link' ] = "./topic_no.php?q_id=$topic_id";
		header( "Location: ./message.php" );
	}
?>
