<html lang="vn">
    <head>
        <meta charset="utf8">
        <title>Chăm sóc giảm nhẹ</title>
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
                <li><a href="topics.php" class="last-link">Topics</a></li>
               </ul>
        </div>
        <div id="top-color-splash"></div>
        <div class="normal-wrapper">
            <div class="left"> <form method="post" action="./sub_answer.php">
		    <?php include( "./access_db.php" ); 
			session_start();
			$topic_id = $_SESSION[ 'q_id' ];
			$sub_qid = $_GET["sub_id"];
			$_SESSION[ 'sub_id' ]=$sub_qid;
			$field = $_SESSION[ 'field' ];
 			$_SESSION[ 'field' ] = $field;
			if (get_sub_question_from_sub_id( $sub_qid ) == 0) echo "<h3>" . $global_sub_question . "</h3>";
		      load_sub_question( $sub_qid );
			for ( $sub_row=0; $sub_row<$global_num_sub_answer;  $sub_row++ ) 
			    echo "&nbsp;&nbsp;<img src='sub_answer.png' width='20' />&nbsp;" . $global_sub_answer[$sub_row][0] . '<br>Được đăng bởi ' . $global_sub_answer[$sub_row][1] . '<br>';
			if ($field == 'specialty') echo "<h3 style='color:red'>Đây là câu hỏi liên quan đến chuyên ngành y tế, bạn cần có tài khoản để trả lời!</h3>";
		      ?>
		
		     <fieldset> <legend> Câu trả lời của bạn </legend>		  
   			<table>
			   <tr> <td> Email </td>
				  <td> <input type="text" name="mail" size="30"> </td> </tr>
			   <tr> <td> Password </td>
				  <td> <input type="password" name="password" size="30"> </td> </tr>
			   <tr> <td></td><td> Bắt buộc nhập đối với những câu hỏi liên quan đến ngành y tế. </td> </tr>
			   <tr> <td> Nội dung </td>
				  <td> <textarea name="detail" cols="80" rows="8"> </textarea> </td> </tr>
			   <tr> <td> </td> 
				  <td colspan="2" align="center"> <input name="new" type="submit" value="Trả lời"> 
				      &nbsp;<input name="back" type="button" value="Quay lại" onclick="location.href='./topic_no.php?q_id=<?php echo $topic_id ?>'"> 
				  </td> </tr>
			</table>
		   </form>
            </div>
            <div class="right">
                <ul>
                    <li><a href="topic_new.html">Tạo chủ đề thảo luận mới</a></li>
                    
                </ul>
            </div>
        </div>
        <div id="footer"></div>
    </body>
</html>
