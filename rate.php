<?php

interface RateInterface{

    public function checkAge($driverAge);

    public function getPrice(int $km, int $minute, int $driverAge);
}

trait Gps
{
    public function addGps($result, $minute)
    {
        $hours = intdiv($minute, 60) + 1;
        $result = $result + ($hours * 15);
        return $result;
    }
}

trait Driver
{
    public function addDriver($result)
    {
        $result+=100;
        return $result;
    }
}

abstract class Rate implements RateInterface
{

    public function checkAge($driverAge)
    {
        if($driverAge < 18){
            echo 'Вы слишком молоды';
            die;
        }elseif ($driverAge > 65){
            echo 'Вы слишком стары';
            die;
        }elseif ($driverAge >= 18 && $driverAge <=21){
            return 1.1;
        }else{
            return 1;
        }
    }

    abstract function getPrice(int $km, int $minute, int $driverAge);

}

class Base extends Rate
{
    public $perKm = 10;
    public $perMinute = 3;

    use Gps;

    public function getPrice(int $km, int $minute, int $driverAge, bool $gps = false)
    {

        $coefficent = $this->checkAge($driverAge);

        $result =  ($this->perKm * $km + $this->perMinute * $minute) * $coefficent;

        if($gps){
            $result = $this->addGps($result, $minute);
        }

        return $result;
    }
}
class Hour extends Rate
{
    public $perKm = 0;
    public $perHour = 200;

    use Gps;
    use Driver;

    public function getPrice(int $km, int $minute, int $driverAge, bool $gps = false, bool $driver = false)
    {
        $hours = intdiv($minute, 60) + 1;

        $coefficent = $this->checkAge($driverAge);

        $result = ($this->perKm * $km + $this->perHour * $hours) * $coefficent;

        if($gps){
            $result = $this->addGps($result, $minute);
        }

        if($driver){
            $result = $this->addDriver($result);
        }

        return $result;

    }
}
class Day extends Rate
{
    public $perKm = 1;
    public $perDay = 1000;

    use Gps;
    use Driver;

    public function checkTime($minute)
    {
        if (($minute % 1440) <= 29 && $minute > 1440){
            return (intdiv($minute, 1440));
        }elseif (($minute % 1440) > 29){
            return (intdiv($minute, 1440) + 1);
        }else{
            return 1;
        }
    }

    public function getPrice(int $km, int $minute, int $driverAge, bool $gps = false, bool $driver = false)
    {
        $day = $this->checkTime($minute);

        $coefficent = $this->checkAge($driverAge);

        $result =  ($this->perKm * $km + $this->perDay * $day) * $coefficent;

        if($gps){
            $result = $this->addGps($result, $minute);
        }

        if($driver){
            $result = $this->addDriver($result);
        }

        return $result;
    }
}

class Student extends Rate
{
    public $perKm = 4;
    public $perMinute = 1;

    use Gps;

    public function getPrice(int $km, int $minute, int $driverAge, bool $gps = false)
    {
        if ($driverAge > 25){
            echo 'Тариф для водителей возрастом не болле 25 лет';
            return false;
        }

        $coefficent = $this->checkAge($driverAge);

        $result = ($this->perKm * $km + $this->perMinute * $minute) * $coefficent;

        if($gps){
            $result = $this->addGps($result, $minute);
        }

        return $result;
    }
}

