
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="stylechat.css" type="text/css" rel="stylesheet"/>


    <title>ΣΥΝΟΜΙΛΙΑ ΔΙΠΛΩΜΑΤΙΚΉΣ</title>

    <?php
    include_once "page_parts/head.php";
    ?>

    <script  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        function foo () {
            alert("YOU SEND");
            // e.preventDefault();
            $.ajax({
                type:"POST",
                url:"InsertMessage.php",
                data:{txtArea:usermsg}
                success: function(data){
                    $("#chatbox").html(data);
                    alert(data);
                    $("#chatbox").load("DispalyMessages.php")
                    $("#usrmsg").val(""); //Insert chat log into the #chatbox div
                }
                error: function(){
                    alert('there was an error, write your error handling code here.');
                }
                return false;
        });

            setInterval(function(){
                $("#chatbox").load("DispalayMessages.php");
            },1400);

        }
    </script>
</head>
<body class="container">
<?php
include_once "page_parts/header.php";
?>

<?php
include_once "page_parts/login_checker.php";
?>

<div class="page_content">

<?php

	 // if(isset($_GET[]){

    $_SESSION['selected-thesis']=$_POST['selected-thesis'];


    $title= $_SESSION['selected-thesis'];
	$title2=$_POST['teacher_id'];
   echo"<br>Chat για την διπλωματική με id: ".$title;

	  
	?>


 <body>
   <h2>Καλωσήρθατε, <span style="color:blue"><?php echo 'user: '.$title2; ?></span></h2>
     </br></br>

		<div id="chatbox" name="chatbox">
        </div>
   <form  action="">


       <br>
        Share Message:
        <input type="text" id="usermsg" name="usermsg">
        <br>



  </form>
   <button type="button" onclick="foo()">SEND</button>



	</body>
	</html>

