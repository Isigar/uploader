<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/18/2018
 * Time: 4:36 PM
 */

namespace Relisoft\Uploader\Storage;


interface IMediaItemManager
{
    /**
     * Selector can be array (where) or ID (fetch/find)
     * @param null $selector
     * @return mixed
     */
    public function get($selector = null);

    /**
     * Selector can be array (where) or ID (fetch/find)
     * @param array|int $selector
     * @param $data
     * @return mixed
     */
    public function set($selector,$data);

    /**
     * Selector can be array (where) or ID (fetch/find)
     * @param array|int $selector
     * @param $data
     * @return mixed
     */
    public function update($selector,$data);

    /**
     * Selector can be array (where) or ID (fetch/find)
     * @param array|int $selector
     * @return mixed
     */
    public function remove($selector);
}