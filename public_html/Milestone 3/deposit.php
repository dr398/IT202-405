<?php
include("header.php");

$email=$_SESSION["user"]["email"];
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'account_number');
?>
<h2>Deposit</h2>

    <form method="POST">
        <label for="name">Account
        </label>
        <input type="text" id="name" name="name" value="<?php echo $account; ?>">

        <label for="balance">Amount
            <input type="number" id="balance" name="balance" />
        </label>
        <input type="submit" name="deposit" value="deposit"/>
    </form>

<?php

<select name = "Accounts">
<?php
while($rows = $resultSet->fetch_assoc())
(
    $name = $rows['name'];
    echo "<option value = '$name'>$name</option>;
)
?>
</select>

if(isset($_POST["deposit"])) {
    echo var_export($_POST, true);
    $name = $_POST["name"];
    $balance = $_POST["balance"];
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $stmt1 = getDB()->prepare("SELECT * FROM Accounts where account_number=:acc");
        $stmt1->execute(array(
            ":acc" => $name
        ));
        $result = $stmt1->fetchAll();
        $amount = $result[0]["balance"];
        $amount = $amount + $balance;
        if (!empty($name) && !empty($balance)) {

            try {
              
$worldAcct = 000000000000;
$query = "Select id from Accounts where account_number = '000000000000'"; //TODO fetch world account from DB so we can get the ID, I defaulted to -1 so you implement this portion. Do not hard code the value here.
 echo "<br>$query<br>";
$stmt = getDB()->prepare($query);
$stmt->execute();
echo var_export($stmt->errorInfo(), true);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$worldAcct = $result["id"];
//end fetch world account id
                
                $balance = $balance * -1;
                $stmt = getDB()->prepare("INSERT INTO Transactions (act_src_id, act_dest_id,amount,expected_total) VALUES (:acc_num,:accnum1, :type,:balance,:expected_balance)");
                $result = $stmt->execute(array(
                    ":acc_num" => $worldAcct,
                    ":accnum1" => $id,
                    ":type" => "deposit",
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
                $stmt2 = getDB()->prepare("INSERT INTO Transactions (act_src_id, act_dest_id,type,amount,expected_total) VALUES (:acc_num,:accnum1, :type,:balance,:expected_balance)");
                $result1 = $stmt2->execute(array(
                    ":acc_num" => $id,
                    ":accnum1" => $worldAcct,
                    ":type" => "deposit",
                    ":balance" => $balance,
                    ":expected_balance" => $amount
                ));
                $e = $stmt2->errorInfo();
                if ($e[0] != "00000") {
                    var_dump($e);
                    $stmt2->debugDumpParams();
                }
                $stmt = getDB()->prepare("update Accounts set Balance= (SELECT sum(Amount) FROM Transactions WHERE act_src_id=:accnum) where account_number=:acc_num");
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
    $stmt = getDB()->prepare("SELECT * FROM Accounts");
    $stmt->execute();
    ?>
<?php include 'footerinfo.php';?>
