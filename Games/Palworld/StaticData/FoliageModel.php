<?php
namespace Php2Core\Gaming\Games\Palworld\StaticData;

class FoliageModel implements \Php2Core\Gaming\Engines\Unreal\ICustomProperties
{
	public static function encode()
	{
		throw new \Php2Core\Exceptions\NotImplementedException(__CLASS__.'::encode');
	}
	
	public static function decode(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
	{
		throw new \Php2Core\Exceptions\NotImplementedException(__CLASS__.'::decode');
	}
}