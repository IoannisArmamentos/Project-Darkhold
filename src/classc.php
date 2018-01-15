<?php
class chat{
    private $chatuserID,$chatMessage,$title;
    public function getchatuserID(){

        return $this->chatuserID;
    }
    public function setchatuserID($chatuserID){
        $this->chatuserID=$chatuserID;
    }
    public function getchatMessage(){
        return $this->chatMessage;
    }
    public function setchatMessage($chatMessage){
        $this->chatMessage=$chatMessage;
    }
    public function gettitle(){
        return $this->title;
    }
    public function settitle($title){
        $this->title=$title;
    }
    public function InsertChatMessage(){
        try{
            $dbh=new PDO("mysql:host=localhost;bdname:project","root","");
        }catch(Exception $exception){
            die("ERROR");
        }
        try {
            $dbh = new PDO("mysql:host=localhost;dbname=project", "root", "");
            /*** echo a message saying we have connected ***/
            echo 'Connected to database';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
		
 
        $req=$dbh->prepare("INSERT INTO chat(chatuserID,chatMessage,title) VALUES (:chatMessage,:chatuserID,:title) ");
        $req->execute(array(
            ':chatuserID'=>$this->getchatuserID(),
                ':title'=>$this->gettitle(),
                ':chatMessage'=>$this->getchatMessage()

            ) );
			  echo "<br>id_user: ".$this->getchatuserID();
        echo "<br>diplwmatikh : ".$this->gettitle();
        echo "<br>message : ".$this->getchatMessage();
          
       
		if ($req->execute(array(
            ':chatuserID'=>$this->getchatuserID(),
                ':title'=>$this->gettitle(),
                ':chatMessage'=>$this->getchatMessage()

            )))
{
  // success
  echo"<br> Έβαλε το chat στην βαση";
 
}
else
{
	  echo"<br> δεν εγινε";
  // failure
}
     
    }
public function DisplayMessage()  {
	 try{
            $dbh=new PDO("mysql:host=localhost;bdname:flashoperationploint","root","");
        }catch(Exception $exception){
            die("ERROR");
        }
        try {
            $dbh = new PDO("mysql:host=localhost;dbname=flashoperationploint", "root", "");
            /*** echo a message saying we have connected ***/
            echo 'Connected to database';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
		$ChatReq=$dbh->prepare("SELECT * FROM chat ORDER BY ChatId DESC");
		$ChatReq->execute();
		while ($DataChat= $ChatReq->fetch()){
			$UserReq->$dbh->prepare("SELECT * FROM user WHERE id=:chatuserID");
		    $UserReq->execute(array(
			'id_role'=>$DataChat['chatuserID']
			));
			$DataUser=$UserReq->fetch();
			?>
			<span class="UsernameS"><?php echo $DataUser['Username'];?></span></br>
			<span class="ChatMessages"><?php echo $DataChat['ChatText'];?></span></br>
			<?php
		}
}
}
?>
