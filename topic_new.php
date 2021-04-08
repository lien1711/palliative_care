<?php
	session_start();
	include( "./access_db.php" );

	$title = $_POST['title'];
	$mail = $_POST['mail'];
	$detail = $_POST['detail'];
	$field = $_POST['field'];

	if ( ($title == '') || ($mail == '') || ($detail == '') || ($field == '') ){
		$_SESSION[ 'message' ] = "Bạn cần điền đầy đủ tất cả nội dung. Mời nhập lại!";
		$_SESSION[ 'link' ] = "./topic_new.html";
		header( "Location: ./message.php" );
	} else {
		new_topic( $title, $detail, $mail, $field );
		$_SESSION[ 'message' ] = "Chủ đề mới đã được tạo thành công!";
		$_SESSION[ 'link' ] = "./topics.php";
		header( "Location: ./message.php" );
	}
?>

