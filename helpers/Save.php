<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/15/2018
 * Time: 3:25 PM
 */

namespace Relisoft\Uploader\Helper;


use Relisoft\Uploader\DI\UploaderException;

class Save
{
    private $save;
    private $sizes;

    public function __construct($saveConfig)
    {
        $this->save = $saveConfig;
    }

    public function getSaveOptions()
    {
        return $this->save;
    }

    public function assignSize($option)
    {
        if (is_null($this->sizes))
            throw new UploaderException("Must set sizes first!");

        foreach ($this->sizes as $key => $size) {
            if ($key == $option['size']) {
                $option['size'] = $size;
                return $option;
            } else {
                continue;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getSave()
    {
        return $this->save;
    }

    /**
     * @param mixed $save
     */
    public function setSave($save)
    {
        $this->save = $save;
    }

    /**
     * @return mixed
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * @param mixed $sizes
     */
    public function setSizes($sizes)
    {
        $this->sizes = $sizes;
    }
}