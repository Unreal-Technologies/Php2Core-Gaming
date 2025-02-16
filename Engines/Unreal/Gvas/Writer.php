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
    private function property(array $property): void
    {
        $this -> fString($property['path']);
        
        $nested = new Writer();
        
        $size = $nested -> propertyNested($property['path'], $property);
        $buffer = (string)$nested;

        $this -> u64($size);
        $this -> write($buffer, strlen($buffer));
    }
    
    /**
     * @param string $type
     * @param array $property
     * @return int
     */
    private function propertyNested(string $type, array $property): int
    {
        switch($type)
        {
			case 'EnumProperty':
				$this -> fString($property["value"]["type"]);
				$this -> optionalGuid($property["id"]);
				$start = $this -> tell();
				$this -> fString($property["value"]["value"]);
				return $this -> tell() - $start;
            case 'StrProperty':
                $this -> optionalGuid($property['id']);
                $start = $this -> tell();
                $this -> fString($property['value']);
                return $this -> tell() - $start;
            case 'BoolProperty':
                $this -> bool($property['value']);
                $this -> optionalGuid($property['id']);
                return 0;
            case 'FloatProperty':
                $this -> optionalGuid($property['id']);
                $this -> float($property['value']);
                return 4;
            case 'IntProperty':
                $this -> optionalGuid($property['id']);
                $this -> i32($property['value']);
                return 4;
            case 'StructProperty':
                return $this -> struct($property);
            default:
                echo '<xmp>';
                var_dump(__FILE__.':'.__LINE__);
                var_dumP($type);
                print_r($property);
                echo '</xmp>';
        }
        return 0;
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
        $this -> structValue($property['struct_type'], $property['value']);
        return $this -> tell() - $start;
    }
    
    private function structValue(string $structType, mixed $value): void
    {
        switch($structType)
        {
            case 'DateTime':
                $this -> u64($value);
                break;
            case 'Vector':
            case 'Guid':
            case 'Quat':
            case 'LinearColor':
                echo '<xmp>';
                var_dump(__FILE__.':'.__LINE__);
                var_dumP($structType);
                print_r($value);
                echo '</xmp>';
                break;
            default:
                $this -> properties($value);
                break;
        }
//        if struct_type == "Vector":
//            self.vector_dict(value)
//        elif struct_type == "DateTime":
//            self.u64(value)
//        elif struct_type == "Guid":
//            self.guid(value)
//        elif struct_type == "Quat":
//            self.quat_dict(value)
//        elif struct_type == "LinearColor":
//            self.float(value["r"])
//            self.float(value["g"])
//            self.float(value["b"])
//            self.float(value["a"])
//        else:
//            if self.debug:
//                print(f"Assuming struct type: {struct_type}")
//            return self.properties(value)
    }
}
