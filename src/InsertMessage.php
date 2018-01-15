 <?php
   session_start();
include "classc.php";

 $_SESSION['txtArea']= $_POST['txtArea'];
 $text= $_SESSION['txtArea'];
     echo"<br>egrapse ".$text;

		$chat=new chat();
		  $chat->settitle($_SESSION['title']);
		 $chat->setchatuserId($_SESSION['id_role']);
		 $chat->setchatMessage($_SESSION['txtArea']);
		$chat->InsertChatMessage();
		
		$id= $_SESSION['id_role'];
		$title=$_SESSION['title'].$id;
		 echo"<br>mohkee".$title;
		 

		 
?>