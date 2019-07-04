<?php
/**
 * Created by black40x@yandex.ru
 * Date: 10.10.2018
 */

namespace App\Classes\Business;


class WorkTime
{
    const MON = 'mon';
    const TUE = 'tue';
    const WED = 'wed';
    const THU = 'thu';
    const FRI = 'fri';
    const SAT = 'sat';
    const SUN = 'sun';

    const PATTERN = '/^([01][0-9]|2[0-3]):([0-5][0-9])$/';

    public static function workTimeToStr($workTime) {
        if (!self::checkWorkTime($workTime))
            return json_encode(self::emptyTime());

        return json_encode($workTime);
    }

    public static function strToWorkTime($str) {
        if (!$str)
            return self::emptyTime();

        $workTime = json_decode($str, true);

        if (!self::checkWorkTime($workTime))
            return json_encode(self::emptyTime());

        return $workTime;
    }

    public static function emptyTime() {
        return [
            self::MON => false,
            self::TUE => false,
            self::WED => false,
            self::THU => false,
            self::FRI => false,
            self::SAT => false,
            self::SUN => false,
        ];
    }

    public static function checkWorkTime(array $workTime) {
        if (!array_key_exists(self::MON, $workTime) ||
            !array_key_exists(self::TUE, $workTime) ||
            !array_key_exists(self::WED, $workTime) ||
            !array_key_exists(self::THU, $workTime) ||
            !array_key_exists(self::FRI, $workTime) ||
            !array_key_exists(self::SAT, $workTime) ||
            !array_key_exists(self::SUN, $workTime)) return false;

        foreach ($workTime as $day => $time) {
            if (($time !== false && $time !== null) && (!isset($time['from']) || !isset($time['to']))) return false;

            if (is_array($time)) {
                if (!preg_match(self::PATTERN, $time['from'])) return false;
                if (!preg_match(self::PATTERN, $time['to'])) return false;

                if (strtotime($time['from'] . ':00') > strtotime($time['to'] . ':00'))
                    return false;
            }
        }

        return true;
    }

}