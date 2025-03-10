<?php
namespace Php2Core\Gaming\Games\Palworld;

class Sav extends \Php2Core\IO\File
{
    /**
     * @param \Php2Core\IO\Directory $directory
     * @return Gvas
     */
    public function decode(\Php2Core\IO\Directory $directory): \Php2Core\Gaming\Engines\Unreal\Gvas
    {
        $gvas = $this -> binaryDecode($this -> read());
        
        $file = \Php2Core\Gaming\Engines\Unreal\Gvas::fromDirectory($directory, $this -> basename().'.gvas');
        $file -> write(serialize($gvas));
        $file -> initialize(new StaticData());

        return $file;
    }
    
    /**
     * @param \Php2Core\Gaming\Engines\Unreal\Gvas $gvasFile
     * @return void
     */
    public function encode(\Php2Core\Gaming\Engines\Unreal\Gvas $gvasFile): void
    {
        $gvas = unserialize($gvasFile -> read());
        
        $sav = $this -> binaryEncode($gvas['data'], $gvas['type']);
        
        $this -> write($sav);
    }
    
    /**
    * @param string $bytes
    * @param int $type
    * @return string
    */
    private function binaryEncode(string $bytes, int $type): string
    {
        $enc = ZLIB_ENCODING_DEFLATE;
        
        $uncompressedLength = strlen($bytes);
        $compressedData = zlib_encode($bytes, $enc, -1);
        $compressedLength = strlen($compressedData);

        if($type === 2)
        {
            $compressedData = zlib_encode($compressedData, $enc, -1);
        }
        
        $upl = pack('v', $uncompressedLength);
        $cpl = pack('v', $compressedLength);
        while(strlen($upl) < 4)
        {
            $upl .= chr(0);
        }
        while(strlen($cpl) < 4)
        {
            $cpl .= chr(0);
        }
        
        $result = $upl;
        $result .= $cpl;
        $result .= 'PlZ';
        $result .= $type;
        $result .= $compressedData;
        return $result;
    }
    
    /**
     * @param string $bytes
     * @return array
     * @throws \Php2Core\Exceptions\NotImplementedException
     */
    private function binaryDecode(string $bytes): array
    {
        $uncompressedLength = unpack('V', substr($bytes, 0, 4))[1];
        $compressedLength = unpack('V', substr($bytes, 4, 4))[1];
        $magicBytes = substr($bytes, 8, 3);
        $saveType = substr($bytes, 11, 1);

        $startOffset = 12;
        
        if($magicBytes === 'CNK')
        {
            $uncompressedLength = unpack('V', substr($bytes, 12, 4))[1];
            $compressedLength = unpack('V', substr($bytes, 16, 4))[1];
            $magicBytes = substr($bytes, 20, 3);
            $saveType = substr($bytes, 23, 1);
            $startOffset = 24;
        }
        
        if(!in_array($saveType, ['0', '1', '2']))
        {
            throw new \Php2Core\Exceptions\NotImplementedException('unknown save type: '.$saveType);
        }

        if(!in_array($saveType, ['1', '2']))
        {
            throw new \Php2Core\Exceptions\NotImplementedException('unhandled compression type: '.$saveType);
        }

        if($saveType === '1' && $compressedLength !== strlen($bytes) - $startOffset)
        {
            throw new \Php2Core\Exceptions\NotImplementedException('incorrect compressed length: '.$compressedLength);
        }
		
        $uncompressedData = zlib_decode(substr($bytes, $startOffset));
        if($saveType === '2')
        {
            if($compressedLength !== strlen($uncompressedData))
            {
                throw new \Php2Core\Exceptions\NotImplementedException('incorrect compressed length: '.$compressedLength);
            }
            $uncompressedData = zlib_decode($uncompressedData);
        }
        
        if($uncompressedLength !== strlen($uncompressedData))
        {
            throw new \Php2Core\Exceptions\NotImplementedException('incorrect uncompressed length: '.$uncompressedLength);
        }

        return ['type' => $saveType, 'data' => $uncompressedData];
    }
}