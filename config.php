<?php
// Custom values for your Raspberry Pi model
DEFINE("CLOCK", 1400); // Max clock speed in Mhz
DEFINE("VOLTAGE", 5); // Max voltage in Volts

// Set language
DEFINE("LANGUAGE", "english");

// Hamburger menu-items
$menu = ""; // Initialize menu
// Your custom links below
$menu .= "<a class='dropdown-item' href='https://www.raspberrypi.org/'><i class='fa fa-home fa-fw mr-3'></i>Raspberry Pi</a>";
$menu .= "<a class='dropdown-item' href='../phpmyadmin'><i class='fa fa-database fa-fw mr-3'></i>phpMyAdmin</a>";
