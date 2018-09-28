<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/19/2018
 * Time: 2:55 PM
 */

namespace Relisoft\Uploader\Storage;


use Kdyby\Doctrine\EntityManager;
use Nette\Application\ApplicationException;
use Nette\Http\Session;
use Nette\Utils\DateTime;
use Nette\Utils\FileSystem;
use Relisoft\Uploader\Storage\Doctrine\MediaItem;
use Relisoft\Uploader\Storage\Doctrine\MediaItemData;
use Tracy\Debugger;

class Storage
{
    const SESSION_STORAGE = "SESSION",
        DOCTRINE_STORAGE = "DOCTRINE";

    const SESSION_SECTION = "UPLOADER_DROPZONE";

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var \Nette\Http\SessionSection
     */
    private $section;
    /**
     * @var string
     */
    private $type;

    /**
     * Storage constructor.
     * @param EntityManager $entityManager
     * @param Session $session
     * @throws ApplicationException
     */
    public function __construct(EntityManager $entityManager, Session $session)
    {
        $this->em = $entityManager;
        $this->session = $session;
        $this->section = $session->getSection(self::SESSION_SECTION);

        $this->setStorageType();
    }

    /**
     * @param string $type
     * @throws ApplicationException
     */
    public function setStorageType($type = self::SESSION_STORAGE)
    {
        switch ($type) {
            case self::DOCTRINE_STORAGE:
                $this->type = $type;
                break;
            case self::SESSION_STORAGE:
                $this->type = $type;
                break;
            default:
                throw new ApplicationException("Unknow storage type!");
                break;
        }
    }

    /**
     * @param array $imageData
     * @return array
     * @throws ApplicationException
     */
    public function save(array $imageData): MediaItem
    {
        if ($this->type == self::SESSION_STORAGE) {
            return $this->sessionSave($imageData);
        } else {
            throw new ApplicationException("Doctrine storage set is not added yet!");
        }
    }

    public function getData()
    {
        if ($this->type == self::SESSION_STORAGE) {
            return $this->section->uploadedImages;
        }else{
            return [];
        }
    }

    public function removeDataByIterator(int $iterator)
    {
        if ($this->type == self::SESSION_STORAGE) {
            unset($this->section->uploadedImages[$iterator]);
            $this->section->uploadedImages = array_values($this->section->uploadedImages);
            return true;
        }else{
            return true;
        }
    }

    public function clean(){
        if($this->type == self::SESSION_STORAGE){
            unset($this->section->uploadedImages);
            return true;
        }
    }

    protected function sessionSave(array $imageData): MediaItem
    {
        if(!isset($this->section->uploadedImages)){
            $this->section->uploadedImages = [];
        }

        $media = new MediaItem();
        $media->setDisplayTop(false);
        $media->setTimeCreate(new DateTime());
        $media->setId(count($this->section->uploadedImages)+1);
        $media->setOrderIndex(count($this->section->uploadedImages)+1);
        foreach ($imageData as $formats){
            $media->setType($formats["type"]);
            $data = new MediaItemData();
            $data->setFolder($formats["folder"]);
            $data->setAbsoluteFolder($formats["absoluteFolder"]);
            $data->setType($formats["type"]);
            $data->setName($formats["name"]);
            $data->setWidth($formats["width"]);
            $data->setHeight($formats["height"]);
            $data->setSize(filesize($formats["folder"]."/".$formats["name"]));
            $data->setFormat(is_null($formats["rawOptions"]["size"]["format"]) ? "full" : $formats["rawOptions"]["size"]["format"]);
            $md = $media->getMediaData();
            $md[] = $data;
            $media->setMediaData($md);
        }

        $this->section->uploadedImages[] = $media;
        return $media;
    }

    public function removeById(int $id){
        $iterator = 0;
        /** @var MediaItem $one */
        foreach ($this->getData() as $one){
            if($one->getId() == $id){
                /** @var MediaItemData $med */
                foreach ($one->getMediaData() as $med){
                    @FileSystem::delete($med->getAbsoluteFolder()."/".$med->getName());
                }
                $this->removeDataByIterator($iterator);
            }
            $iterator++;
        }
        return true;
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

    /**
     * @param EntityManager $em
     */
    public function setEm(EntityManager $em): void
    {
        $this->em = $em;
    }


}