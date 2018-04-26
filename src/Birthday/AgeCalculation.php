<?php

namespace App\Birthday;

class AgeCalculation
{
    /**
     * @param string $birthDay
     * @return string
     */
    public function howOldIAm($birthDay): string
    {
        $timeZone = new \DateTimeZone('Europe/Vilnius');
        $today = new \DateTime('now', $timeZone);
        return (new \DateTime($birthDay))->diff($today)->y;
    }

    /**
     * @param $age
     * @return bool
     */
    public function amIAnAdult($age): bool
    {
        $amIAnAdult = false;
        if ($age >= 18) {
            $amIAnAdult = true;
        }

        return $amIAnAdult;
    }
}
