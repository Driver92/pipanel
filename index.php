<?php
	// Initialize settings
	require "config.php";
	
	// Load locale
	include "locale/".LANGUAGE.".lang.php";
	
	// CPU Temperature
	$temp = shell_exec('cat /sys/class/thermal/thermal_zone*/temp');
	$temp = round($temp / 1000);
	
	// CPU Clock
	$clock = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq');
	$clock = round($clock / 1000);
	$clock_text = $clock;
	$clock = (int)($clock / (CLOCK * 0.01));

	// CPU Usage (Average load)
	$cpuusage = 100 - shell_exec("vmstat | tail -1 | awk '{print $15}'");
	
	// Storage
	$storage = shell_exec("df -k / | tail -1 | awk '{print $5}'");
	$storage = str_replace("%", "", $storage);
	
	// Voltage
	$voltage = shell_exec('sudo /opt/vc/bin/vcgencmd measure_volts');
	$voltage = explode("=", $voltage);
	$voltage = $voltage[1];
	$voltage = substr($voltage,0,-2);
	$voltage_text = round($voltage, 1);
	$voltage = (int)(($voltage * 100) / VOLTAGE);

	// Memory Usage
	$memory_total = shell_exec("free -m | head -2 | tail -1 | awk '{print $2}'");
	$memory_used = shell_exec("free -m | head -2 | tail -1 | awk '{print $3}'");
	$memory = (int)($memory_used / ($memory_total * 0.01));
	
	// Uptime
	$uptimedata = shell_exec('uptime');
	$uptime = explode(' up ', $uptimedata);
	$uptime = explode(',', $uptime[1]);
	//$uptime = $uptime[0].', '.$uptime[1];
	$uptime = $uptime[0];
?>
<!doctype html>
<html lang="<?php echo $locale['html_lang']; ?>">
  <head>
    <!-- Required tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="theme-color" content="#343a40">
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	
	<!-- JQuery -->
	<script src="includes/jquery-3.3.1.min.js"></script>
	
    <!-- CSS -->
    <link rel="stylesheet" href="includes/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="includes/fontawesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="includes/styles.css">
	<link rel="stylesheet" href="includes/circliful/css/jquery.circliful.css">

    <title>Pi Panel</title>
	
	<!-- Circliful -->
	<script>
	$(document).ready(function() {
		$('#cpu-temp').circliful({
			animation: 1,
            animationStep: 5,
			text: 'CPU',
			percentageY: 100,
			textY: 120,
			replacePercentageByText: '<?php echo $temp; ?>°C',
			progressColor: {20: '#CC9487', 40: '#FA6C00', 60: '#FF6C99'}
        });
		$('#cpu-usage').circliful({
			animation: 1,
            animationStep: 5,
			text: 'CPU',
			percentageY: 100,
			textY: 120,
			progressColor: {20: '#CC9487', 40: '#FA6C00', 60: '#FF6C99'}
        });
		$('#cpu-clock').circliful({
			animation: 1,
            animationStep: 5,
			text: '<?php echo $locale['clock']; ?>',
			percentageY: 100,
			textY: 120,
			replacePercentageByText: '<?php echo $clock_text; ?>Mhz',
			progressColor: {20: '#CC9487', 40: '#FA6C00', 60: '#FF6C99'}
        });
		$('#ram-usage').circliful({
			animation: 1,
            animationStep: 5,
			text: 'RAM',
			percentageY: 100,
			textY: 120,
			progressColor: {20: '#CC9487', 40: '#FA6C00', 60: '#FF6C99'}
        });
		$('#voltage').circliful({
			animation: 1,
            animationStep: 5,
			text: '<?php echo $locale['voltage']; ?>',
			percentageY: 100,
			textY: 120,
			replacePercentageByText: '<?php echo $voltage_text; ?>V',
			progressColor: {20: '#CC9487', 40: '#FA6C00', 60: '#FF6C99'}
        });
		$('#storage').circliful({
			animation: 1,
            animationStep: 5,
			text: 'SDCard',
			percentageY: 100,
			textY: 120,
			progressColor: {20: '#CC9487', 40: '#FA6C00', 60: '#FF6C99'}
        });
	});
	</script>
  </head>
  <body>
	<main>
	<div class="container">
		<div class="card text-white bg-dark">
		  <h3 class="card-header text-center"><img src="images/raspberry.svg" class="pi-logo" alt="Logo">Pi Panel
		  <a class="btn btn-link text-white float-right" href="<?php echo $_SERVER['PHP_SELF']; ?>" title="<?php echo $locale['refresh']; ?>"><i class="fa fa-sync"></i></a>
		  <div class="dropdown float-left">
		  <button class="btn btn-link text-white" type="button" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
		  <div class="dropdown-menu">
			<?php echo $menu; ?>
			<a class="dropdown-item" href="#" data-toggle="modal" data-target="#aboutpopup"><i class="fa fa-question-circle fa-fw mr-3"></i><?php echo $locale['about']; ?></a>
		  </div>
		  </div>
		  </h3>
		  <div class="card-body">
		  <div class="text-center"><i class="fa fa-plug"></i> <strong><?php echo $locale['uptime']; ?>:</strong> <?php echo $uptime; ?></div>
		  <div class="row">
		  <div class="col-xs-12 col-sm-6 col-md-4">
			<div id="cpu-temp" data-percent="<?php echo $temp; ?>"></div>
		  </div>
		  <div class="col-xs-12 col-sm-6 col-md-4">
			<div id="cpu-usage" data-percent="<?php echo $cpuusage; ?>"></div>
		  </div>
		  <div class="col-xs-12 col-sm-6 col-md-4">
			<div id="cpu-clock" data-percent="<?php echo $clock; ?>"></div>
		  </div>
		  <div class="col-xs-12 col-sm-6 col-md-4">
			<div id="ram-usage" data-percent="<?php echo $memory; ?>"></div>
		  </div>
		  <div class="col-xs-12 col-sm-6 col-md-4">
			<div id="storage" data-percent="<?php echo $storage; ?>"></div>
		  </div>
		  <div class="col-xs-12 col-sm-6 col-md-4">
			<div id="voltage" data-percent="<?php echo $voltage; ?>"></div>
		  </div>
		  </div>
		  </div>
		  <div class="card-footer">
		  <div class="row">
		  <div class="col-sm-6">
		  <a class="btn btn-primary btn-block mt-1" href="power/index.php?action=0"><i class="fa fa-redo fa-fw"></i> <?php echo $locale['restart']; ?></a>
		  </div>
		  <div class="col-sm-6">
		  <a class="btn btn-danger btn-block mt-1" href="power/index.php?action=1"><i class="fa fa-power-off fa-fw"></i> <?php echo $locale['shutdown']; ?></a>
		  </div>
		  </div>
		  </div>
		</div>
	</div>
	</main>
	<div class="modal fade" id="aboutpopup" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title"><?php echo $locale['about']; ?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body text-center">
			<h3 class="mb-0"><img src="images/raspberry.svg" class="pi-logo-about" alt="Logo"><br />Pi Panel v1.0</h3>
			<small class="text-muted">A simple web-based panel for your Raspberry Pi.</small>
			<p class="mt-3 mb-3">
			<a class="btn btn-secondary" href="https://github.com/Driver92/pipanel" target="_blank"><i class="fab fa-github"></i> Github</a>
			<a class="btn btn-secondary" href="https://github.com/Driver92/pipanel/blob/master/README.md" target="_blank"><i class="fa fa-book"></i> Readme</a>
			</p>
			<small class="text-muted">Developed by Daniel D.
			<br />Published without warranties under <a href="https://www.gnu.org/licenses/gpl-3.0.html" target="_blank">GNU AGPL v3</a>.</small>
		  </div>
		</div>
	  </div>
	</div>

    <!-- Popper JS, Bootstrap JS, Circliful JS -->
    <script src="includes/popper.min.js"></script>
    <script src="includes/bootstrap/js/bootstrap.min.js"></script>
	<script src="includes/circliful/js/jquery.circliful.min.js"></script>
  </body>
</html>
