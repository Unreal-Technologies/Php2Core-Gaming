<?php
namespace Php2Core\Gaming\Engines\Unreal\Gvas;

enum PropertyTypes: string
{
    use \Php2Core\Data\Collections\Enum\TInfo;

    case ArrayProperty = 'ArrayProperty';
    case EnumProperty = 'EnumProperty';
    case StructProperty = 'StructProperty';
    case Guid = 'Guid';
    case MapProperty = 'MapProperty';
    case NameProperty = 'NameProperty';
    case StrProperty = 'StrProperty';
    case BoolProperty = 'BoolProperty';
    case IntProperty = 'IntProperty';
    case FloatProperty = 'FloatProperty';
    case DateTime = 'DateTime';
    case LinearColor = 'LinearColor';
    case Vector = 'Vector';
    case Quat = 'Quat';
    case ByteProperty = 'ByteProperty';
    case None = 'None';
    case Int64Property = 'Int64Property';
    case FixedPoint64 = 'FixedPoint64';
}