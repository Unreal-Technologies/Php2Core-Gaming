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
    private static ?Gvas\Header $oHeader = null;
    
    /**
     * @var array
     */
    private array $aProperties = [];
    
    /**
     * @var Gvas\Reader|null
     */
    private ?Gvas\Reader $rd = null;

    /**
     * @return \Php2Core\IO\IFile
     */
    public function save(): \Php2Core\IO\IFile
    {
        $wt = new Gvas\Writer();
        
        self::$oHeader -> save($wt);
        $wt -> properties($this -> aProperties);
        $wt -> trailer();
        
        $data = [
            'type' => (string)$this -> iSaveType,
            'data' => (string)$wt
        ];
        
        $file = \Php2Core\IO\File::fromDirectory($this -> parent(), $this -> basename().'.gvas.2');
        $file -> write(serialize($data));
        
        return $file;
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
    public function initialize(IGvasData $iGvasData): void
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
        $this -> rd = new Gvas\Reader($data['data'], $iGvasData);
        
        self::$oHeader = new Gvas\Header($this -> rd);
        $this -> aProperties = $this -> rd -> propertiesUntilEnd();
        $this -> rd = null;
        
        $f = \Php2Core\IO\File::fromDirectory($this -> parent(), $this -> basename().'.txt');
        $f -> write(print_r($this, true));
    }
}
