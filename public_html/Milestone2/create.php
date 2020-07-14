<script src="js/script.js"></script>
<!-- note although <script> tag "can" be self terminating some browsers require the
full closing tag-->
<form method="POST" onsubmit="return validate(this);">
    <label for="account">Account Name
        <input type="text" id="account" name="name" required />
    </label>
    <label for="b">Balance
        <input type="number" id="b" name="balance" required min="0" />
    </label>
    <input type="submit" name="created" value="Create Account"/>
</form>
<?php


if(isset($_POST["created"])) {
    $name = "";
    $balance = -1;
    if(isset($_POST["name"]) && !empty($_POST["name"])){
        $name = $_POST["name"];
    }
    if(isset($_POST["balance"]) && !empty($_POST["balance"])){
        if(is_numeric($_POST["balance"])){
            $balance = (int)$_POST["balance"];
        }
    }
    //If name or balance is invalid, don't do the DB part
    if(empty($name) || $balance < 0 ){
        echo "Name must not be empty and balance must be greater than or equal to 0";
        die();//terminates the rest of the script
    }
    try {
require("common.inc.php");
//find the max id in the table
$query = "SELECT MAX(id) as max from Accounts";
echo "<br>$query<br>";
$stmt = getDB()->prepare($query);
$stmt->execute();
echo var_export($stmt->errorInfo(), true);
$r = $stmt->fetch(PDO::FETCH_ASSOC);
$max = (int)$r["max"];//should really check that this value is given correctly, I'm unsafely using it
$max += 1;//increment by 1 (since this should be the new id that'll get automatically generated
//pad the number with 0s to the left (this will fit the requirement and be unique since it's based on id
$account_number = str_pad($str,12,"0",STR_PAD_LEFT);//read it https://www.w3schools.com/php/func_string_str_pad.asp
//insert the new account number and associate it with the logged in user
$query = "INSERT INTO Accounts(account_number, user_id, name) VALUES(:an, :id, :name)";
echo "<br>$query<br>";
$stmt = getDB()->prepare($query);
$stmt->execute(array(":an"=>$account_number, ":id"=>$_SESSION["user"]["id"], ":name"=>$name));
echo var_export($stmt->errorInfo(), true);
$worldAcct = 000000000000;
$query = "Select id from Accounts where account_number = '000000000000'"; //TODO fetch world account from DB so we can get the ID, I defaulted to -1 so you implement this portion. Do not hard code the value here.
 echo "<br>$query<br>";
$stmt = getDB()->prepare($query);
$stmt->execute();
echo var_export($stmt->errorInfo(), true);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$worldAcct = $result["id"];
//end fetch world account id

        $query = "INSERT INTO Transactions(act_id_src, act_id_dest,`change`, `type`) VALUES (:src, :dest, :change, :type)";
         echo "<br>$query<br>";
        
       
        if(isset($query) && !empty($query)) {
            $stmt = getDB()->prepare($query);
//part 1
$balance *= -1;//flip
            $result = $stmt->execute
            (array(
                ":src" => $worldAcct,
                ":dest" => $max, //<- should really get the last insert ID from the account query, but $max "should" be accurate
                ":change"=>$balance,
                ":type"=>"deposit" //or it can be "create" or "new" if you want to distinguish between deposit and opening an account

            )
         );
echo var_export($stmt->errorInfo(), true);
  //part 2
$balance *= -1;//flip
            $result = $stmt->execute(array(
                ":src" => $max,
                ":dest" => $worldAcct, //<- should really get the last insert ID from the account query, but $max "should" be accurate
":change"=>$balance,
":type"=>"deposit", //or it can be "create" or "new" if you want to distinguish between deposit and opening an account
            ));
echo var_export($stmt->errorInfo(), true);
//get new balance
$query = "SELECT SUM('change') as balance from Transactions where act_src_id = :id";
 echo "<br>$query<br>";
$stmt = getDB()->prepare($query);
$stmt->execute([":id"=>$max]);
echo var_export($stmt->errorInfo(), true);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
//TODO, should properly check to see if we have data and all
$sum = (int)$result["balance"];
//update balance
$query = "UPDATE Accounts set balance = :bal where id = :id";
 echo "<br>$query<br>";
$stmt = getDB()->prepare($query);
$stmt->execute([":bal"=>$sum, ":id"=>$max]);
echo var_export($stmt->errorInfo(), true);
            
        }
        else{
            echo "Failed to find Insert_table_Accounts.sql file";
        }
    }
    catch (Exception $e){
        echo $e->getMessage();
 
    }
}
?>
