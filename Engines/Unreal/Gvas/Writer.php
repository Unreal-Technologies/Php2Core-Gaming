<?php
namespace Php2Core\Gaming\Engines\Unreal\Gvas;

class Writer extends \Php2Core\IO\Data\BinaryStreamWriter
{
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
//        if "custom_type" in property:
//            if property["custom_type"] in self.custom_properties:
//                size = self.custom_properties[property["custom_type"]][1](
//                    self, property_type, property
//                )
//            else:
//                raise Exception(
//                    f"Unknown custom property type: {property['custom_type']}"
//                )
//        elif property_type == "UInt16Property":
//            self.optional_guid(property.get("id", None))
//            self.u16(property["value"])
//            size = 2
//        elif property_type == "UInt32Property":
//            self.optional_guid(property.get("id", None))
//            self.u32(property["value"])
//            size = 4
//        elif property_type == "Int64Property":
//            self.optional_guid(property.get("id", None))
//            self.i64(property["value"])
//            size = 8
//        elif property_type == "FixedPoint64Property":
//            self.optional_guid(property.get("id", None))
//            self.i32(property["value"])
//            size = 4

//        elif property_type == "NameProperty":
//            self.optional_guid(property.get("id", None))
//            size = self.fstring(property["value"])
//        elif property_type == "EnumProperty":
//            self.fstring(property["value"]["type"])
//            self.optional_guid(property.get("id", None))
//            size = self.fstring(property["value"]["value"])
//        elif property_type == "ByteProperty":
//            self.fstring(property["value"]["type"])
//            self.optional_guid(property.get("id", None))
//            if property["value"]["type"] == "None":
//                self.byte(property["value"]["value"])
//                size = 1
//            else:
//                size = self.fstring(property["value"]["value"])
//        elif property_type == "ArrayProperty":
//            self.fstring(property["array_type"])
//            self.optional_guid(property.get("id", None))
//            array_writer = self.copy()
//            array_writer.array_property(property["array_type"], property["value"])
//            array_buf = array_writer.bytes()
//            size = len(array_buf)
//            self.write(array_buf)
//        elif property_type == "MapProperty":
//            self.fstring(property["key_type"])
//            self.fstring(property["value_type"])
//            self.optional_guid(property.get("id", None))
//            map_writer = self.copy()
//            map_writer.u32(0)
//            map_writer.u32(len(property["value"]))
//            for entry in property["value"]:
//                map_writer.prop_value(
//                    property["key_type"], property["key_struct_type"], entry["key"]
//                )
//                map_writer.prop_value(
//                    property["value_type"],
//                    property["value_struct_type"],
//                    entry["value"],
//                )
//            map_buf = map_writer.bytes()
//            size = len(map_buf)
//            self.write(map_buf)
//        else:
//            raise Exception(f"Unknown property type: {property_type}")
//        return size
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
    
    private function structValue(string $structType, array $struct): int
    {
        switch($structType)
        {
            case 'PalOptionWorldSaveData': //gonna be default later on
            case 'PalOptionWorldSettings':
                $this -> properties($struct);
                return 0;
            default:
                echo '<xmp>';
                var_dump(__FILE__.':'.__LINE__);
                var_dumP($structType);
                print_r($struct);
                echo '</xmp>';
                return 0;
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
