<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/22/2018
 * Time: 8:58 AM
 */

namespace Relisoft\Uploader\Single\Classic;


class ClassicOptions
{
    private $name_trans;
    private $submt_trans;
    private $help_text;
    private $max_size_over_trans;
    private $max_size;
    private $file_type;
    private $required_trans;

    private $only_images;
    private $only_images_trans;

    public function __construct()
    {
        $this->max_size_over_trans = "Max file size reached!";
        $this->max_size = 20*1024*1024;
        $this->help_text = "Max file size: ".$this->formatBytes($this->max_size);
        $this->submt_trans = "Upload";
        $this->name_trans = "File";
        $this->only_images = false;
        $this->required_trans = "You have to upload at least one file!";
        $this->only_images_trans = "You can upload only images!";
    }

    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    /**
     * @return string
     */
    public function getOnlyImagesTrans()
    {
        return $this->only_images_trans;
    }

    /**
     * @param string $only_images_trans
     */
    public function setOnlyImagesTrans($only_images_trans)
    {
        $this->only_images_trans = $only_images_trans;
    }

    /**
     * @return bool
     */
    public function isOnlyImages()
    {
        return $this->only_images;
    }

    /**
     * @param bool $only_images
     */
    public function setOnlyImages($only_images)
    {
        $this->only_images = $only_images;
    }

    /**
     * @return mixed
     */
    public function getRequiredTrans()
    {
        return $this->required_trans;
    }

    /**
     * @param mixed $required_trans
     */
    public function setRequiredTrans($required_trans)
    {
        $this->required_trans = $required_trans;
    }

    /**
     * @return mixed
     */
    public function getFileType()
    {
        return $this->file_type;
    }

    /**
     * @param mixed $file_type
     */
    public function setFileType($file_type)
    {
        $this->file_type = $file_type;
    }

    /**
     * @return mixed
     */
    public function getNameTrans()
    {
        return $this->name_trans;
    }

    /**
     * @param mixed $name_trans
     */
    public function setNameTrans($name_trans)
    {
        $this->name_trans = $name_trans;
    }

    /**
     * @return mixed
     */
    public function getSubmtTrans()
    {
        return $this->submt_trans;
    }

    /**
     * @return mixed
     */
    public function getMaxSizeOverTrans()
    {
        return $this->max_size_over_trans;
    }

    /**
     * @param mixed $max_size_over_trans
     */
    public function setMaxSizeOverTrans($max_size_over_trans)
    {
        $this->max_size_over_trans = $max_size_over_trans;
    }

    /**
     * @param mixed $submt_trans
     */
    public function setSubmtTrans($submt_trans)
    {
        $this->submt_trans = $submt_trans;
    }

    /**
     * @return mixed
     */
    public function getHelpText()
    {
        return $this->help_text;
    }

    /**
     * @param mixed $help_text
     */
    public function setHelpText($help_text)
    {
        $this->help_text = $help_text;
    }

    /**
     * @return mixed
     */
    public function getMaxSize()
    {
        return $this->max_size;
    }

    /**
     * @param mixed $max_size
     */
    public function setMaxSize($max_size)
    {
        $this->max_size = $max_size;
    }


}