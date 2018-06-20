<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/19/2018
 * Time: 2:55 PM
 */

namespace Relisoft\Uploader\Storage;


class Storage
{
    const DOCTRINE = "doctrine";
    const NDB = "ndb";
    const DIBI = "dibi";

    private $storage;

    /**
     * @param IMediaItem $mediaItem
     */
    public function save(IMediaItem $mediaItem){
        /**
         * TODO: Save methods by type
         * check if image is saved?
         */
    }

    /**
     * @return mixed
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param mixed $storage
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;
    }
}