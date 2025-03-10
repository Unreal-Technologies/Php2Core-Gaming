<?php
namespace Php2Core\Gaming\Engines\Unreal\Gvas;

class Writer extends \Php2Core\IO\Data\BinaryStreamWriter
{
    /**
     * @return void
     */
    public function trailer(): void
    {
        $this -> write(chr(0).chr(0).chr(0).chr(0), 4);
    }
    
    /**
     * @param array $properties
     * @return void
     */
    public function properties(array $properties): void
    {
        foreach($properties as $k => $v)
        {
            $this -> fString($k);
            $this -> property($v);
        }
        $this -> fString('None');
    }
    
    /**
     * @param array $property
     * @return void
     */
    public function property(array $property): void
    {
        $this -> fString($property['type'] -> value);
        
        $nw = new Writer();
        $size = $nw -> propertyInner($property['type'], $property);
        $buffer = $nw -> bytes();
        
        $this -> u64($size);
        $this -> write($buffer, strlen($buffer));
    }
    
    /**
     * @param PropertyTypes $type
     * @param array $property
     * @return int
     * @throws \Php2Core\Exceptions\NotImplementedException
     */
    private function propertyInner(PropertyTypes $type, array $property): int
    {
        $size = 0;
        if(isset($property['custom_property']))
        {
            throw new \Php2Core\Exceptions\NotImplementedException('Custom Property');
        }
        else
        {
            switch($type)
            {
                case PropertyTypes::IntProperty:
                    $this -> optionalGuid($property['id']);
                    $this -> i32($property['value']);
                    $size = 4;
                    break;
                case PropertyTypes::StructProperty:
                    $size = $this -> struct($property);
                    break;
                case PropertyTypes::EnumProperty:
                    $this -> fString($property['value']['type']);
                    $this -> optionalGuid($property['id']);
                    
                    $start = $this -> tell();
                    $this -> fString($property['value']['value']);
                    $size = $this -> tell() - $start;
                    break;
                case PropertyTypes::StrProperty:
                    $this -> optionalGuid($property['id']);
                    $start = $this -> tell();
                    $this -> fString($property['value']);
                    $size = $this -> tell() - $start;
                    break;
                case PropertyTypes::BoolProperty:
                    $this -> bool((int)$property['value'] === 0 ? false : true);
                    $this -> optionalGuid($property['id']);
                    break;
                case PropertyTypes::FloatProperty:
                    $this -> optionalGuid($property['id']);
                    $this -> float($property['value']);
                    $size = 4;
                    break;
                default:
                    throw new \Php2Core\Exceptions\NotImplementedException('ProprtyType: '.$type -> value);
            }
            
        }
        return $size;
    }
    
    /**
     * @param array $property
     * @return int
     */
    private function struct(array $property): int
    {
        $this -> fString($property['struct_type']);
        $this -> guid($property['struct_id']);
        $this -> optionalGuid($property['id']);
        $start = $this -> tell();
        $this -> structValue(PropertyTypes::fromString($property['struct_type']), $property['value']);
        return $this -> tell() - $start;
    }
    
    /**
     * @param PropertyTypes|null $type
     * @param mixed $value
     * @return void
     * @throws \Php2Core\Exceptions\NotImplementedException
     */
    private function structValue(?PropertyTypes $type, mixed $value): void
    {
        switch($type)
        {
            case PropertyTypes::DateTime:
                $this -> u64($value);
                break;
            case PropertyTypes::Vector:
            case PropertyTypes::Guid:
            case PropertyTypes::Quat:
            case PropertyTypes::LinearColor:
                throw new \Php2Core\Exceptions\NotImplementedException('PropertyType: '.$type -> value);
            default:
                $this -> properties($value);
        }
        
    }
}
