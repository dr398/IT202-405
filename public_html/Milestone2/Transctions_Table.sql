$query = "create table if not exists `Transactions`(
        `AccountSource`   not null unique,
        `AccountDest` varchar(30) not null unique,
        `Amount` varchar(60) default 0,
        `Type` int not null default 0,
	`Total` int not null default 0,
	PRIMARY KEY (`Id`)
        ) CHARACTER SET utf8 COLLATE utf8_general_ci";
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$stmt = $db->prepare($query);
print_r($stmt->errorInfo());
$r = $stmt->execute();
