<?php
namespace Php2Core\Gaming\Games\Palworld\StaticData;

class Character implements \Php2Core\Gaming\Engines\Unreal\ICustomProperties
{
	public static function encode()
	{
		throw new \Php2Core\Exceptions\NotImplementedException(__CLASS__.'::encode');
	}
	
	/**
	 * @param \Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader
	 * @param \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName
	 * @param int $size
	 * @param string $path
	 * @return array
	 * @throws \Php2Core\Exceptions\UnexpectedValueException
	 */
	public static function decode(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
	{
		if($typeName !== \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::ArrayProperty)
		{
			throw new \Php2Core\Exceptions\UnexpectedValueException('Expected ArrayProperty, got '.$typeName -> value);
		}
		$value = $reader -> property($typeName, $size, $path, $path);
		$bytes = $value['value']['values'];
		$value['value'] = self::decodeBytes($reader, $bytes);
		return $value;
	}
	
	/**
	 * @param \Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader
	 * @param string[] $bytes
	 * @return array
	 */
	private static function decodeBytes(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, array $bytes): array
	{
            $buffer = [];
            foreach($bytes as $stream)
            {
                $rd = new \Php2Core\Gaming\Engines\Unreal\Gvas\Reader($stream, $reader -> gvasData());
                $data = [
                    'object' => $rd -> propertiesUntilEnd(),
                    'unknownBytes' => $rd -> bytes(4),
                    'groupId' => $rd -> guid()
                ];

                $buffer[] = $data;
            }
            return $buffer;
	}
}