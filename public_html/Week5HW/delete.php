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
    echo "No account selected for deletion.";
}
?>

    <form method="POST">
        <label for="thing">New Account
            <input type="text" id="email" name="email" value="<?php echo get($result, "email");?>" />
        </label>
        <label for="<br>d">Deposit
            <input type="number" id="d" name="deposit" value="<?php echo get($result, "deposit");?>" />
        </label>
        <label for="<br>balance">Balance
            <input type="number" id="q" name="balance" value="<?php echo get($result, "balance");?>" />
        </label>
        <input type="submit" name="delete" value="Delete account"/>
    </form>

<?php
if(isset($_POST["delete"])){
    $delete = isset($_POST["delete"]);
    $product = $_POST["email"];
    if(!empty($product)) {
        try {
            if ($thingId > 0) {
                $stmt = $db->prepare("DELETE from Emails where id=:id");
                $result = $stmt->execute(array(
                    ":id" => $thingId
                ));
            } else {
                echo "Email " . $email . " does not exist.";
            }
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                echo var_export($result, true);
                if ($result) {
                    echo "Successfully deleted: " . $email;
                } else {
                    echo "Error deleting email";
                }
            }
        }
        catch
            (Exception $e){
                echo $e->getMessage();
            }
    }
    else{
        echo "Email must not be empty.";
    }
}
?>
