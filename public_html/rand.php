<body>
<?php
	function generateKey() {
		$randStr = uniqueid();
		return $randStr;
	}
	echo generateKey();
?>
</body>
