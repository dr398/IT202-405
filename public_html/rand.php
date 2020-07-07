<body>
<?php
	function generateKey() {
		$randStr = unique();
		return $randStr;
	}
	echo generateKey();
?>
</body>
