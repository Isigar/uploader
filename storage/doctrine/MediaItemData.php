<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/19/2018
 * Time: 2:53 PM
 */

namespace Relisoft\Uploader\Storage\Doctrine;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer_media_item_data")
 */
class MediaItemData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $type;
    /**
     * @ORM\Column(type="integer")
     */
    private $id_customer;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="float")
     */
    private $height;
    /**
     * @ORM\Column(type="float")
     */
    private $width;
    /**
     * @ORM\Column(type="float")
     */
    private $size;
    /**
     * @ORM\Column(type="datetime")
     */
    private $time_create;
    /**
     * @ORM\Column(type="datetime")
     */
    private $time_modify;
    /**
     * @ORM\Column(type="string")
     */
    private $url;
    /**
     * @ORM\Column(type="string")
     */
    private $folder;

    private $format;

    private $absoluteFolder;

    /**
     * @ORM\ManyToOne(targetEntity="MediaItem",inversedBy="media_data")
     * @ORM\JoinColumn(name="media_item_id", referencedColumnName="id")
     */
    private $mediaItem;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAbsoluteFolder()
    {
        return $this->absoluteFolder;
    }

    /**
     * @param mixed $absoluteFolder
     */
    public function setAbsoluteFolder($absoluteFolder): void
    {
        $this->absoluteFolder = $absoluteFolder;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format): void
    {
        $this->format = $format;
    }

    /**
     * @return mixed
     */
    public function getMediaItem()
    {
        return $this->mediaItem;
    }

    /**
     * @param mixed $mediaItem
     */
    public function setMediaItem($mediaItem): void
    {
        $this->mediaItem = $mediaItem;
    }

    /**
     * @return mixed
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param mixed $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getIdCustomer()
    {
        return $this->id_customer;
    }

    /**
     * @param mixed $id_customer
     */
    public function setIdCustomer($id_customer)
    {
        $this->id_customer = $id_customer;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    /**
     * @return mixed
     */
    public function getSize($unformated = false)
    {
        if ($unformated)
            return $this->size;
        else
            return $this->formatBytes($this->size);
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getTimeCreate()
    {
        return $this->time_create;
    }

    /**
     * @param mixed $time_create
     */
    public function setTimeCreate($time_create)
    {
        $this->time_create = $time_create;
    }

    /**
     * @return mixed
     */
    public function getTimeModify()
    {
        return $this->time_modify;
    }

    /**
     * @param mixed $time_modify
     */
    public function setTimeModify($time_modify)
    {
        $this->time_modify = $time_modify;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


}