<?php
require 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

$host = 'http://192.168.1.104:4444/'; // Selenium server URL
$capabilities = DesiredCapabilities::firefox();

$driver = RemoteWebDriver::create($host, $capabilities);

$driver->get("https://www.google.com");

$searchBox = $driver->findElement(WebDriverBy::name('q'));
$searchBox->sendKeys('Selenium with PHP and Firefox')->submit();

sleep(3);

$driver->quit();