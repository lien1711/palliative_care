<?php
/* MySQLサーバに接続し、データベースを使用可能な状態にする */
$db_opened = 0;
$mysqli = null;

function init_db() {
	global $db_opened;
	global $mysqli;
	$mysqli = new mysqli( 'localhost', 'root', '17111989', 'PalliativeCare_DB' );
	if( $mysqli->connect_error ) {
		fatal_error( "データベースとの接続に失敗しました" );
	}
	$db_opened = 1;
}

/* 利用者をチェックする */
$global_mail=null;
function check_user( $mail ) {
	global $db_opened;
	global $mysqli;
	global $global_mail;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare( "SELECT mail FROM users WHERE mail=?" );
	if( $stmt->bind_param( 's', $mail ) == FALSE ) return( 1 );
	if( $stmt->execute() == FALSE ) return( 1 );
	if( $stmt->store_result() == FALSE ) return( 1 );
	if( $stmt->num_rows != 1 ) {
		// ユーザ名を取得できなかった
		$global_mail = null;
		return( 1 );
	}
	if( $stmt->bind_result( $global_mail ) == FALSE ) return( 1 );
	if( $stmt->fetch() == FALSE ) return( 1 );
	if( $global_mail != $mail ) return( 1 );	
	return( 0 );
}
$global_pass=null;
function check_pass( $pass ) {
	global $db_opened;
	global $mysqli;
	global $global_pass;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare( "SELECT password FROM users WHERE password=?" );
	if( $stmt->bind_param( 'i', $pass ) == FALSE ) return( 1 );
	if( $stmt->execute() == FALSE ) return( 1 );
	if( $stmt->store_result() == FALSE ) return( 1 );
	if( $stmt->num_rows != 1 ) {
		// ユーザ名を取得できなかった
		$global_pass = null;
		return( 1 );
	}
	if( $stmt->bind_result( $global_pass ) == FALSE ) return( 1 );
	if( $stmt->fetch() == FALSE ) return( 1 );
	if( $global_pass != $pass ) return( 1 );	
	return( 0 );
}

/*トピックを作成する*/
function new_topic( $title, $detail, $mail, $field ) {
	global $db_opened;
	global $mysqli;
	if( $db_opened == 0 ) init_db();
	//$mysqli->begin_transaction();

	$stmt = $mysqli->prepare( "INSERT INTO topics (title, detail, mail, field) VALUES (?,?,?,?)" );
	if( $stmt->bind_param( 'ssss', $title, $detail, $mail, $field ) == FALSE ) return( 1 );
	if( $stmt->execute() == FALSE ) {
	//	$mysqli->rollback();
		return( 1 );
	}
	//$mysqli->commit();
	return( 0 );
}

/*トピックを表示する*/
$global_num_topic=0;
$global_topic_list = [];
function load_topic() {
	global $db_opened;
	global $mysqli;
	global $global_num_topic;
	global $global_topic_list;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare( "SELECT title FROM topics" );
	if( $stmt->execute() == FALSE ) return( 1 );
	if( $stmt->store_result() == FALSE ) return( 1 );
	if( $stmt->num_rows == 0 ) {
		return( 1 );
	}
	if( $stmt->bind_result( $topics ) == FALSE ) return( 1 );
	for( $global_num_topic=0; $global_num_topic < $stmt->num_rows; $global_num_topic++ ) {
		if( $stmt->fetch() == FALSE ) return( 1 );
		$global_topic_list[ $global_num_topic ] = $topics;
	}
	return( 0 );
}

/* トピックタイトルに対するトピックIDを返す */
$global_topic_id=0;
function get_topic_id_from_title( $title ) {
	global $db_opened;
	global $mysqli;
	global $global_topic_id;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare( "SELECT q_id FROM topics WHERE title=?" );
	$stmt->bind_param( 's', $title );
	$stmt->execute();
	$stmt->store_result();
	if( $stmt->num_rows == 0 ) {
		return( 1 );
	}
	$stmt->bind_result( $topic_id );
	$stmt->fetch();
	$global_topic_id = $topic_id;
	return( 0 );
}

/* トピックIDに対するトピックタイトルを返す */
/*$global_topic_title='';
function get_topic_title_from_id( $id ) {
	global $db_opened;
	global $mysqli;
	global $global_topic_title;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare( "SELECT title FROM topics WHERE q_id=?" );
	$stmt->bind_param( 'i', $id );
	$stmt->execute();
	$stmt->store_result();
	if( $stmt->num_rows == 0 ) {
		return( 1 );
	}
	$stmt->bind_result( $topic_title );
	$stmt->fetch();
	$global_topic_title = $topic_title;
	return( 0 );
}*/
$global_num_topic=0;
$global_topics = [];
function get_topic_detail_from_id( $topic_id ) {
	global $db_opened;
	global $mysqli;
	global $global_num_topic;
	global $global_topics;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare( "SELECT title, detail, field FROM topics WHERE q_id = ?" );
	if( $stmt->bind_param( 'i', $topic_id ) == FALSE ) return ( 1 );
	if( $stmt->execute() == FALSE ) return( 1 );
	$result = $stmt->get_result();
	while( $row = $result->fetch_row() ){
		$global_topics[$global_num_topic++] = $row;
	}
	if( $global_num_topic == 0 ) return( 1 );
	return 0;
}

/* トピックIDに対するトピック内容を返す */
$global_num_answer = 0;
$global_content = [];
function get_content_from_topic_id( $topic_id ){
	global $db_opened;
	global $mysqli;
	global $global_num_answer;
	global $global_content;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare( "SELECT id, content FROM (SELECT sub_id id, question content,time FROM sub_question WHERE q_id=? UNION ALL SELECT 'A',answer,time FROM answers WHERE q_id=? ORDER BY time) AS temp" );
	if( $stmt->bind_param( 'ii', $topic_id, $topic_id ) == FALSE ) return ( 1 );
	if( $stmt->execute() == FALSE ) return( 1 );
	$result = $stmt->get_result();
	while( $row = $result->fetch_row() ){
		$global_content[$global_num_answer++] = $row;
	}
	if( $global_num_answer == 0 ) return( 1 );
	return 0;
}

/* 追加質問の答えを表示する */
$global_num_sub_answer=0;
$global_sub_answer = [];
function load_sub_question( $sub_id ) {
	global $db_opened;
	global $mysqli;
	global $global_num_sub_answer;
	global $global_sub_answer;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare( "SELECT sub_answer, mail FROM sub_answer WHERE sub_id = ?" );
	if( $stmt->bind_param( 'i', $sub_id ) == FALSE ) return ( 1 );
	if( $stmt->execute() == FALSE ) return( 1 );
	$result = $stmt->get_result();
	while( $row = $result->fetch_row() ){
		$global_sub_answer[$global_num_sub_answer++] = $row;
	}
	if( $global_num_sub_answer == 0 ) return( 1 );
	return 0;
}

/*質問、答えを作成する*/
function new_sub_answer( $sub_id, $sub_answer, $mail ) {
	global $db_opened;
	global $mysqli;
	if( $db_opened == 0 ) init_db();
	//$mysqli->begin_transaction();

	$stmt = $mysqli->prepare( "INSERT INTO sub_answer (sub_id, sub_answer, mail) VALUES (?,?,?)" );
	if( $stmt->bind_param( 'iss', $sub_id, $sub_answer, $mail ) == FALSE ) return( 1 );
	if( $stmt->execute() == FALSE ) {
	//	$mysqli->rollback();
		return( 1 );
	}
	//$mysqli->commit();
	return( 0 );
}

function new_answer( $topic_id, $answer, $mail ) {
	global $db_opened;
	global $mysqli;
	if( $db_opened == 0 ) init_db();
	//$mysqli->begin_transaction();

	$stmt = $mysqli->prepare( "INSERT INTO answers (q_id, answer, mail) VALUES (?,?,?)" );
	if( $stmt->bind_param( 'iss', $topic_id, $answer, $mail ) == FALSE ) return( 1 );
	if( $stmt->execute() == FALSE ) {
		//$mysqli->rollback();
		return( 1 );
	}
	//$mysqli->commit();
	return( 0 );
}

function new_question( $topic_id, $question, $mail ) {
	global $db_opened;
	global $mysqli;
	if( $db_opened == 0 ) init_db();
	//$mysqli->begin_transaction();

	$stmt = $mysqli->prepare( "INSERT INTO sub_question (q_id, question, mail) VALUES (?,?,?)" );
	if( $stmt->bind_param( 'iss', $topic_id, $question, $mail ) == FALSE ) return( 1 );
	if( $stmt->execute() == FALSE ) {
	//	$mysqli->rollback();
		return( 1 );
	}
	//$mysqli->commit();
	return( 0 );
}

/* 追加質問IDに対する追加質問を返す */
$global_sub_question=null;
function get_sub_question_from_sub_id( $sub_id ) {
	global $db_opened;
	global $mysqli;
	global $global_sub_question;
	if( $db_opened == 0 ) init_db();
	$stmt = $mysqli->prepare( "SELECT question FROM sub_question WHERE sub_id=?" );
	if( $stmt->bind_param( 'i', $sub_id ) == FALSE ) return( 1 );
	if( $stmt->execute() == FALSE ) return( 1 );
	if( $stmt->store_result() == FALSE ) return( 1 );
	if( $stmt->num_rows != 1 ) {
		// ユーザ名を取得できなかった
		$global_sub_question = null;
		return( 1 );
	}
	if( $stmt->bind_result( $global_sub_question ) == FALSE ) return( 1 );
	if( $stmt->fetch() == FALSE ) return( 1 );
	return( 0 );
}

?>
