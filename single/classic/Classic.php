<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/22/2018
 * Time: 8:58 AM
 */

namespace Relisoft\Uploader\Single\Classic;


use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Nette\Utils\FileSystem;
use Relisoft\Uploader\DI\UploaderException;
use Relisoft\Uploader\Helper\Format;
use Relisoft\Uploader\Helper\Save;
use Relisoft\Uploader\Helper\Size;
use Relisoft\Uploader\Storage\Temp\Temporary;

class Classic extends Control
{
    private $options;

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
     * @var object
     */
    private $file_type;

    /**
     * @var array
     */
    private $config;

    public $onUpload;

    public function __construct(ClassicOptions $options,$config)
    {
        $this->options = $options;
        $this->config = $config;
    }

    protected function createComponentUploader(){
        $form = new Form();
        $form->getElementPrototype()->setAttribute("class","ajax");
        if($this->options->isOnlyImages()){
            $form->addUpload("file",$this->options->getNameTrans())
                ->addRule(Form::MAX_FILE_SIZE,$this->options->getMaxSizeOverTrans(),$this->options->getMaxSize())
                ->addRule(Form::IMAGE,$this->options->getOnlyImagesTrans())
                ->setRequired($this->options->getRequiredTrans());
        }else{
            $form->addUpload("file",$this->options->getNameTrans())
                ->addRule(Form::MAX_FILE_SIZE,$this->options->getMaxSizeOverTrans(),$this->options->getMaxSize())
                ->setRequired($this->options->getRequiredTrans());
        }
        $form->addSubmit("submt",$this->options->getSubmtTrans());
        $form->onSuccess[] = function (Form $form,$val){
            $this->onUpload($val->file);
        };
        return $form;
    }

    public function render(){
        $this->template->setFile(__DIR__."/template/entitiy.latte");
        $this->template->options = $this->options;
        $this->template->render();
    }

    public function renderCss(){
        $this->template->setFile(__DIR__."/template/css.latte");
        $this->template->options = $this->options;
        $this->template->render();
    }

    public function renderJs(){
        $this->template->setFile(__DIR__."/template/js.latte");
        $this->template->options = $this->options;
        $this->template->render();
    }

    public function getRequirements(Size $size, Format $format, Save $save){
        $this->size = $size;
        $this->format = $format;
        $this->save = $save;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
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
     * @param FileUpload $fileUpload
     * @return bool
     * @throws UploaderException
     */
    public function process(FileUpload $fileUpload){
        if($fileUpload->isOk()){
            $this->save->setSizes($this->size->getSize());

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
                $img = $this->getSize()->createBySize($path,$option);
                $img->save($folderReplaces."/".$nameReplaces);

                /** TODO: Find storage, load, save image to media list */
            }
            $this->getPresenter()->redrawControl("imgList");
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

    /**
     * @return ClassicOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param ClassicOptions $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return Size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param Size $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return Format
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param Format $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
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

    /**
     * @return object
     */
    public function getFileType()
    {
        return $this->file_type;
    }

    /**
     * @param object $file_type
     */
    public function setFileType($file_type)
    {
        $this->file_type = $file_type;
    }
}