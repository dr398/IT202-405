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
    
$query = "SELECT MAX(id) as max from Accounts";
$stmt = getDB()->prepare($query);
$stmt->execute();
echo var_export($stmt->errorInfo(), true);
$r = $stmt->fetch(PDO::FETCH_ASSOC);
$max = (int)$r["max"];
$max += 1;//gives us what "should" be the next id
        
?>
