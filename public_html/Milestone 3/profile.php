<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//check if a user is logged in
if(session_status() == PHP_SESSION_ACTIVE && $_SESSION['id'] != '') {
  //echo 'Session is active';
}
else{
  header("Location: loginPrompt.php");
  //echo 'Session is not active';
}
?>

<html>

<head></head>
<body>
  <h1> Profile </h1>


Hello there, <?php echo $_SESSION['user'].", "."userID: ".$_SESSION['id'] ;?>
  <form method="POST">
    <p></p>
        Places to go:
        <nav>
          <a href="landing.php">Home</a> |
          <a href="profile.php">Profile</a> |
          <a href="accounts.php">Accounts</a> |
          <?php 
          if($_SESSION['isAdmin'] == 1)
          {
            echo "<a href='adminUsers.php'>"."All Users";
            //echo Admin Users;
            echo "</a> |";
          }
          ?>
          <a href="transactionHistory.php">Transaction History</a> |
          <a href="deposit.php">Deposit</a> |
          <a href="withdraw.php">Withdraw</a> |
          <a href="transfer.php">Transfer</a> |
          <a href="logout.php">Log Out</a>
        </nav>
    <p></p>  
    <!--              
        <input type="radio" name="action" value="home"> Home Page <br>
        <input type="radio" name="action" value="profile"> Profile Page <br>
  			<input type="radio" name="action" value="deposit" > Deposit Page <br>
  			<input type="radio" name="action" value="withdraw" > Withdraw Page <br>
  			<input type="radio" name="action" value="transfer" > Transfer Page <br>
  			<input type="radio" name="action" value="logOut" > Log Out <br> -->
    <p></p>  
    <!-- <input type="submit" value="Go"/>  -->   
    
    
                   
    <p></p>
        Things to do:
    <p></p>
        <input type="text" name="textbox">  <br>      
        <p></p>          
        <input type="radio" name="action" value="nameChange"> Change Name <br>
        <input type="radio" name="action" value="passwordChange"> Change Password <br>
        <!--<input type="radio" name="action" value="delete"> Delete Account <br>-->
        <!--
  			<input type="radio" name="action" value="deposit" >  <br>
  			<input type="radio" name="action" value="withdraw" >  <br>
  			<input type="radio" name="action" value="transfer" >  <br>
  			<input type="radio" name="action" value="logOut" >  <br>
        -->
        
        
        
    <p></p>  
    <input type="submit" value="Go"/>       
    
    
                  
    
  </form>
  
        
</body>
</html>

<?php
if(isset($_POST['textbox'])){
  $textbox = $_POST['textbox'];
}
if(isset($_POST['action'])){
  $action = $_POST['action'];
}
else{
  $action = "none";
}
$id = $_SESSION['id'];


require('config.php');
//echo "Loaded Host: " . $host;
$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
  try{
    $db = new PDO($conn_string, $username, $password);
    
      
      //PLACES TO GO
      /*
      if($action == "home"){
         header("Location: landing.php");
      }
      if($action == "profile"){
         header("Location: profile.php");
      }
      if($action == "deposit"){
       header("Location: deposit.php");
       
      }
      if($action == "withdraw"){
       header("Location: withdraw.php");       
      }
      if($action == "transfer"){
       header("Location: transfer.php");       
      }
      if($action == "logOut")
      {
        session_start();
        session_unset();
        session_destroy();
        echo "You have been loggeds out";
        echo var_export($_SESSION, true);
        //get session cookie and delete/clear it for this session
        if (ini_get("session.use_cookies")) { 
          $params = session_get_cookie_params(); 
        	//clones then destroys since it makes it's lifetime 
        	//negative (in the past)
          setcookie(session_name(), '', time() - 42000, 
          $params["path"], $params["domain"], 
          $params["secure"], $params["httponly"]); 
          header("Location: logout.php");
        } 
      }      
      */
      
      
      
      
      
      //THINGS TO DO
      if($action == "nameChange"){
        $insert_query = "UPDATE CustomerAccounts SET username = '$textbox' WHERE id = '$id'";
        //$insert_query2 = "UPDATE CustomerAccounts SET username = '$textbox' WHERE id = '$id'";
        $stmt = $db->prepare($insert_query);
        $r = $stmt->execute();
        
          //$_SESSION['user'] = $textbox;
        
        echo "Name changed to ". $textbox."<br>";
      }
      if($action == "passwordChange")
      {
        $hashed = password_hash($textbox, PASSWORD_DEFAULT);
        $insert_query = "UPDATE CustomerAccounts SET password = '$hashed' WHERE id = '$id'";
        $stmt = $db->prepare($insert_query);
        $r = $stmt->execute();
        
          $_SESSION['user'] = $textbox;
        echo "Password changed to ".$textbox."<br>";
      }
      if($action=="delete"){
            
        $delete_query="DELETE FROM CustomerAccounts WHERE id = '$id'";
        $stmt = $db->prepare($delete_query);
        $r = $stmt->execute();
        header("Location: deleteAccount.php");
      }
      
      
  }
  catch (Exception $e){
    echo $e->getMessage();
    exit("Something went wrong");
  }

  echo "Session Data: ";
  print_r($_SESSION);
?>  
