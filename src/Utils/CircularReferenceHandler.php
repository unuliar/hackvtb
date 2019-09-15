<?php
/**
 * Created by PhpStorm.
 * User: unuliar
 * Date: 15.09.2019
 * Time: 3:42
 */

namespace App\Utils;


class CircularReferenceHandler
{
    public function __invoke($object)
    {
        return $object->getId();
    }
}