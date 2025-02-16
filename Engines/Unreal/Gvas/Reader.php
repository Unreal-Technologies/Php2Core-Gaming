<?php
namespace Php2Core\Gaming\Engines\Unreal\Gvas;

class Reader extends \Php2Core\IO\Data\BinaryStreamReader
{
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
            $typeName = $this -> fString();
            $size = $this -> u64();
            
            $properties[$name] = $this -> property($name, $typeName, $size, $path);
        }
        return $properties;
    }
    
    /**
     * @param string $name
     * @param string $typeName
     * @param string $size
     * @return array|null
     */
    private function property(string $name, string $typeName, string $size, ?string $path=null): ?array
    {
        $path .= ($path === null ? '' : '/').$typeName;
        $value = null;
        switch($typeName)
        {
			case 'EnumProperty':
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
            case 'MapProperty':
                $keyType = $this -> fString();
                $valueType = $this -> fString();
                $id = $this -> optionalGuid();
                $this -> u32();
                $count = $this -> u32();
                
                $keyStructType = null;
                if($keyType === 'StructProperty')
                {
                    //key_struct_type = self.get_type_or(key_path, "Guid")
                    throw new \Php2Core\Exceptions\NotImplementedException();
                }
                
                $valueStructType = null;
                if($valueType === 'StructProperty')
                {
                    //value_struct_type = self.get_type_or(value_path, "StructProperty")
                    throw new \Php2Core\Exceptions\NotImplementedException();
                }
                
                $values = [];
                for($i=0; $i<$count; $i++)
                {
                    $key = $this -> propertyValue($keyType, $keyStructType);
                    $value = $this -> propertyValue($valueType, $valueStructType);
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
            case 'ArrayProperty':
                $arrayType = $this -> fstring();
                
                $value = [
                    'path' => $path,
                    'array_type' => $arrayType,
                    'id' => $this -> optionalGuid(),
                    'value' => $this -> arrayProperty($arrayType, $size - 4)
                ];
                break;
            case 'NameProperty':
            case 'StrProperty':
                $value = [
                    'path' => $path,
                    'id' => $this -> optionalGuid(),
                    'value' => $this -> fString()
                ];
                break;
            case 'BoolProperty':
                $value = [
                    'path' => $path,
                    'value' => $this -> bool(),
                    'id' => $this -> optionalGuid()
                ];
                break;
            case 'IntProperty':
                $value = [
                    'path' => $path,
                    'id' => $this -> optionalGuid(),
                    'value' => $this -> i32()
                ];
                break;
            case 'FloatProperty':
                $value = [
                    'path' => $path,
                    'id' => $this -> optionalGuid(),
                    'value' => $this -> float()
                ];
                break;
            case 'StructProperty':
                $value = $this -> struct($path);
                break;
            default:
                echo '<xmp>';
                var_dump(__FILE__.':'.__LINE__);
                var_dump($name);
                var_dump($typeName);
                var_dump($size);
                echo '</xmp>';
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
    private function structValue(string $structType): mixed
    {
        switch($structType)
        {
            case 'LinearColor':
                return $this -> colorDict();
            case 'Vector':
                return $this -> vectorDict();
            case 'DateTime':
                return $this -> u64();
            case 'Guid':
                return $this -> guid();
            case 'Quat':
                return $this -> quatDict();
            default:
                return $this -> propertiesUntilEnd();
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
     * @param string $typeName
     * @param string|null $structTypeName
     * @return mixed
     * @throws \Php2Core\Exceptions\UnexpectedValueException
     */
    private function propertyValue(string $typeName, ?string $structTypeName): mixed
    {
        switch($typeName)
        {
            case 'BoolProperty':
                return $this -> bool();
            case 'IntProperty':
                return $this -> i32();
            case 'StructProperty':
                return $this -> structValue($structTypeName);
            case 'EnumProperty':
            case 'NameProperty':
                return $this -> fString();
            default:
                throw new \Php2Core\Exceptions\UnexpectedValueException('Unknown property value type: '.$typeName);
        }

        return null;
    }
    
    /**
     * @param string $arrayType
     * @param int $size
     * @return array
     */
    private function arrayProperty(string $arrayType, int $size): array
    {
        $count = $this -> u32();
        $value =  null;
        if($arrayType === 'StructProperty')
        {
            $propName = $this -> fString();
            $propType = $this -> fString();
            $this -> u64();
            $typeName = $this -> fString();
            $id = $this -> guid();
            $this -> skip(1);
            
            $propValues = [];
            for($i=0; $i<$count; $i++)
            {
                $propValues[] = $this -> structValue($typeName);
            }
            
            $value = [
                'prop_name' => $propName,
                'prop_type' => $propType,
                'values' => $propValues,
                'type_name' => $typeName,
                'id' => $id
            ];
        }
        else
        {
            $value = [
                'values' => $this -> arrayValue($arrayType, $count, $size)
            ];
        }
        return $value;
    }
    
    /**
     * @param string $arrayType
     * @param int $count
     * @param int $size
     * @return array
     * @throws \Php2Core\Exceptions\NotImplementedException
     */
    private function arrayValue(string $arrayType, int $count, int $size): array
    {
        $values = [];
        $callback = null;
        
        switch($arrayType)
        {
            case 'EnumProperty':
            case 'NameProperty':
                $callback = function(\Php2Core\IO\Data\BinaryStreamReader $bsr)
                {
                    return $bsr -> fString();
                };
                break;
            case 'Guid':
                $callback = function(\Php2Core\IO\Data\BinaryStreamReader $bsr)
                {
                    return $bsr -> guid();
                };
                break;
            case 'ByteProperty':
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
