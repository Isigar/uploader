<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/20/2018
 * Time: 12:07 PM
 */

namespace Relisoft\Uploader\Storage\Doctrine;


use Kdyby\Doctrine\EntityManager;
use Relisoft\Uploader\DI\UploaderException;
use Relisoft\Uploader\Storage\IMediaItemManager;

class DoctrineStorage implements IMediaItemManager
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Selector can be array (where) or ID (fetch/find)
     * @param null $selector
     * @return mixed
     */
    public function get($selector = null)
    {
        if(is_int($selector)){
            $result = $this->em->getRepository(MediaItem::class)->find($selector);
        }else{
            $result = $this->em->getRepository(MediaItem::class)->findBy($selector);
        }
        return $result;
    }

    /**
     * Selector can be array (where) or ID (fetch/find)
     * @param array|int $selector
     * @param $data
     * @return mixed
     */
    public function set($selector, $data)
    {
        if($data instanceof MediaItem){
            try{
                $this->em->persist($data)->flush();
            }catch (\Exception $e){
                throw new UploaderException("Cant insert new media item! Error: {$e->getMessage()}");
            }
        }else{
            throw new UploaderException("Use doctrine media item!");
        }
    }

    /**
     * Selector can be array (where) or ID (fetch/find)
     * @param array|int $selector
     * @param $data
     * @return mixed
     */
    public function update($selector = null, $data)
    {
        if(is_null($selector)){
            try{
                $this->em->persist($data)->flush();
            }catch (\Exception $e){
                throw new UploaderException("Selected element and data must be equal!");
            }
        }else{
            $find = $this->get($selector);
            if($find){
                if($find->getId() == $data->getId()){
                    throw new UploaderException("I dont know why :(");
                }else{
                    throw new UploaderException("Selected element and data must be equal!");
                }
            }else{
                throw new UploaderException("Cant find selected element!");
            }
        }
    }

    /**
     * Selector can be array (where) or ID (fetch/find)
     * @param array|int $selector
     * @return mixed
     */
    public function remove($selector)
    {
        $find = $this->get($selector);
        if(is_array($find)){
            foreach($find as $f){
                $this->em->remove($f);
            }
        }else{
            $this->em->remove($find);
        }
    }
}