<?php

require_once 'rate.php';

$baseRate = new Base;
$hourRate = new Hour();
$dayRate = new Day();
$studentRate = new Student();

echo 'Базовый: ';
echo $baseRate->getPrice(54,7,60, true);
echo '<br>Часовой: ';
echo $hourRate->getPrice(54,67,60, false, true);
echo '<br>Суточный: ';
echo $dayRate->getPrice(54,2910,60, true);
echo '<br>Студенческий: ';
echo $studentRate->getPrice(54,67,21, true);