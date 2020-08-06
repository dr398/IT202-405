<?php
include("header.php");

try{
    $query = file_get_contents(__DIR__ . "/Accounts_Table.sql");
    if(isset($query) && !empty($query)) {
        $stmt = getDB()->prepare($query);
        $r = $stmt->execute();
        $e = $stmt->errorInfo();
        if($e[0] == "00000"){
            echo "Table created successfully or already exists";
        }
        else{
            echo "Error creating table";
            echo "<pre>" . var_export($e, true) . "</pre>";
        }
    }
    else{
        echo "Failed to find Accounts_Table.sql file";
    }
}
catch (Exception $e){
    echo $e->getMessage();
}
?>
<?php include 'footerinfo.php';?>
