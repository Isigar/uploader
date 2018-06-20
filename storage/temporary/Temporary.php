<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/19/2018
 * Time: 3:40 PM
 */

namespace Relisoft\Uploader\Storage\Temp;


use Nette\StaticClass;

class Temporary
{
    use StaticClass;

    public static function returnDirectory(){
        return __DIR__;
    }
}