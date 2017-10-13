<?php

namespace app\helpers;

use DateTimeZone;

/**
 * Created by PhpStorm.
 * User: dench
 * Date: 12.10.17
 * Time: 12:03
 */
class Timezone
{
    public static function getList($country_id = null)
    {
        $items = [];

        if ($country_id) {
            $list = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_id);
        } else {
            $list = DateTimeZone::listIdentifiers();
        }

        foreach ($list as $l) {
            $date = new DateTimeZone($l);
            $offset = $date->getOffset(new \DateTime())/60/60;
            if ($offset < 0) {
                $offset = " (" . $offset . ")";
            } else {
                $offset = " (+" . $offset . ")";
            }
            $items[$l] = $l . $offset;
        }

        return $items;
    }
}