<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/18/2018
 * Time: 9:44 AM
 */

namespace Relisoft\Uploader\Multi\Dropzone;


use Latte\Engine;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Nette\Utils\ArrayHash;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Relisoft\Uploader\DI\UploaderException;
use Relisoft\Uploader\Helper\Format;
use Relisoft\Uploader\Helper\Save;
use Relisoft\Uploader\Helper\Size;
use Relisoft\Uploader\Storage\Temp\Temporary;
use Tracy\Debugger;

class Dropzone extends Control
{
    /**
     * @var DropzoneOptions
     */
    private $options;
    /**
     * Extension config
     * @var array
     */
    private $config;
    /**
     * @var array
     */
    private $files;
    /**
     * @var LinkGenerator
     */
    private $linkGenerator;

    public $onAddFile;
    public $onSuccess;
    public $onRemoveFile;
    public $onError;
    public $onUploadProgress;
    public $onMaxFileReached;
    public $onUpload;

    /**
     * @var Size
     */
    private $size;
    /**
     * @var Format
     */
    private $format;
    /**
     * @var Save
     */
    private $save;

    /**
     * @var string
     */
    private $fileType;

    public function getRequirements(Size $size, Format $format,Save $save){
        $this->size = $size;
        $this->format = $format;
        $this->save = $save;
    }

    public function __construct(DropzoneOptions $options = null,$config)
    {
        $this->options = $options;
        $this->config = $config;
        $this->files = [];

        $this->linkGenerator = $this->config['linkGenerator'];
        $this->config['basePath'] = $this->config['request']->getUrl()->getBasePath();
    }

    public function render(){
        $this->template->setFile(__DIR__."/templates/entity.latte");
        $this->template->_uploader = $this;
        $this->template->settings = $this->getOptions()->json();
        $this->template->basePath = $this->config['basePath'];
        $this->template->images = $this->files;
        $this->template->render();
    }

    public function renderJs(){
        $this->template->setFile(__DIR__."/templates/js.latte");
        $this->template->_uploader = $this;
        $this->template->settings = $this->getOptions()->json();
        $this->template->options = $this->getOptions();
        $this->template->basePath = $this->config['basePath'];
        $this->template->onAddedFile = $this->getOnAddFile();
        $this->template->onSuccess = $this->getOnSuccess();
        $this->template->render();
    }

    public function renderCss(){
        $this->template->setFile(__DIR__."/templates/css.latte");
        $this->template->_uploader = $this;
        $this->template->settings = $this->getOptions()->json();
        $this->template->basePath = $this->config['basePath'];
        $this->template->render();
    }

    /**
     * @param FileUpload $fileUpload
     * @return bool
     * @throws UploaderException
     */
    public function process(FileUpload $fileUpload,object $typeObject){
        if($fileUpload->isOk()){
            $this->save->setSizes($this->size->getSize());
            $this->setFileType($typeObject);

            $temp = Temporary::returnDirectory();
            $path = $temp."\\".md5($fileUpload->getName());
            $fileUpload->move($path);

            foreach($this->save->getSaveOptions() as $option){
                $this->save->assignSize($option);

                $folder = $this->format->getParser()->parse($option['folder']);
                $name = $this->format->getParser()->parse($option['name']);
                $type = $this->format->getType($this->getFileType());

                $nameReplaces = $this->format->replaceVariables($name,$this->getConfig(),$fileUpload,$this->format::TYPE_NAME,$type);
                $folderReplaces = $this->format->replaceVariables($folder,$this->getConfig(),$fileUpload,$this->format::TYPE_FOLDER,$type);

                $this->existsDestination($folderReplaces);
                $img = $this->createBySize($path,$option);
                $img->save($folderReplaces."/".$nameReplaces);
            }

            FileSystem::delete($path);
            return true;
        }else{
            return false;
        }
    }

    public function existsDestination($folder){
        @FileSystem::createDir($folder);
        return true;
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

    /**
     * @throws UploaderException
     */
    public function handleOnSuccess(){
        if(is_callable($this->onSuccess)){
            if(is_object($this->onSuccess)){
                call_user_func($this->onSuccess,$this->getPresenter()->getRequest()->getPost("uploadFile"));
            }else{
                try{
                    $this->onSuccess($this->getPresenter()->getRequest()->getPost("uploadFile"));
                }catch (\Exception $e){
                    throw new UploaderException("Cant handle callback! {$e->getMessage()}");
                }
            }
        }
    }

    /**
     * @throws UploaderException
     */
    public function handleOnAddedFile(){
        if(is_callable($this->onAddFile)){
            if(is_object($this->onAddFile)){
                call_user_func($this->onAddFile,$this->getPresenter()->getRequest()->getFiles());
            }else{
                try{
                    $this->onAddFile($this->getPresenter()->getRequest()->getPost("uploadFile"));
                }catch (\Exception $e){
                    throw new UploaderException("Cant handle callback! {$e->getMessage()}");
                }
            }
        }
    }

    public function handleOnUpload(){
        if(is_callable($this->onUpload)){
            if(is_object($this->onUpload)){
                call_user_func($this->onUpload,$this->getPresenter()->getRequest()->getFiles());
            }else{
                try{
                    $this->onUpload($this->onAddFile,$this->getPresenter()->getRequest()->getFiles());
                }catch (\Exception $e){
                    throw new UploaderException("Cant handle callback! {$e->getMessage()}");
                }
            }
        }
    }

    /**
     * @return Save
     */
    public function getSave()
    {
        return $this->save;
    }

    /**
     * @param Save $save
     */
    public function setSave($save)
    {
        $this->save = $save;
    }

    public function createLink($name, ...$options){
        return $this->linkGenerator->link($name,$options);
    }

    /**
     * @return mixed
     */
    public function getOnAddFile()
    {
        return $this->onAddFile;
    }

    /**
     * @param mixed $onAddFile
     */
    public function setOnAddFile($onAddFile)
    {
        $this->onAddFile = $onAddFile;
    }

    /**
     * @return mixed
     */
    public function getOnRemoveFile()
    {
        return $this->onRemoveFile;
    }

    /**
     * @return mixed
     */
    public function getOnSuccess()
    {
        return $this->onSuccess;
    }

    /**
     * @return Size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return Format
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $onSuccess
     */
    public function setOnSuccess($onSuccess)
    {
        $this->onSuccess = $onSuccess;
    }
    /**
     * @param mixed $onRemoveFile
     */
    public function setOnRemoveFile($onRemoveFile)
    {
        $this->onRemoveFile = $onRemoveFile;
    }

    /**
     * @return mixed
     */
    public function getOnThumbnailGenerated()
    {
        return $this->onThumbnailGenerated;
    }

    /**
     * @return LinkGenerator
     */
    public function getLinkGenerator()
    {
        return $this->linkGenerator;
    }

    /**
     * @param LinkGenerator $linkGenerator
     */
    public function setLinkGenerator($linkGenerator)
    {
        $this->linkGenerator = $linkGenerator;
    }

    /**
     * @return string
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    /**
     * @param mixed $onThumbnailGenerated
     */
    public function setOnThumbnailGenerated($onThumbnailGenerated)
    {
        $this->onThumbnailGenerated = $onThumbnailGenerated;
    }

    /**
     * @return mixed
     */
    public function getOnError()
    {
        return $this->onError;
    }

    /**
     * @param mixed $onError
     */
    public function setOnError($onError)
    {
        $this->onError = $onError;
    }

    /**
     * @return mixed
     */
    public function getOnUploadProgress()
    {
        return $this->onUploadProgress;
    }

    /**
     * @param mixed $onUploadProgress
     */
    public function setOnUploadProgress($onUploadProgress)
    {
        $this->onUploadProgress = $onUploadProgress;
    }

    /**
     * @return mixed
     */
    public function getOnMaxFileReached()
    {
        return $this->onMaxFileReached;
    }

    /**
     * @param mixed $onMaxFileReached
     */
    public function setOnMaxFileReached($onMaxFileReached)
    {
        $this->onMaxFileReached = $onMaxFileReached;
    }

    /**
     * @return mixed
     */
    public function getOnUpload()
    {
        return $this->onUpload;
    }

    /**
     * @param mixed $onUpload
     */
    public function setOnUpload($onUpload)
    {
        $this->onUpload = $onUpload;
    }

    /**
     * @return DropzoneOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param DropzoneOptions $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    public function addFile(array $file){
        $this->files[] = ArrayHash::from($file);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }




}