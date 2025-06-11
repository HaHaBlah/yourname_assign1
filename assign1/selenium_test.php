<?php
require 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

$host = 'http://localhost:4444/';
//$host = 'http://192.168.1.104:4444/'; // Selenium server URL
$capabilities = DesiredCapabilities::firefox();

$driver = RemoteWebDriver::create($host, $capabilities);

$baseUrl = 'http://localhost/yourname_assign1/assign1/';
$pages = [
    'index.php',
    'about.php',
    'aboutme1.php',
    'aboutme2.php',
    'aboutme3.php',
    'aboutme4.php',
    'acknowledgement.php',
    'Activities.php',
    'admin_dashboard.php',
    'anti_spam_check.php',
    'buy_product.php',
    'edit_update.php',
    'enquiry.php',
    'joinus.php',
    'locations.php',
    'product.php',
    'registration.php',
    'login.php',
];

foreach ($pages as $page) {
    $url = $baseUrl . $page;
    $driver->get($url);
    try {
        $footer = $driver->findElement(WebDriverBy::tagName('footer'));
        echo "Footer found on $page\n";
    } catch (Exception $e) {
        echo "Footer NOT found on $page\n";
    }
    sleep(1); 
}

$driver->quit();