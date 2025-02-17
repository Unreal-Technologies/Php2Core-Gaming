<?php
namespace Php2Core\Gaming\Engines\Unreal\Gvas;

class Reader extends \Php2Core\IO\Data\BinaryStreamReader
{
	/**
	 * @var \Php2Core\Gaming\Engines\Unreal\IGvasData|null
	 */
	private ?\Php2Core\Gaming\Engines\Unreal\IGvasData $oIGvasData = null;
	
	/**
	 * @return \Php2Core\Gaming\Engines\Unreal\IGvasData;
	 */
	public function gvasData(): \Php2Core\Gaming\Engines\Unreal\IGvasData
	{
		return $this -> oIGvasData;
	}
	
	/**
     * @param string $stream
	 * @param \Php2Core\Gaming\Engines\Unreal\IGvasData $oIGvasData
     */
	#[\Override]
    public function __construct(string $stream, \Php2Core\Gaming\Engines\Unreal\IGvasData $oIGvasData) 
    {
		parent::__construct($stream);
		$this -> oIGvasData = $oIGvasData;
    }
	
    /**
     * @return array
     */
    public function propertiesUntilEnd(?string $path=null): array
    {
        $properties = [];
        while(true)
        {
            $name = $this -> fString();
            if($name === 'None')
            {
                break;
            }
            $typeName = \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::fromString($this -> fString());
            $size = $this -> u64();
            
            $properties[$name] = $this -> property($typeName, $size, $path.'.'.$name, '');
        }
        return $properties;
    }
    
	/**
	 * @param string $key
	 * @param \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $default
	 * @return \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes
	 */
	private function getTypeOr(string $key, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $default): \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes
	{
		$typeHints = $this -> oIGvasData -> TypeHints();
		if(isset($typeHints[$key]))
		{
			return $typeHints[$key];
		}
		return $default;
	}
	
    /**
     * @param \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName
     * @param string $size
     * @return array|null
     */
    public function property(\Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, string $size, ?string $path, ?string $nestedCallerPath): ?array
    {
		$customProperties = $this -> oIGvasData -> CustomProperties();
		$value = null;
		
		if(isset($customProperties[$path]) && ($path !== $nestedCallerPath || $nestedCallerPath === ''))
		{
			$value = $customProperties[$path][1]($this, $typeName, $size, $path);
			$value['custom_type'] = $path;
		}
		else
		{
	        switch($typeName)
	        {
				case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Int64Property:
					$value = [
						'id' => $this -> optionalGuid(),
						'value' => $this -> i64()
					];
					
					break;
				case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::ByteProperty:
					$enumType = \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::fromString($this -> fString());
					$id = $this -> optionalGuid();
					$enumValue = $enumType === \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::None ? $this -> byte() : $this -> fString();
					
					$value = [
						'id' => $id,
						'value' => [
							'type' => $enumType,
							'value' => $enumValue
						]
					];
					break;
				case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::EnumProperty:
					$enumType = $this -> fString();
					$id = $this -> optionalGuid();
					$enumValue = $this -> fString();
					$value = [
						'path' => $path,
						'id' => $id,
						'value' => [
							'type' => $enumType,
							'value' => $enumValue
						]
					];
					
					break;			
	            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::MapProperty:
	                $keyType = \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::fromString($this -> fString());
	                $valueType = \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::fromString($this -> fString());
	                $id = $this -> optionalGuid();
	                $this -> u32();
	                $count = $this -> u32();
	                
					$keyPath = $path.'.Key';
	                $keyStructType = null;
	                if($keyType === \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty)
	                {
						$keyStructType = $this -> getTypeOr($keyPath, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Guid);
	                }
	                
					$valuePath = $path.'.Value';
	                $valueStructType = null;
	                if($valueType === \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty)
	                {
						$valueStructType = $this -> getTypeOr($valuePath, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty);
	                }
	                
	                $values = [];
	                for($i=0; $i<$count; $i++)
	                {
	                    $key = $this -> propertyValue($keyType, $keyStructType, $keyPath);
	                    $value = $this -> propertyValue($valueType, $valueStructType, $valuePath);
	                    $values[] = [
	                        'key' => $key,
	                        'value' => $value
	                    ];
	                }
	                
	                $value = [
	                    'path' => $path,
	                    'key_type' => $keyType,
	                    'value_type' => $valueType,
	                    'key_struct_type' => $keyStructType,
	                    'value_struct_type' => $valueStructType,
	                    'id' => $id,
	                    'value' => $values
	                ];
	                break;
	            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::ArrayProperty:
	                $arrayType = \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::fromString($this -> fstring());
					
	                $value = [
	                    'path' => $path,
	                    'array_type' => $arrayType,
	                    'id' => $this -> optionalGuid(),
	                    'value' => $this -> arrayProperty($arrayType, $size - 4, $path)
	                ];
	                break;
	            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::NameProperty:
	            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StrProperty:
	                $value = [
	                    'path' => $path,
	                    'id' => $this -> optionalGuid(),
	                    'value' => $this -> fString()
	                ];
	                break;
	            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::BoolProperty:
	                $value = [
	                    'path' => $path,
	                    'value' => $this -> bool(),
	                    'id' => $this -> optionalGuid()
	                ];
	                break;
	            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::IntProperty:
	                $value = [
	                    'path' => $path,
	                    'id' => $this -> optionalGuid(),
	                    'value' => $this -> i32()
	                ];
	                break;
	            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::FloatProperty:
	                $value = [
	                    'path' => $path,
	                    'id' => $this -> optionalGuid(),
	                    'value' => $this -> float()
	                ];
	                break;
	            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty:
	                $value = $this -> struct($path);
	                break;
	            default:
	                echo '<xmp>';
	                var_dump(__FILE__.':'.__LINE__);
	                var_dump($typeName);
	                var_dump($size);
	                echo '</xmp>';
	        }
		}
        return $value;
    }
    
    /**
     * @return array
     */
    private function struct(?string $path=null): array
    {
        $structType = $this -> fString();
        
        return [
            'path' => $path,
            'struct_type' => $structType,
            'struct_id' => $this -> guid(),
            'id' => $this -> optionalGuid(),
            'value' => $this -> structValue($structType, $path)
        ];
    }
    
    /**
     * @param string $structType
     * @return type
     */
    private function structValue(string $structType, string $path=null): mixed
    {
		$structTypeEnum = \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::fromString($structType);
		
        switch($structTypeEnum)
        {
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::LinearColor:
                return $this -> colorDict();
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Vector:
                return $this -> vectorDict();
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::DateTime:
                return $this -> u64();
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Guid:
                return $this -> guid();
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Quat:
                return $this -> quatDict();
            default:
                return $this -> propertiesUntilEnd($path);
        }
    }
    
    /**
     * @return array
     */
    private function colorDict(): array
    {
        return [
            'r' => $this -> float(),
            'g' => $this -> float(),
            'b' => $this -> float(),
            'a' => $this -> float()
        ];
    }
    
    /**
     * @return array
     */
    private function vectorDict(): array
    {
        return [
            'x' => $this -> double(),
            'y' => $this -> double(),
            'z' => $this -> double()
        ];
    }
    
    /**
     * @return array
     */
    private function quatDict(): array
    {
        return [
            'x' => $this -> double(),
            'y' => $this -> double(),
            'z' => $this -> double(),
            'w' => $this -> double()
        ];
    }
    
    /**
     * @param \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName
     * @param \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes|null $structTypeName
     * @return mixed
     * @throws \Php2Core\Exceptions\UnexpectedValueException
     */
    private function propertyValue(\Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, ?\Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $structTypeName, string $path): mixed
    {
        switch($typeName)
        {
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::BoolProperty:
                return $this -> bool();
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::IntProperty:
                return $this -> i32();
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty:
                return $this -> structValue($structTypeName -> value, $path);
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::EnumProperty:
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::NameProperty:
                return $this -> fString();
            default:
                throw new \Php2Core\Exceptions\UnexpectedValueException('Unknown property value type: '.$typeName -> value);
        }

        return null;
    }
    
    /**
     * @param \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $arrayType
     * @param int $size
     * @return array
     */
    private function arrayProperty(\Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $arrayType, int $size, string $path): array
    {
        $count = $this -> u32();
        $value =  null;
        if($arrayType === \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty)
        {
            $propName = $this -> fString();
            $propType = $this -> fString();
            $this -> u64();
			$typeName = $this -> fString();
            $typeNameEnum = \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::fromString($typeName);
			$typeNameValue = $typeNameEnum === null ? $typeName : $typeNameEnum -> value;
			
            $id = $this -> guid();
            $this -> skip(1);
            
            $propValues = [];
            for($i=0; $i<$count; $i++)
            {
                $propValues[] = $this -> structValue($typeNameValue, $path.'.'.$propName);
            }
            
            $value = [
                'prop_name' => $propName,
                'prop_type' => $propType,
                'values' => $propValues,
                'type_name' => $typeNameValue,
                'id' => $id
            ];
        }
        else
        {
            $value = [
                'values' => $this -> arrayValue($arrayType, $count, $size, $path)
            ];
        }
        return $value;
    }
    
    /**
     * @param \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $arrayType
     * @param int $count
     * @param int $size
     * @return array
     * @throws \Php2Core\Exceptions\NotImplementedException
     */
    private function arrayValue(\Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $arrayType, int $count, int $size, string $path): array
    {
        $values = [];
        $callback = null;
        
        switch($arrayType)
        {
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::EnumProperty:
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::NameProperty:
                $callback = function(\Php2Core\IO\Data\BinaryStreamReader $bsr)
                {
                    return $bsr -> fString();
                };
                break;
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Guid:
                $callback = function(\Php2Core\IO\Data\BinaryStreamReader $bsr)
                {
                    return $bsr -> guid();
                };
                break;
            case \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::ByteProperty:
                if($size === $count)
                {
                    $callback = function(\Php2Core\IO\Data\BinaryStreamReader $bsr) use($size)
                    {
                        return $bsr -> bytes($size);
                    };
                }
                else
                {
                    throw new \Php2Core\Exceptions\NotImplementedException('Labelled ByteProperty not implemented');
                }
                break;
            default:
                echo '<xmp>';
                var_dump(__FILE__.':'.__LINE__);
                var_dumP($arrayType);
                var_dump($count);
                var_dump($size);
                echo '</xmp>';
                exit;
        }
        
        for($i=0; $i<$count; $i++)
        {
            $values[] = $callback($this);
        }
        
        return $values;
    }

}
