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
        New Username: <br>
        <input type="text" name="usernameBox">  <br>
        New Password: <br>
        <input type="text" name="passwordBox">  <br>      
        <p></p>
        
        Things to do:
    <p></p>          
        <input type="radio" name="action" value="request"> Request new Account <br>
        <input type="radio" name="action" value="delete"> Delete Account <br>
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


if(isset($_POST['passwordBox'])){
  $newPassword = $_POST['passwordBox'];
}
if(isset($_POST['usernameBox'])){
  $newUsername = $_POST['usernameBox'];
}

require('config.php');
//echo "Loaded Host: " . $host;
$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
  try{
    $db = new PDO($conn_string, $username, $password);
    
      
      //THINGS TO DO
      if($action == "request"){
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT); 
        $insert_query2 = "INSERT INTO CustomerAccounts (isAdmin, id, username, password, balance, transactionHistory) VALUES ('0', NULL, '$newUsername', '$hashed', 0, 'NULL');";
        
    
      $stmt = $db->prepare($insert_query2);    
      print_r($stmt->errorInfo());
      $r = $stmt->execute();
      
        if($r > 0){
          header("Location: registered.php");      
        }
        else
        {
          header("Location: registeredfail.php");
        }
      
      }
      if($action=="delete"){
            
        $transTable = $_SESSION['transTable'];
        $delete_query="DELETE FROM CustomerAccounts WHERE id = '$id'";
        $stmt = $db->prepare($delete_query);
        $r = $stmt->execute();
        
        $delete_queryHistory="DROP TABLE $transTable";
        $stmt = $db->prepare($delete_queryHistory);
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
