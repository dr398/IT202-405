<?php
session_start();

if(isset($_POST['action'])){
  $action = $_POST['action'];
}
else{
  $action = "none";
}

if(isset($_POST['amountWithdraw'])){
  $amountWithdraw = $_POST['amountWithdraw'];
}else{
  $amountWithdraw = 0;
}







require('config.php');
//echo "Loaded Host: " . $host;
$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
  try{
    $db = new PDO($conn_string, $username, $password);
    $id = $_SESSION['id'];
    $stmt = $db->query("SELECT * FROM CustomerAccounts WHERE id = '$id'");
    $result = $stmt->fetch();
    if(is_numeric($amountWithdraw) && $amountWithdraw >= 0){
      echo $amountWithdraw." IS A NUMBER! <br>";
      //deposit
      $startBalance = $result['balance'];
      $endBalance =  $startBalance - $amountWithdraw;
      $delta = $endBalance-$startBalance;
    
      $insert_query = "UPDATE CustomerAccounts SET balance = '$endBalance' WHERE id = '$id'";
      $stmt = $db->prepare($insert_query);
      $r = $stmt->execute();
      $_SESSION['balance'] = $endBalance;
      $amountWithdraw = 0;
      
      
      
      $transTable = $_SESSION['transTable'];
      
      //$insert_query = "INSERT INTO $transTable (id, username, password) VALUES (NULL, '$Bankusername', '$hashed');";
      $insert_queryHist = "INSERT INTO $transTable (`id`, `accountSource`, `accountDest`, `change`, `memo`, `total`) VALUES (NULL, '$id', '$id', '$delta', 'Withdraw', '$endBalance');";
      //"INSERT INTO $transTable (id, accountSource, accountDest, change, memo, total) VALUES ('$id', 10, 10, 10, Deposit, 10);";
      
      $stmt = $db->prepare($insert_queryHist);
      $r = $stmt->execute();
      
         header("Location: transactionSuccess.php");
    }
    else{
      echo $amountWithdraw." IS NOT A NUMBER! <br>";
      //return
    }

      /*
      //Places to go
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
        echo "You have been logged out";
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
      
      
  }
  catch (Exception $e){
    echo $e->getMessage();
    exit("Something went wrong");
  }

  echo "Session Data: ";
  print_r($_SESSION);
?>  
