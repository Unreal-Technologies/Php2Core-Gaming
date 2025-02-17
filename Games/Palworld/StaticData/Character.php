<?php
namespace Php2Core\Gaming\Games\Palworld\StaticData;

class Character implements \Php2Core\Gaming\Engines\Unreal\ICustomProperties
{
	public static function encode()
	{
		throw new \Php2Core\Exceptions\NotImplementedException(__CLASS__.'::encode');
	}
	
	public static function decode(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
	{
//		if type_name != "ArrayProperty":
//		        raise Exception(f"Expected ArrayProperty, got {type_name}")
//		    value = reader.property(type_name, size, path, nested_caller_path=path)
//		    char_bytes = value["value"]["values"]
//		    value["value"] = decode_bytes(reader, char_bytes)
//		    return value
		
		echo '<xmp>';
		var_dump($typeName);
		var_dump($size);
		var_dump($path);
		var_dump($reader);
		echo '</xmp>';
		throw new \Php2Core\Exceptions\NotImplementedException(__CLASS__.'::decode');
	}
}