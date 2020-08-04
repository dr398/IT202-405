<?php
include("header.php");

$email=$_SESSION["user"]["email"];
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'account_number');
?>
<h2>Make a Deposit</h2>

    <form method="POST">
        <label for="name">Account
        </label>
        <input type="text" id="name" name="name" value="<?php echo $account; ?>">

        <label for="balance">Amount
            <input type="number" id="balance" name="Balance" />
        </label>
        <input type="submit" name="Deposit" value="Deposit"/>
    </form>

<?php
require("common.inc.php");
if(isset($_POST["Deposit"])) {
    $name = $_POST["Name"];
    $balance = $_POST["Balance"];
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db = new PDO($connection_string, $dbuser, $dbpass);
        $stmt1 = $db->prepare("SELECT * FROM Accounts where account_number=:acc");
        $stmt1->execute(array(
            ":acc" => $name
        ));
        $result = $stmt1->fetchAll();
        $amount = $result[0]["Balance"];
        $amount = $amount + $balance;
        if (!empty($name) && !empty($balance)) {

            try {

                $balance = $balance * -1;
                $stmt = $db->prepare("INSERT INTO Transactions (act_src_id, act_dest_id,acc,amount,expected_total) VALUES (:acc_num,:accnum1, :acctype,:balance,:exp_balance)");
                $result = $stmt->execute(array(
                    ":acc_num" => "000000000000",
                    ":accnum1" => $name,
                    ":type" => "Deposit",
                    ":balance" => $balance,
                    ":expected_balance" => $balance
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    var_dump($e);
                    echo "setting eee " . $e . "<br>";
                }
                $balance = $balance * -1;
                echo $balance;
                $stmt2 = $db->prepare("INSERT INTO Transactions (act_src_id, act_dest_id,type,amount,expected_total) VALUES (:acc_num,:accnum1, :acctype,:balance,:exp_balance)");
                $result1 = $stmt2->execute(array(
                    ":acc1" => $name,
                    ":acc" => "000000000000",
                    ":type" => "Deposit",
                    ":balance" => $balance,
                    ":expected_balance" => $amount
                ));
                $e = $stmt2->errorInfo();
                if ($e[0] != "00000") {
                    var_dump($e);
                    $stmt2->debugDumpParams();
                }
                $stmt = $db->prepare("update Accounts set Balance= (SELECT sum(Amount) FROM Transactions WHERE act_src_id=:accnum) where account_number=:acc_num");
                $result = $stmt->execute(array(
                    ":acc_num" => $name
                ));
                if ($result) {
                    echo "Successfully inserted: " . $name;
                    header("Location: home.php");
                } else {
                    echo "Error inserting record";
                }
            } catch (Exception $e) {
                echo "Error inserting record 1";
                echo $e->getMessage();
            }
        } else {
            echo "<div>Account name and amount must not be empty. Amount of deposit should be at least $5.<div>";
        }
    }
    $stmt = $db->prepare("SELECT * FROM Accounts");
    $stmt->execute();
    ?>
<?php include 'footerinfo.php';?>
