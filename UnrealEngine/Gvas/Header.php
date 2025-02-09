<?php
namespace Php2Core\Gaming\UnrealEngine\Gvas;

class Header
{
    /**
     * @var int
     */
    private int $iMagic = -1;
    
    /**
     * @var int
     */
    private int $iSavegameVersion = -1;
    
    /**
     * @var int
     */
    private int $iPackageFileVersionUe4 = -1;
    
    /**
     * @var int
     */
    private int $iPackageFileVersionUe5 = -1;
    
    /**
     * @var int
     */
    private int $iEngineVersionMajor = -1;
    
    /**
     * @var int
     */
    private int $iEngineVersionMinor = -1;
    
    /**
     * @var int
     */
    private int $iEngineVersionPatch = -1;
    
    /**
     * @var int
     */
    private int $iEngineVersionChangelist = -1;
    
    /**
     * @var string
     */
    private string $sEngineVersionBranch = '';
    
    /**
     * @var int
     */
    private int $iCustomVersionFormat = -1;
    
    /**
     * @var array
     */
    private array $aCustomVersions = [];
    
    /**
     * @var string
     */
    private string $sSaveGameClassName = '';
    
    /**
     * @param \Php2Core\IO\Data\BinaryStreamReader $bsr
     * @throws \Php2Core\Exceptions\UnexpectedValueException
     */
    public function __construct(\Php2Core\IO\Data\BinaryStreamReader $bsr) 
    {
        $this -> iMagic = $bsr -> i32();
        if($this -> iMagic !== 0x53415647)
        {
            throw new \Php2Core\Exceptions\UnexpectedValueException('Invalid Magic: '.$this -> iMagic);
        }
        $this -> iSavegameVersion = $bsr -> i32();
        if($this -> iSavegameVersion !== 3)
        {
            throw new \Php2Core\Exceptions\UnexpectedValueException('Expected save game version 3, got: '.$this -> iSavegameVersion);
        }
        # Unreal Engine Version
        $this -> iPackageFileVersionUe4 = $bsr -> i32();
        $this -> iPackageFileVersionUe5 = $bsr -> i32();
        
        # Saved Engine Version
        $this -> iEngineVersionMajor = $bsr -> u16();
        $this -> iEngineVersionMinor = $bsr -> u16();
        $this -> iEngineVersionPatch = $bsr -> u16();
        $this -> iEngineVersionChangelist = $bsr -> u32();
        $this -> sEngineVersionBranch = $bsr -> fString();
        
        # Custom Version Format
        $this -> iCustomVersionFormat = $bsr -> i32();
        if($this -> iCustomVersionFormat !== 3)
        {
            throw \Php2Core\Exceptions\UnexpectedValueException('Expected custom version format 3, got: '.$this -> iCustomVersionFormat);
        }
        $this -> aCustomVersions = $bsr -> tArray(function(\Php2Core\IO\Data\BinaryStreamReader $bsr)
        {
            return [$bsr -> guid(), $bsr -> i32()];
        });
        $this -> sSaveGameClassName = $bsr -> fstring();
    }
}