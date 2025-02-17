<?php
namespace Php2Core\Gaming\Engines\Unreal;

interface ICustomProperties
{
	public static function encode();
	public static function decode(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array;
}