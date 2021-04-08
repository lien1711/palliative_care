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
               </ul>
        </div>
        <div id="top-color-splash"></div>
        <div class="normal-wrapper">
            <div class="left">
		    <?php include( "./access_db.php" ); 
			session_start();
			$topic_id = $_GET["q_id"];
			$_SESSION[ 'q_id' ]=$topic_id;
			get_topic_detail_from_id( $topic_id );
			for ($i=0;$i<$global_num_topic;$i++){
			     echo "<h2 class='no-margin-top'>" . $global_topics[$i][0] . "</h2>" ;
			     echo "<h4>" . $global_topics[$i][1] . "</h4>" ;
			     $f = $global_topics[$i][2];
			}
			$_SESSION[ 'field' ]=$f;
			if ( get_content_from_topic_id( $topic_id ) == 0){
			   for ( $row=0; $row<$global_num_answer;  $row++ ) {		  
				if ($global_content[$row][0]=='A') 
				   echo "<img src='answer.png' width='20' />&nbsp;" . $global_content[$row][1] . '<br>' ;
				else {	
				   $sub_question_id = $global_content[$row][0];
				   echo "<img src='question.png' width='20' />&nbsp;<a href = './sub_question.php?sub_id=$sub_question_id'>" . $global_content[$row][1] . "</a> <br>"; 
				} 
			    }
		  	 }
		      ?>

	<br>
	   	<td colspan="2" align="center"> <input type="button" id="ans" value="Trả lời" /> </td>
		 <div id="content" style="display: none; border: solid 1px; padding: 20px; background: #ddd;">
		   <form method="post" action="./answer.php?field=<?php echo $f; ?> ">
		     <legend> <h3> Câu trả lời của bạn </h3> </legend>
   			<table>
			   <tr> <td> Email </td>
				  <td> <input type="text" name="mail" size="30"> </td> </tr>
			   <tr> <td> Nội dung </td>
				  <td> <textarea name="detail" cols="80" rows="8"> </textarea> </td> </tr>
			   <tr> <td> </td> 
				  <td colspan="2" align="center"> <input name="ans" type="submit" value="Gửi"> 
				  </td> </tr>
			</table>
		   </form> 
		</div>
	<br>
<script language="javascript">
document.getElementById("ans").onclick = function() {
	document.getElementById("content").style.display='block';};

</script>
	<br>
		<td colspan="2" align="center"> <input name="back" type="button" value="Quay lại" onclick="location.href='./topics.php'" /> </td>
		<td colspan="2" align="center"> <input id="ques" type="button" value="Đặt câu hỏi" /> </td>
		 <div id="content2" style="display: none; border: solid 1px; padding: 20px; background: #ddd;">
		     <form method="post" action="./questions.php">
		     <legend> <h3> Thắc mắc của bạn là gì? </h3> </legend>
   			<table>
			   <tr> <td> Email </td>
				  <td> <input type="text" name="mail" size="30"> </td> </tr>
			   <tr> <td> Nội dung </td>
				  <td> <textarea name="detail" cols="80" rows="8"> </textarea> </td> </tr>
			   <tr> <td> </td> 
				  <td colspan="2" align="center"> <input name="ques" type="submit" value="Gửi"> 
				  </td> </tr>
			</table>
		   </form> 
		 </div>
 <script language="javascript">
document.getElementById("ques").onclick = function() {
	document.getElementById("content2").style.display='block';};

</script>
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
