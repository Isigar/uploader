<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/15/2018
 * Time: 2:29 PM
 */

namespace Relisoft\Uploader\Helper;


use Latte\Engine;
use Nette\Http\FileUpload;
use Nette\Utils\DateTime;
use Relisoft\Uploader\DI\UploaderException;
use Tracy\Debugger;

class Format
{
    private $format;
    /**
     * @var Parser
     */
    private $parser;

    const DATE = "actualDate";
    const TIME = "actualTime";
    const WWW_FOLDER = "wwwFolder";
    const HASH_NAME = "hashName";
    const NAME = "normalName";
    const FILE_TYPE = "fileType";
    const EXTENSION = "ext";

    const TYPE_FOLDER = "folder";
    const TYPE_NAME = "name";

    public function __construct($formatConfig, Parser $parser)
    {
        $this->format = $formatConfig;
        $this->parser = $parser;
    }

    /**
     * @param $baseClass
     * @return bool|string
     * @throws UploaderException
     */
    public function getType($baseClass){
        if(isset($this->format->types)){
            if(!is_object($baseClass)){
                throw new UploaderException("Base class must be object!");
            }
            /**
             * @var string $type
             */
            foreach($this->format->types as $key => $type){
                if($baseClass instanceof $type){
                    return $key;
                }else{
                    continue;
                }
            }
            return false;
        }else{
            throw new UploaderException("Class types is not set!");
        }
    }

    /**
     * @param $datetime
     * @return string
     * @throws UploaderException
     */
    public function formatDate($datetime){
        if($datetime instanceof DateTime){
            try{
                return $datetime->format($this->getDateFormat());
            }
            catch (\Exception $e){
                throw new UploaderException("Cant format datetime object! Error: ".$e->getMessage());
            }
        }else if(is_string($datetime)){
            try{
                return (new DateTime($datetime))->format($this->getDateFormat());
            }catch (\Exception $e){
                throw new UploaderException("Cant format datetime string! Error: ".$e->getMessage());
            }
        }else{
            throw new UploaderException("Wrong time format!");
        }
    }


    /**
     * @return mixed
     * @throws UploaderException
     */
    public function getDateFormat(){
        if(isset($this->format->date)){
            return $this->format->date;
        }else{
            throw new UploaderException("Date format is not set!");
        }
    }

    public function replaceVariables(array $tokens,$config,FileUpload $file,$type = self::TYPE_NAME,$fileType){
        foreach ($tokens as $key => $token){
            if($token == self::DATE){
                $tokens[$key] = str_replace($token,$this->formatDate(new DateTime()),$tokens[$key]);
            }else if($token == self::TIME){
                $tokens[$key] = str_replace($token,$this->formatTime(new DateTime()),$tokens[$key]);
            }else if($token == self::WWW_FOLDER){
                $tokens[$key] = str_replace($token,$config["wwwDir"],$tokens[$key]);
            }else if($token == self::HASH_NAME){
                $ext = explode(".",$file->getName());
                unset($ext[count($ext)-1]);
                $tokens[$key] = str_replace($token,md5($file->getName()),$tokens[$key]);
            }else if($token == self::EXTENSION){
                $ext = explode(".",$file->getName());
                $extReal = end($ext);
                $tokens[$key] = str_replace($token,".{$extReal}",$tokens[$key]);
            }else if($token == self::FILE_TYPE){
                $tokens[$key] = str_replace($token,$fileType,$tokens[$key]);
            }
        }
        if($type == self::TYPE_FOLDER){
            return join("/",$tokens);
        }else if($type == self::TYPE_NAME){
            $edited = $tokens;
            unset($edited[count($edited)-1]);
            $result = join("_",$edited);
            $result .= $tokens[count($edited)];
            return $result;
        }
        return false;
    }

    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    /**
     * @param $datetime
     * @return string
     * @throws UploaderException
     */
    public function formatTime($datetime){
        if($datetime instanceof DateTime){
            try{
                return $datetime->format($this->getTimeFormat());
            }
            catch (\Exception $e){
                throw new UploaderException("Cant format datetime object! Error: ".$e->getMessage());
            }
        }else if(is_string($datetime)){
            try{
                return (new DateTime($datetime))->format($this->getTimeFormat());
            }catch (\Exception $e){
                throw new UploaderException("Cant format datetime string! Error: ".$e->getMessage());
            }
        }else{
            throw new UploaderException("Wrong time format!");
        }
    }

    /**
     * @return string
     * @throws UploaderException
     */
    public function getTimeFormat(){
        if(isset($this->format->time)){
            return $this->format->time;
        }else{
            throw new UploaderException("Time format is not set!");
        }
    }

    /**
     * @return Parser
     */
    public function getParser()
    {
        return $this->parser;
    }
}