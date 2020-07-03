<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function do_bank_action($AccountSource, $AccountDest){
	require("config.php");
	$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
	$db = new PDO($conn_string, $username, $password);
	$a1total = 0;//TODO get total of account 1
	$a2total = 0;//TODO get total of account 2
	$query = "INSERT INTO `Transactions` (`AccountSource`, `AccountDest`) 
	VALUES(:p1acctsrc, :p1acctdest), 
			(:p2acctsrc, :p2acctdest)";
	
	$stmt = $db->prepare($query);
	$stmt->bindValue(":p1acctsrc", $AccountSource);
	$stmt->bindValue(":p1acctdest", $AccountDest);
	//flip data for other half of transaction
	$stmt->bindValue(":p2acctsrc", $AccountDest);
	$stmt->bindValue(":p2cctdest", $AccountSource);
	$result = $stmt->execute();
	echo var_export($result, true);
	echo var_export($stmt->errorInfo(), true);
	return $result;
}
?>
<form method="POST">
	<input type="text" name="AccountSource" placeholder="Account Number">
	<!-- If our sample is a transfer show other account field-->
	<input type="text" name="AccountDest" placeholder="Other Account Number">
	<?php endif; ?>
	
	<input type="number" name="amount" placeholder="$0.00"/>
	<input type="hidden" name="type" value="<?php echo $_GET['type'];?>"/>
	
	<!--Based on sample type change the submit button display-->
	<input type="submit" value="Move Money"/>
</form>

<?php
if(isset($_POST['type']) && isset($_POST['AccountSource']) && isset($_POST['amount'])){
	$type = $_POST['type'];
	$amount = (int)$_POST['amount'];
	switch($type){
		case 'deposit':
			do_bank_action("000000000000", $_POST['account1'], ($amount * -1), $type);
			break;
		case 'withdraw':
			do_bank_action($_POST['AccountSource'], "000000000000", ($amount * -1), $type);
			break;
		case 'transfer':
			//TODO figure it out
			break;
	}
}
?>
