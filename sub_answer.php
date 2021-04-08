<?php
	session_start();
	include( "./access_db.php" );

	$sub_qid = $_SESSION[ 'sub_id' ];
	$mail = $_POST['mail'];
	$detail = $_POST['detail'];
	$f = $_SESSION[ 'field' ];
	$pass = $_POST[ 'password' ];

	if ( ($mail == '') || ($detail == '') ){
		$_SESSION[ 'message' ] = "Bạn cần điền đầy đủ tất cả nội dung. Mời nhập lại!";
		$_SESSION[ 'link' ] = "./sub_question.php?sub_id=$sub_qid";
		header( "Location: ./message.php" );
	} else if ($f == 'specialty') {
	    if (check_user($mail)!=0) {
		$_SESSION[ 'message' ] = "Đây là câu hỏi liên quan đến chuyên ngành y tế, bạn cần có tài khoản để trả lời!";
		$_SESSION[ 'link' ] = "./sub_question.php?sub_id=$sub_qid";
		header( "Location: ./message.php" );
	     } else if( ($pass == '' ) || ( check_pass( $pass ) != 0 )) {
		$_SESSION[ 'message' ] = "Mật khẩu không đúng. Mời nhập lại!";
		$_SESSION[ 'link' ] = "./sub_question.php?sub_id=$sub_qid";
		header( "Location: ./message.php" );
	     } else {
		new_sub_answer( $sub_qid, $detail, $mail );
		$_SESSION[ 'message' ] = "Câu trả lời của bạn đã được gửi.";
		$_SESSION[ 'link' ] = "./sub_question.php?sub_id=$sub_qid";
		header( "Location: ./message.php" ); }
	} else {
		new_sub_answer( $sub_qid, $detail, $mail );
		$_SESSION[ 'message' ] = "Câu trả lời của bạn đã được gửi.";
		$_SESSION[ 'link' ] = "./sub_question.php?sub_id=$sub_qid";
		header( "Location: ./message.php" );
	}
?>
