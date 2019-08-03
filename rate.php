<?php

interface iRate{
    public function checkAge();

    public function getPrice();
}

abstract class Rate
{

    protected function checkAge($driverAge)
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

    public function getPrice(int $km, int $minute, int $driverAge)
    {
        $coefficent = $this->checkAge($driverAge);

        return ($this->perKm * $km + $this->perMinute * $minute) * $coefficent;
    }
}
class Hour extends Rate
{
    public $perKm = 0;
    public $perHour = 200;

    public function getPrice(int $km, int $minute, int $driverAge)
    {
        $hours = intdiv($minute, 60) + 1;

        $coefficent = $this->checkAge($driverAge);

        return ($this->perKm * $km + $this->perHour * $hours) * $coefficent;

    }
}
class Day extends Rate
{
    public $perKm = 1;
    public $perDay = 1000;

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

    public function getPrice(int $km, int $minute, int $driverAge)
    {
        $minute = $this->checkTime($minute);



        return ($this->perKm * $km + $this->perDay * $minute);
    }
}

class Student extends Rate
{
    public $perKm = 4;
    public $perMinute = 1;



    public function getPrice(int $km, int $minute, int $driverAge)
    {
        if ($driverAge > 25){
            echo 'Тариф для водителей возрастом не болле 25 лет';
            return false;
        }

        $coefficent = $this->checkAge($driverAge);

        return ($this->perKm * $km + $this->perMinute * $minute) * $coefficent;
    }
}

