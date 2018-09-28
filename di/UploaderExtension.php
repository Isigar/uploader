<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/15/2018
 * Time: 11:56 AM
 */

namespace Relisoft\Uploader\DI;


use Kdyby\Doctrine\EntityManager;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Nette\Http\Request;
use Nette\Neon\Neon;
use Nette\Utils\ArrayHash;
use Nette\Utils\FileSystem;
use Relisoft\Uploader\Helper\Format;
use Relisoft\Uploader\Helper\Parser;
use Relisoft\Uploader\Helper\Save;
use Relisoft\Uploader\Helper\Size;
use Relisoft\Uploader\Multi\Dropzone\Dropzone;
use Relisoft\Uploader\Multi\Dropzone\DropzoneOptions;
use Relisoft\Uploader\Single\Classic\Classic;
use Relisoft\Uploader\Single\Classic\ClassicOptions;
use Relisoft\Uploader\Storage\Storage;
use Relisoft\Uploader\Storage\Temp\Temp;
use Relisoft\Uploader\Storage\Temp\Temporary;
use Tracy\Debugger;

class UploaderExtension extends CompilerExtension
{
    public $defaults = [
        'basePath' => null,
        'baseUri' => null,
        'wwwDir' => null,
        'request' =>  null,
        'linkGenerator' => null,
        'sizeConfig' => __DIR__."/size.neon",
        'saveConfig' => __DIR__."/save.neon",
        'formatConfig' => __DIR__."/format.neon",
        'storage' => EntityManager::class
    ];

    private $httpRequest;
    private $basePath;
    private $baseUri;

    public function loadConfiguration()
    {
        $config = $this->validateConfig($this->defaults,$this->config);

        $container = $this->getContainerBuilder();
        $container->addDefinition($this->prefix("storage"))
            ->setFactory(Storage::class);
        $container->addDefinition($this->prefix("temp"))
            ->setFactory(Temporary::class);
        $container->addDefinition($this->prefix("parser"))
            ->setFactory(Parser::class);
        $container->addDefinition($this->prefix("format"))
            ->setFactory(Format::class, [$this->getFormatConfig(),'@uploader.parser']);
        $container->addDefinition($this->prefix("size"))
            ->setFactory(Size::class, [$this->getSizeConfig()]);
        $container->addDefinition($this->prefix("save"))
            ->setFactory(Save::class, [$this->getSaveConfig()]);
        $container->addDefinition($this->prefix("dropzone"))
            ->setFactory(Dropzone::class, [$this->getDefaultsDropzoneConfig(),$config])
            ->addSetup('getRequirements',['@uploader.size','@uploader.format','@uploader.save','@uploader.storage']);
        $container->addDefinition($this->prefix("classic"))
            ->setFactory(Classic::class, [$this->getDefaultClassicOptions(),$config])
            ->addSetup('getRequirements',['@uploader.size','@uploader.format','@uploader.save','@uploader.storage']);
        parent::loadConfiguration();
    }

    /**
     * @return DropzoneOptions
     */
    private function getDefaultsDropzoneConfig()
    {
        $options = new DropzoneOptions();
        return $options;
    }

    /**
     * @return ClassicOptions
     */
    private function getDefaultClassicOptions()
    {
        $options = new ClassicOptions();
        return $options;
    }

    private function getFormatConfig()
    {
        try {
            $file = FileSystem::read($this->config["formatConfig"]);
            $neonFormat = Neon::decode($file);
            return ArrayHash::from($neonFormat);
        } catch (\Exception $e) {
            throw new UploaderException("Cant read format config!");
        }
    }

    private function getSizeConfig()
    {
        try {
            $file = FileSystem::read($this->config["sizeConfig"]);
            $neonFormat = Neon::decode($file);
            return ArrayHash::from($neonFormat);
        } catch (\Exception $e) {
            throw new UploaderException("Cant read size config!");
        }
    }

    private function getSaveConfig()
    {
        try {
            $file = FileSystem::read($this->config["saveConfig"]);
            $neonFormat = Neon::decode($file);
            return ArrayHash::from($neonFormat);
        } catch (\Exception $e) {
            throw new UploaderException("Cant read size config!");
        }
    }

}