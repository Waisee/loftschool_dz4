<?php

require_once 'rate.php';

$baseRate = new Base;
$hourRate = new Hour();
$dayRate = new Day();
$studentRate = new Student();
echo $baseRate->getPrice(54,7,60);
echo '<br>';
echo $hourRate->getPrice(54,67,60);
echo '<br>';
echo $dayRate->getPrice(54,2910,60);
echo '<br>';
echo $studentRate->getPrice(54,67,25);