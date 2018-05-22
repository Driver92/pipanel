<h3>About</h3>
Pi Panel is a simple responsive web-based panel for your Raspberry Pi. It can give you a quick overlook about your CPU temp, CPU (average) usage, CPU clock speed, memory usage, storage space, and voltage. Rebooting and shutting down your Raspberry is also possible with it (further configuration needed).

<h3>Preview</h3>
<img src="https://i.imgur.com/IMHKcu7.png" alt="preview">

<h3>Setup</h3>
All you need is a Web server (Apache2) with PHP and shell execution (usually enabled by default). Simply copy the files and directories to your web folders (/var/www/html) root, or to a subdirectory. It was tested on the latest Raspbian (9.4), on Raspberry Pi 3 Model B Plus, but it may also work on other Linux distros, and Raspberry models.

For the reboot, shutdown and voltage functions to work, edit your sudoers (/etc/sudoers) file:
<code>sudo visudo</code>

And add these lines:
<code>www-data ALL=NOPASSWD:/sbin/shutdown
www-data ALL=NOPASSWD:/opt/vc/bin/vcgencmd measure_volts</code>

For further settings, just edit the config.php file:
- You can change the maximum clock speed (1400 Mhz by default for model B+)
- Changing the voltage (5V by default)
- Change language (English by default, language files can be added by creating your langugage.lang.php in the locale folder)
- Custom menu items for the hamburger menu

<h3>Credits</h3>
It was built using:
- Bootstrap
- Fontawesome
- Circliful

It was also somewhat based on the <a href="https://bitbucket.org/baldisos/raspberry-pi-control-panel">Raspberry Pi Control Panel</a> project.