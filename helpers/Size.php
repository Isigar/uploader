<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/15/2018
 * Time: 3:25 PM
 */

namespace Relisoft\Uploader\Helper;


class Size
{
    private $size;

    public function __construct($sizeConfig)
    {
        $this->size = $sizeConfig;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }


}