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
				if (load_topic()== 0){
					for ( $row=0; $row<$global_num_topic;  $row++ ) {
						get_topic_id_from_title( $global_topic_list[$row] );
						echo "<a href='topic_no.php?q_id=$global_topic_id'>" . $global_topic_list[$row] . "</a> <br>"; 
			} }  ?>
	   
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
