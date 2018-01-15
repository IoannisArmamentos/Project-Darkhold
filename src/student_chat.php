<html>
<head>
    <?php
    include_once "page_parts/head.php";
    ?>
    <link href="Style.css" type="text/css" rel="stylesheet"/>
    <title>ΣΥΝΟΜΙΛΙΑ ΔΙΠΛΩΜΑΤΙΚΉΣ</title>
</head>
<body class="container">
<?php
include_once "page_parts/header.php";
?>

<?php
include_once "page_parts/login_checker.php";
?>

<div class="page_content">




<h2>Καλωσήρθατε,<span style="color:blue"><?php echo $_SESSION['user_id']; ?></span></h2>
</br></br>

<div id="chatbox" name="chatbox">
    <input type="text" id="chatbox" name="chatbox">
</div>

<form role="form" action="" method="POST" enctype="multipart/form-data">


    <br>

    <input type="text" name="path">
    <br>


    <input  type="submit" id="submit" name="submit" value="Αποθήκευση" onClick= "loadxml();">

    <script type="text/javascript">
        //document.getElementsByClassName('.form')[0].addEventListe‌​ner('submit',functio‌​n(){ alert('Form submitted'); return false; });

        $("#clickMe").bind('click', function () {
            var el = document.getElementById("clickMe");
            alert("hello".$el);
            var txtArea = $("#txtArea").val();
            $.ajax({
                type:"POST",
                url:"InsertMessage.php",
                data:{txtArea:txtArea}
                success: function(data){
                    $("#chatbox").html(data);
                    alert(data);
                    $("#chatbox").load("DispalyMessages.php")
                    $("#txtArea").val(""); //Insert chat log into the #chatbox div
                }
                error: function(){
                    alert('there was an error, write your error handling code here.');
                }
                return false;
        });

setInterval(function(){
$("#chatbox").load("DispalayMessages.php");
}//,1400);

        };)
    </script>";
</form>
</div>
</body>
</html>