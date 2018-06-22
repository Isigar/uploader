<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/15/2018
 * Time: 3:25 PM
 */

namespace Relisoft\Uploader\Helper;


use Nette\Utils\Image;

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

    public function createBySize($path,$options){
        if(is_null($options['size'])){
            $img = Image::fromFile($path);
            return $img;
        }else{
            $img = Image::fromFile($path);

            if($options['size']['format'] == 'THUMBNAIL')
                $img->resize($options['size']['width'],$options['size']['height'],Image::FILL | Image::EXACT);
            elseif($options['size']['format'] == 'FILL')
                $img->resize($options['size']['width'],$options['size']['height'],Image::FILL);
            elseif($options['size']['format'] == 'EXACT')
                $img->resize($options['size']['width'],$options['size']['height'],Image::EXACT);
            elseif($options['size']['format'] == 'STRETCH')
                $img->resize($options['size']['width'],$options['size']['height'],Image::STRETCH);
            elseif($options['size']['format'] == 'SHRINK_ONLY')
                $img->resize($options['size']['width'],$options['size']['height'],Image::SHRINK_ONLY);
            return $img;
        }
    }


}