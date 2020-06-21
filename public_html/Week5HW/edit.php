<?php
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$thingId = -1;
$result = array();
require("common.inc.php");
if(isset($_GET["thingId"])){
    $thingId = $_GET["thingId"];
    $stmt = $db->prepare("SELECT * FROM Emails where id = :id");
    $stmt->execute([":id"=>$thingId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "No account selected for change.";
}
?>

    <form method="POST">
        <label for="thing">New Product
            <input type="text" id="email" name="email" value="<?php echo get($result, "email");?>" />
        </label>
        <label for="d">Deposit
            <input type="number" id="d" name="deposit" value="<?php echo get($result, "deposit");?>" />
        </label>
        <label for="balance">Balance
            <input type="number" id="b" name="balance" value="<?php echo get($result, "balance");?>" />
        </label>
        <input type="submit" name="updated" value="Update account"/>
    </form>

<?php
if(isset($_POST["updated"])){
    $email = $_POST["email"];
    $deposit = $_POST["deposit"];
    $balance = $_POST["balance"];
    if(!empty($email) && !empty($deposit) && !empty($balance)){
        try{
            $stmt = $db->prepare("UPDATE Emails set email = :email, deposit=:deposit, balance=:balance where id=:id");
            $result = $stmt->execute(array(
                ":email" => $email,
                ":deposit" => $deposit,
                ":balance" => $balance,
                ":id" => $thingId
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully updated thing: " . $email;
                }
                else{
                    echo "Error updating record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Fields must not be empty.";
    }
}
?>
