<?php
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$thingId = -1;
$result = array();
function get($arr, $key){
    if(isset($arr[$key])){
        return $arr[$key];
    }
    return "";
}
if(isset($_GET["accountId"])){
    $thingId = $_GET["accountId"];
    $stmt = $db->prepare("SELECT * FROM Accounts where id = :id");
    $stmt->execute([":id"=>$accountId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "No accountId provided in url.";
}
?>

<form method="POST">
	<label for="account">Account Name
	<input type="text" id="account" name="name" value="<?php echo get($result, "name");?>" />
	</label>
	<label for="d">Deposit
	<input type="number" id="d" name="deposit" value="<?php echo get($result, "deposit");?>" />
	</label>
	<input type="submit" name="updated" value="Update Account"/>
</form>

<?php
if(isset($_POST["updated"])){
    $name = $_POST["name"];
    $deposit = $_POST["deposit"];
    if(!empty($name) && !empty($deposit)){
        try{
            $stmt = $db->prepare("UPDATE Accounts set name = :name, deposit=:deposit where id=:id");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":deposit" => $deposit,
                ":id" => $accountId
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully updated account: " . $name;
                }
                else{
                    echo "Error updating account";
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
