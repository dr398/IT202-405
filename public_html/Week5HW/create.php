<form method="POST">
	<label for="account">Account Name
	<input type="text" id="account" name="name" />
	</label>
	<label for="d">Deposit
	<input type="number" id="d" name="deposit" />
	</label>
	<input type="submit" name="created" value="Create Account"/>
</form>

<?php
if(isset($_POST["created"])){
    $name = $_POST["name"];
    $quantity = $_POST["deposit"];
    if(!empty($name) && !empty($deposit)){
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("INSERT INTO Accounts (name, deposit) VALUES (:name, :deposit)");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":deposit" => $deposit
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully created new account: " . $name;
                }
                else{
                    echo "Error creating account";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Name and deposit must not be empty.";
    }
}
?>
