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
require("common.inc.php");
//find the max id in the table
$query = "SELECT MAX(id) as max from Accounts";
$stmt = getDB()->prepare($query);
$stmt->execute();
$r = $stmt->fetch(PDO::FETCH_ASSOC);
$max = (int)$r["max"];//should really check that this value is given correctly, I'm unsafely using it
$max += 1;//increment by 1 (since this should be the new id that'll get automatically generated
//pad the number with 0s to the left (this will fit the requirement and be unique since it's based on id
$account_number = str_pad($str,12,"0",STR_PAD_LEFT);//read it https://www.w3schools.com/php/func_string_str_pad.asp
//insert the new account number and associate it with the logged in user
$query = "INSERT INTO Accounts(account_number, id) VALUES(:an, :id)";
$stmt = getDB()->prepare($query);
$stmt->execute(array(":an"=>$account_number, ":id"=>$_SESSION["id"]));
//check your DB, account should be created successfuly 
}
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
        $query = file_get_contents(__DIR__ . "/queries/Insert_table_Accounts.sql");
        if(isset($query) && !empty($query)) {
            $stmt = getDB()->prepare($query);
            $result = $stmt->execute(array(
                ":name" => $name,
                ":balance" => $balance
            ));
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                if ($result) {
                    echo "Successfully inserted new account: " . $name;
                } else {
                    echo "Error inserting record";
                }
            }
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
