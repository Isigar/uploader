<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/18/2018
 * Time: 9:44 AM
 */

namespace Relisoft\Uploader\Multi\Dropzone;


use Nette\Reflection\ClassType;
use Nette\Reflection\Property;
use Nette\Utils\Strings;
use Tracy\Debugger;

class DropzoneOptions
{
    private $url;
    private $method;
    private $withCredentials;
    private $timeout;
    private $parallelUploads;
    private $uploadMultiple;
    private $chunking;
    private $forceChunging;
    private $chunkSize;
    private $parallelChunkUploads;
    private $retryChunks;
    private $retryChunksLimit;
    private $maxFilesize;
    private $paramName;
    private $createImageThumbnails;
    private $maxThumbnailFilesize;
    private $thumbnailWidth;
    private $thumbnailHeight;
    private $thumbnailMethod;
    private $resizeWidth;
    private $resizeHeight;
    private $resizeMethod;
    private $resizeQuality;
    private $maxFiles;
    private $headers;
    private $clickable;
    private $ignoreHiddenFiles;
    private $acceotedFiles;
    private $acceptedMimeTypes;
    private $autoProcessQueue;
    private $autoQueue;
    private $addRemoveLinks;
    private $previewsContainer;
    private $hiddenInputContainer;
    private $capture;
    private $renameFile;
    private $forceFallback;

    private $dictDefaultMessage;
    private $dictFallbackMessage;
    private $dictFallbackText;
    private $dictFileTooBig;
    private $dictInvalidFileType;
    private $dictCancelUpload;
    private $dictResponseError;
    private $dictUploadCanceled;
    private $dictCancelUploadConfirmation;
    private $dictRemoveFile;
    private $dictRemoveFileConfirmation;
    private $dictMaxFilesExceeded;
    private $dictFileSizeUnits;

    private function c($name,$variable){
        if($variable){
            if(is_null($variable)){
                return null;
            }else{
                if(is_string($variable)){
                    return "{$name}: '{$variable}'";
                }else{
                    return "{$name}: {$variable}";
                }
            }
        }else{
            return null;
        }
    }

    public function json(){
        $class = ClassType::from($this);
        $all = $class->getProperties();

        $out = [];
        /** @var Property $one */
        foreach($all as $one){
            $getter = "get".Strings::capitalize($one->getName());
            $v = $this->c($one->getName(),$this->$getter());
            if($v)
                $out[] = $v;
        }
        return $out;
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
     * @return DropzoneOptions
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return DropzoneOptions
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWithCredentials()
    {
        return $this->withCredentials;
    }

    /**
     * @param mixed $withCredentials
     * @return DropzoneOptions
     */
    public function setWithCredentials($withCredentials)
    {
        $this->withCredentials = $withCredentials;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     * @return DropzoneOptions
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParallelUploads()
    {
        return $this->parallelUploads;
    }

    /**
     * @param mixed $parallelUploads
     * @return DropzoneOptions
     */
    public function setParallelUploads($parallelUploads)
    {
        $this->parallelUploads = $parallelUploads;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUploadMultiple()
    {
        return $this->uploadMultiple;
    }

    /**
     * @param mixed $uploadMultiple
     * @return DropzoneOptions
     */
    public function setUploadMultiple($uploadMultiple)
    {
        $this->uploadMultiple = $uploadMultiple;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChunking()
    {
        return $this->chunking;
    }

    /**
     * @param mixed $chunking
     * @return DropzoneOptions
     */
    public function setChunking($chunking)
    {
        $this->chunking = $chunking;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getForceChunging()
    {
        return $this->forceChunging;
    }

    /**
     * @param mixed $forceChunging
     * @return DropzoneOptions
     */
    public function setForceChunging($forceChunging)
    {
        $this->forceChunging = $forceChunging;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChunkSize()
    {
        return $this->chunkSize;
    }

    /**
     * @param mixed $chunkSize
     * @return DropzoneOptions
     */
    public function setChunkSize($chunkSize)
    {
        $this->chunkSize = $chunkSize;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParallelChunkUploads()
    {
        return $this->parallelChunkUploads;
    }

    /**
     * @param mixed $parallelChunkUploads
     * @return DropzoneOptions
     */
    public function setParallelChunkUploads($parallelChunkUploads)
    {
        $this->parallelChunkUploads = $parallelChunkUploads;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRetryChunks()
    {
        return $this->retryChunks;
    }

    /**
     * @param mixed $retryChunks
     * @return DropzoneOptions
     */
    public function setRetryChunks($retryChunks)
    {
        $this->retryChunks = $retryChunks;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRetryChunksLimit()
    {
        return $this->retryChunksLimit;
    }

    /**
     * @param mixed $retryChunksLimit
     * @return DropzoneOptions
     */
    public function setRetryChunksLimit($retryChunksLimit)
    {
        $this->retryChunksLimit = $retryChunksLimit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxFilesize()
    {
        return $this->maxFilesize;
    }

    /**
     * @param mixed $maxFilesize
     * @return DropzoneOptions
     */
    public function setMaxFilesize($maxFilesize)
    {
        $this->maxFilesize = $maxFilesize;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParamName()
    {
        return $this->paramName;
    }

    /**
     * @param mixed $paramName
     * @return DropzoneOptions
     */
    public function setParamName($paramName)
    {
        $this->paramName = $paramName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreateImageThumbnails()
    {
        return $this->createImageThumbnails;
    }

    /**
     * @param mixed $createImageThumbnails
     * @return DropzoneOptions
     */
    public function setCreateImageThumbnails($createImageThumbnails)
    {
        $this->createImageThumbnails = $createImageThumbnails;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxThumbnailFilesize()
    {
        return $this->maxThumbnailFilesize;
    }

    /**
     * @param mixed $maxThumbnailFilesize
     * @return DropzoneOptions
     */
    public function setMaxThumbnailFilesize($maxThumbnailFilesize)
    {
        $this->maxThumbnailFilesize = $maxThumbnailFilesize;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbnailWidth()
    {
        return $this->thumbnailWidth;
    }

    /**
     * @param mixed $thumbnailWidth
     * @return DropzoneOptions
     */
    public function setThumbnailWidth($thumbnailWidth)
    {
        $this->thumbnailWidth = $thumbnailWidth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbnailHeight()
    {
        return $this->thumbnailHeight;
    }

    /**
     * @param mixed $thumbnailHeight
     * @return DropzoneOptions
     */
    public function setThumbnailHeight($thumbnailHeight)
    {
        $this->thumbnailHeight = $thumbnailHeight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbnailMethod()
    {
        return $this->thumbnailMethod;
    }

    /**
     * @param mixed $thumbnailMethod
     * @return DropzoneOptions
     */
    public function setThumbnailMethod($thumbnailMethod)
    {
        $this->thumbnailMethod = $thumbnailMethod;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResizeWidth()
    {
        return $this->resizeWidth;
    }

    /**
     * @param mixed $resizeWidth
     * @return DropzoneOptions
     */
    public function setResizeWidth($resizeWidth)
    {
        $this->resizeWidth = $resizeWidth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResizeHeight()
    {
        return $this->resizeHeight;
    }

    /**
     * @param mixed $resizeHeight
     * @return DropzoneOptions
     */
    public function setResizeHeight($resizeHeight)
    {
        $this->resizeHeight = $resizeHeight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResizeMethod()
    {
        return $this->resizeMethod;
    }

    /**
     * @param mixed $resizeMethod
     * @return DropzoneOptions
     */
    public function setResizeMethod($resizeMethod)
    {
        $this->resizeMethod = $resizeMethod;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResizeQuality()
    {
        return $this->resizeQuality;
    }

    /**
     * @param mixed $resizeQuality
     * @return DropzoneOptions
     */
    public function setResizeQuality($resizeQuality)
    {
        $this->resizeQuality = $resizeQuality;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxFiles()
    {
        return $this->maxFiles;
    }

    /**
     * @param mixed $maxFiles
     * @return DropzoneOptions
     */
    public function setMaxFiles($maxFiles)
    {
        $this->maxFiles = $maxFiles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     * @return DropzoneOptions
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClickable()
    {
        return $this->clickable;
    }

    /**
     * @param mixed $clickable
     * @return DropzoneOptions
     */
    public function setClickable($clickable)
    {
        $this->clickable = $clickable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIgnoreHiddenFiles()
    {
        return $this->ignoreHiddenFiles;
    }

    /**
     * @param mixed $ignoreHiddenFiles
     * @return DropzoneOptions
     */
    public function setIgnoreHiddenFiles($ignoreHiddenFiles)
    {
        $this->ignoreHiddenFiles = $ignoreHiddenFiles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAcceotedFiles()
    {
        return $this->acceotedFiles;
    }

    /**
     * @param mixed $acceotedFiles
     * @return DropzoneOptions
     */
    public function setAcceotedFiles($acceotedFiles)
    {
        $this->acceotedFiles = $acceotedFiles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAcceptedMimeTypes()
    {
        return $this->acceptedMimeTypes;
    }

    /**
     * @param mixed $acceptedMimeTypes
     * @return DropzoneOptions
     */
    public function setAcceptedMimeTypes($acceptedMimeTypes)
    {
        $this->acceptedMimeTypes = $acceptedMimeTypes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAutoProcessQueue()
    {
        return $this->autoProcessQueue;
    }

    /**
     * @param mixed $autoProcessQueue
     * @return DropzoneOptions
     */
    public function setAutoProcessQueue($autoProcessQueue)
    {
        $this->autoProcessQueue = $autoProcessQueue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAutoQueue()
    {
        return $this->autoQueue;
    }

    /**
     * @param mixed $autoQueue
     * @return DropzoneOptions
     */
    public function setAutoQueue($autoQueue)
    {
        $this->autoQueue = $autoQueue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddRemoveLinks()
    {
        return $this->addRemoveLinks;
    }

    /**
     * @param mixed $addRemoveLinks
     * @return DropzoneOptions
     */
    public function setAddRemoveLinks($addRemoveLinks)
    {
        $this->addRemoveLinks = $addRemoveLinks;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPreviewsContainer()
    {
        return $this->previewsContainer;
    }

    /**
     * @param mixed $previewsContainer
     * @return DropzoneOptions
     */
    public function setPreviewsContainer($previewsContainer)
    {
        $this->previewsContainer = $previewsContainer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHiddenInputContainer()
    {
        return $this->hiddenInputContainer;
    }

    /**
     * @param mixed $hiddenInputContainer
     * @return DropzoneOptions
     */
    public function setHiddenInputContainer($hiddenInputContainer)
    {
        $this->hiddenInputContainer = $hiddenInputContainer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCapture()
    {
        return $this->capture;
    }

    /**
     * @param mixed $capture
     * @return DropzoneOptions
     */
    public function setCapture($capture)
    {
        $this->capture = $capture;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRenameFile()
    {
        return $this->renameFile;
    }

    /**
     * @param mixed $renameFile
     * @return DropzoneOptions
     */
    public function setRenameFile($renameFile)
    {
        $this->renameFile = $renameFile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getForceFallback()
    {
        return $this->forceFallback;
    }

    /**
     * @param mixed $forceFallback
     * @return DropzoneOptions
     */
    public function setForceFallback($forceFallback)
    {
        $this->forceFallback = $forceFallback;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictDefaultMessage()
    {
        return $this->dictDefaultMessage;
    }

    /**
     * @param mixed $dictDefaultMessage
     * @return DropzoneOptions
     */
    public function setDictDefaultMessage($dictDefaultMessage)
    {
        $this->dictDefaultMessage = $dictDefaultMessage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictFallbackMessage()
    {
        return $this->dictFallbackMessage;
    }

    /**
     * @param mixed $dictFallbackMessage
     * @return DropzoneOptions
     */
    public function setDictFallbackMessage($dictFallbackMessage)
    {
        $this->dictFallbackMessage = $dictFallbackMessage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictFallbackText()
    {
        return $this->dictFallbackText;
    }

    /**
     * @param mixed $dictFallbackText
     * @return DropzoneOptions
     */
    public function setDictFallbackText($dictFallbackText)
    {
        $this->dictFallbackText = $dictFallbackText;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictFileTooBig()
    {
        return $this->dictFileTooBig;
    }

    /**
     * @param mixed $dictFileTooBig
     * @return DropzoneOptions
     */
    public function setDictFileTooBig($dictFileTooBig)
    {
        $this->dictFileTooBig = $dictFileTooBig;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictInvalidFileType()
    {
        return $this->dictInvalidFileType;
    }

    /**
     * @param mixed $dictInvalidFileType
     * @return DropzoneOptions
     */
    public function setDictInvalidFileType($dictInvalidFileType)
    {
        $this->dictInvalidFileType = $dictInvalidFileType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictCancelUpload()
    {
        return $this->dictCancelUpload;
    }

    /**
     * @param mixed $dictCancelUpload
     * @return DropzoneOptions
     */
    public function setDictCancelUpload($dictCancelUpload)
    {
        $this->dictCancelUpload = $dictCancelUpload;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictResponseError()
    {
        return $this->dictResponseError;
    }

    /**
     * @param mixed $dictResponseError
     * @return DropzoneOptions
     */
    public function setDictResponseError($dictResponseError)
    {
        $this->dictResponseError = $dictResponseError;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictUploadCanceled()
    {
        return $this->dictUploadCanceled;
    }

    /**
     * @param mixed $dictUploadCanceled
     * @return DropzoneOptions
     */
    public function setDictUploadCanceled($dictUploadCanceled)
    {
        $this->dictUploadCanceled = $dictUploadCanceled;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictCancelUploadConfirmation()
    {
        return $this->dictCancelUploadConfirmation;
    }

    /**
     * @param mixed $dictCancelUploadConfirmation
     * @return DropzoneOptions
     */
    public function setDictCancelUploadConfirmation($dictCancelUploadConfirmation)
    {
        $this->dictCancelUploadConfirmation = $dictCancelUploadConfirmation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictRemoveFile()
    {
        return $this->dictRemoveFile;
    }

    /**
     * @param mixed $dictRemoveFile
     * @return DropzoneOptions
     */
    public function setDictRemoveFile($dictRemoveFile)
    {
        $this->dictRemoveFile = $dictRemoveFile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictRemoveFileConfirmation()
    {
        return $this->dictRemoveFileConfirmation;
    }

    /**
     * @param mixed $dictRemoveFileConfirmation
     * @return DropzoneOptions
     */
    public function setDictRemoveFileConfirmation($dictRemoveFileConfirmation)
    {
        $this->dictRemoveFileConfirmation = $dictRemoveFileConfirmation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictMaxFilesExceeded()
    {
        return $this->dictMaxFilesExceeded;
    }

    /**
     * @param mixed $dictMaxFilesExceeded
     * @return DropzoneOptions
     */
    public function setDictMaxFilesExceeded($dictMaxFilesExceeded)
    {
        $this->dictMaxFilesExceeded = $dictMaxFilesExceeded;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDictFileSizeUnits()
    {
        return $this->dictFileSizeUnits;
    }

    /**
     * @param mixed $dictFileSizeUnits
     * @return DropzoneOptions
     */
    public function setDictFileSizeUnits($dictFileSizeUnits)
    {
        $this->dictFileSizeUnits = $dictFileSizeUnits;
        return $this;
    }




}