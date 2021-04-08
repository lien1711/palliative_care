<?php
	session_start();
	include( "./access_db.php" );

	$topic_id = $_SESSION[ 'q_id' ];
echo $topic_id;
	$mail = $_POST['mail'];
	$ques = $_POST['detail'];

      if ( ($mail == '') || ($ques == '') ){
		$_SESSION[ 'message' ] = "Bạn cần điền đầy đủ tất cả nội dung. Mời nhập lại!";
		$_SESSION[ 'link' ] = "./topic_no.php?q_id=$topic_id";
		header( "Location: ./message.php" );
	} else {
		new_question( $topic_id, $ques, $mail );
		$_SESSION[ 'message' ] = "Câu hỏi của bạn đã được gửi.";
		$_SESSION[ 'link' ] = "./topic_no.php?q_id=$topic_id";
		header( "Location: ./message.php" );
	}
?>

