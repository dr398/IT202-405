<form method="POST">
    <label for="email">Email
        <input type="text" id="email" name="email" />
    </label>
    <label for="d">Deposit
        <input type="number" id="d" name="deposit" />
    </label>
    <input type="submit" name="created" value="Submit New Account"/>
</form>

<?php
if(isset($_POST['created'])){
    $product = $_POST['email'];
    $price = $_POST['deposit'];
    if(!empty($email) && !empty($deposit)){
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("INSERT INTO Emails (email, deposit) VALUES (:email, :deposit)");
            $result = $stmt->execute(array(
                ':email' => $email,
                ':depsoit' => $deposit
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully created new account: " . $email;
                }
                else{
                    echo "Error creating new account";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Email and deposit must not be empty.";
    }
}
?>
