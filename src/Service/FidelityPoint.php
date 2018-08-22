<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 21/08/2018
 * Time: 17:23
 */

namespace App\Service;


class FidelityPoint
{
    private $euro;
    /**
     * @return mixed
     */
    public function getEuro($point)
    {
        return $this->euro = $point / 10;
    }

    public function getBuild($start, $end, $price, $fidelity){
        $periode = round((strtotime($end) - strtotime($start))/(60*60*24)-1)+2;
        if ($fidelity >= 100){
            return $periode * $price - 10;
        }
        else
            return $periode * $price;

    }
}