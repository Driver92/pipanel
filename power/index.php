<?php
	// Initialize settings
	require "../config.php";
	
	// Load locale
	include "../locale/".LANGUAGE.".lang.php";
	
	function render_restart(){
		global $locale;
		?>
		<script>
		$(document).ready(function() {
			var count = 60;
			var countdown = setInterval(function(){
				$("span.countdown").html(count + " <?php echo $locale['restart_text']; ?>");
				if (count == 0) {
					clearInterval(countdown);
					window.open('../index.php', "_self");
				}
				count--;
			}, 1000);
		});
		</script>
			<h3 class="card-header text-center"><?php echo $locale['restart_header']; ?></h3>
			<div class="card-body">
			<p class="text-center">
			<i class="fa fa-sync fa-spin fa-8x mt-5 mb-5"></i>
			<br /><span class="countdown"><?php echo $locale['loading']; ?></span>
			</p>
			</div>
		<?php
	}

	function render_shutdown(){
		global $locale;
		?>
			<h3 class="card-header text-center"><?php echo $locale['shutdown_header']; ?></h3>
			<div class="card-body">
			<p class="text-center text-danger">
			<i class="fa fa-power-off fa-8x mt-5 mb-5"></i>
			<br /><strong><?php echo $locale['shutdown_text']; ?></strong>
			</p>
			</div>
		<?php
	}
?>
<!doctype html>
<html lang="<?php echo $locale['html_lang']; ?>">
  <head>
    <!-- Required tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="theme-color" content="#343a40">
	<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
	
	<!-- JQuery -->
	<script src="../includes/jquery-3.3.1.min.js"></script>
	
    <!-- CSS -->
    <link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../includes/fontawesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../includes/styles.css">

    <title>Pi Panel - <?php echo $locale['powerswitch']; ?></title>

  </head>
  <body>
	<main>
	<div class="container">
		<div class="card text-white bg-dark">
		<?php
			if (isset($_POST['confirm']) && isset($_GET['action'])) {
				switch ($_GET['action']) {
					case '0':
						render_restart();
						echo "<script>var powercontrol = 0;</script>";
					break;
					case '1':
						render_shutdown();
						echo "<script>var powercontrol = 1;</script>";
					break;
					default:
						header('Location: ../index.php');
						die();
					break;
				} 
				?>
				<script>
				$(document).ready(function() {
					setTimeout(function() {
						$.post('switch.php', {action: powercontrol});
					}, 2000);
				});
				</script>
			<?php
			} elseif (!isset($_GET['action'])) {
				header('Location: ../index.php');
				die();
			} else {
			?>
				<h3 class="card-header text-center"><?php echo $locale['confirm_action']; ?></h3>
				<div class="card-body">
				<h4 class='pt-3 pb-3 text-center'><?php echo $_GET['action'] == 0 ?  "<i class='fa fa-sync fa-4x mb-3'></i><br />".$locale['restart_confirm'] : "<i class='fa fa-power-off fa-4x mb-3'></i><br />".$locale['shutdown_confirm']; ?></h4>
				</div>
				<div class="card-footer">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=<?php echo $_GET['action']; ?>" method="post">
				<div class="row">
				<div class="col-sm-6">
				<button type="submit" name="confirm" class="btn btn-success btn-block mt-1"><i class="fa fa-check-circle fa-fw"></i> <?php echo $locale['confirm']; ?></button>
				</div>
				<div class="col-sm-6">
				<a class="btn btn-danger btn-block mt-1" href="../index.php"><i class="fa fa-times-circle fa-fw"></i> <?php echo $locale['cancel']; ?></a>
				</div>
				</div>
				</form>
				</div>
			<?php 
			}
		?>
		</div>
	</div>
	</main>

    <!-- Popper JS, Bootstrap JS -->
    <script src="../includes/popper.min.js"></script>
    <script src="../includes/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>