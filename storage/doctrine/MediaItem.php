<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/18/2018
 * Time: 4:44 PM
 */

namespace Relisoft\Uploader\Storage\Doctrine;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Relisoft\Uploader\Storage\IMediaItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer_media_item")
 */
class MediaItem implements IMediaItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $id_customer;
    /**
     * @ORM\Column(type="string")
     */
    private $type;
    /**
     * @ORM\Column(type="integer")
     */
    private $display_top;
    /**
     * @ORM\Column(type="integer")
     */
    private $order_index;
    /**
     * @ORM\OneToMany(targetEntity="MediaItemData", mappedBy="mediaItem",cascade={"DELETE","PERSIST"})
     */
    private $media_data;
    /**
     * @ORM\Column(type="datetime")
     */
    private $time_create;
    /**
     * @ORM\Column(type="datetime")
     */
    private $time_modify;
    /**
     * @ORM\Column(type="integer")
     */
    private $id_item;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getDisplayTop()
    {
        return $this->display_top;
    }

    /**
     * @param mixed $display_top
     */
    public function setDisplayTop($display_top)
    {
        $this->display_top = $display_top;
    }

    /**
     * @return mixed
     */
    public function getOrderIndex()
    {
        return $this->order_index;
    }

    /**
     * @param mixed $order_index
     */
    public function setOrderIndex($order_index)
    {
        $this->order_index = $order_index;
    }

    /**
     * @return mixed
     */
    public function getMediaData($format = null)
    {
        if(empty($this->media_data)){
            return [];
        }
        if(is_null($format))
            return $this->media_data;

        /** @var MediaItemData $med */
        foreach ($this->media_data as $med){
            if(strtolower($format) == strtolower($med->getFormat())){
                return $med;
            }else{
                continue;
            }
        }
        return $this->media_data;
    }

    /**
     * @param mixed $media_data
     */
    public function setMediaData($media_data)
    {
        $this->media_data = $media_data;
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
    public function getIdItem()
    {
        return $this->id_item;
    }

    /**
     * @param mixed $id_item
     */
    public function setIdItem($id_item)
    {
        $this->id_item = $id_item;
    }


}