<?php
if (isset($_POST['action'])) {
	if ($_POST['action'] == 1) {
		system('sudo /sbin/shutdown -h now');
	} else {
		system('sudo /sbin/shutdown -r now');
	}
} else {
	header('Location: ../index.php');
	die();
}
?>