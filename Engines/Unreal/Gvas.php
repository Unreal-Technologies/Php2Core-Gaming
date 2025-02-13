<?php
namespace Php2Core\Gaming\Engines\Unreal;

class Gvas extends \Php2Core\IO\File
{
    /**
     * @var int
     */
    private int $iSaveType = -1;
    
    /**
     * @var Gvas\Header|null
     */
    private ?Gvas\Header $oHeader = null;
    
    /**
     * @var array
     */
    private array $aProperties = [];
    
    /**
     * @var Gvas\Reader|null
     */
    private ?Gvas\Reader $rd = null;
    
    #[\Override]
    public function write(string $sStream, bool $bCreateDirectory = true): void 
    {
        parent::write($sStream, $bCreateDirectory);
        
        $this -> initialize();
    }
    
    #[\Override]
    public static function fromString(string $sPath): \Php2Core\IO\IFile 
    {
        $res = parent::fromString($sPath);
        $res -> initialize();
        return $res;
    }
    
    #[\Override]
    public static function fromFile(\Php2Core\IO\IFile $oFile): \Php2Core\IO\IFile 
    {
        $res = parent::fromFile($oFile);
        $res -> initialize();
        return $res;
    }
    
    #[\Override]
    public static function fromDirectory(\Php2Core\IO\IDirectory $oDir, string $sName): ?\Php2Core\IO\IFile
    {
        $res = parent::fromDirectory($oDir, $sName);
        $res -> initialize();
        return $res;
    }
    
    public function save()
    {
        $wt = new Gvas\Writer();
        
        $this -> oHeader -> save($wt);
        $wt -> properties($this -> aProperties);
        
        echo '<xmp>';
        var_dump(__FILE__.':'.__LINE__);
//        print_r($this -> aProperties);
        print_r($wt);
        echo '</xmp>';
        
        $data = [
            'type' => (string)$this -> iSaveType,
            'data' => (string)$wt
        ];
        
        $file = \Php2Core\IO\File::fromDirectory($this ->parent(), $this ->basename().'.gvas2');
        $file -> write(serialize($data));
    }
    
    private function savePropertiesRecursive(\Php2Core\IO\Data\BinaryStreamWriter $bsw, array $properties)
    {
        foreach($properties as $name => $property)
        {
            $bsw -> fString($name);
            $bsw -> fString($property['path']);
            switch($property['path'])
            {
                case 'IntProperty':
                    $bsw -> u64(4);
                    $bsw -> optionalGuid($property['id']);
                    $bsw -> i32($property['value']);
                    break;
                case 'StructProperty':
                    $bsw -> u64(0);
                    $bsw -> fString($property['struct_type']);
                    
                    echo '<xmp>';
                    var_dump(__FILE__.':'.__LINE__);
                    var_dump($name);
                    print_r($property);
                    echo '</xmp>';
                    break 2;
                    break;
                default:
                    echo '<xmp>';
                    var_dump(__FILE__.':'.__LINE__);
                    var_dump($name);
                    print_r($property);
                    echo '</xmp>';
                break;
            }
        }
//        $bsw -> fString('None');
    }
    
    /**
     * @param string $path
     * @param mixed $value
     * @return void
     */
    public function set(string $path, mixed $value): void
    {
        $parts = explode('/', $path);
        $current = '$this -> aProperties';
        
        foreach($parts as $part)
        {
            $temp = $current.'[\''.$part.'\']';
            
            $exists = false;
            eval('$exists = isset('.$temp.');');
            
            if(!$exists)
            {
                return;
            }
            
            $current = $temp.'[\'value\']';
        }
        eval($current.' = \''.$value.'\';');
    }
    
    /**
     * @param string $path
     * @return mixed
     */
    public function get(string $path): mixed
    {
        $parts = explode('/', $path);
        $current = $this -> aProperties;
        
        foreach($parts as $part)
        {
            if(isset($current[$part]))
            {
                $current = $current[$part]['value'];
            }
            else
            {
                return null;
            }
        }
        
        return $current;
    }
    
    /**
     * @return void
     */
    private function initialize(): void
    {
        if(!$this -> exists())
        {
            return;
        }
        $bytes = $this -> read();
        if(strlen($bytes) === 0)
        {
            return;
        }
        
        $data = unserialize($bytes);
        $this -> iSaveType = $data['type'];
        $this -> rd = new Gvas\Reader($data['data']);
        
        $this -> oHeader = new Gvas\Header($this -> rd);
        $this -> aProperties = $this -> rd -> propertiesUntilEnd();
        $this -> rd = null;
        
        $f = \Php2Core\IO\File::fromDirectory($this -> parent(), $this -> basename().'.txt');
        $f -> write(print_r($this, true));
    }
}
