<?php

	// Create Custom folder if does not exist
	$dir = "../app/Custom";
	if (!file_exists($dir) && !is_dir($dir)) {
	    mkdir($dir);
	}

	// Create helper class
	copy(dirname(__FILE__) . '/StripeHelper.php', $dir . '/StripeHelper.php');
	

?>