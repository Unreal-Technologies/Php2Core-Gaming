<?php
namespace Php2Core\Gaming\Games\Palworld;

class StaticData implements \Php2Core\Gaming\Engines\Unreal\IGvasData
{
	/**
	 * @return [\Closure, \Closure]
	 */
	public function CustomProperties(): array
	{
		return [
			'.worldSaveData.GroupSaveDataMap' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\Group::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\Group::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.CharacterSaveParameterMap.Value.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\Character::encode();
				 },
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\Character::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.ItemContainerSaveData.Value.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\ItemContainer::encode();
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\ItemContainer::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.ItemContainerSaveData.Value.Slots.Slots.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\ItemContainerSlot::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\ItemContainerSlot::decode($reader, $typeName, $size, $path);
				}
			],
			'.worldSaveData.CharacterContainerSaveData.Value.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\Debug::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\Debug::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.CharacterContainerSaveData.Value.Slots.Slots.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\CharacterContainer::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\CharacterContainer::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.DynamicItemSaveData.DynamicItemSaveData.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\DynamicItem::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\DynamicItem::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\FoliageModel::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\FoliageModel::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value.InstanceDataMap.Value.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\FoliageModelInstance::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\FoliageModelInstance::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.BaseCampSaveData.Value.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\BaseCamp::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path) 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\BaseCamp::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.BaseCampSaveData.Value.WorkerDirector.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\WorkerDirector::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\WorkerDirector::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.BaseCampSaveData.Value.WorkCollection.RawData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\WorkCollection::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\WorkCollection::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.BaseCampSaveData.Value.ModuleMap' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\BaseCampModule::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\BaseCampModule::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.WorkSaveData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\Work::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\Work::decode($reader, $typeName, $size, $path); 
				}
			],
			'.worldSaveData.MapObjectSaveData' => [
				function() 
				{ 
					\Php2Core\Gaming\Games\Palworld\StaticData\MapObject::encode(); 
				},
				function(\Php2Core\Gaming\Engines\Unreal\Gvas\Reader $reader, \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes $typeName, int $size, string $path): array 
				{ 
					return \Php2Core\Gaming\Games\Palworld\StaticData\MapObject::decode($reader, $typeName, $size, $path); 
				}
			]
		];
	}
	
	/**
	 * @return array
	 */
	public function TypeHints(): array
	{
		return [
		    ".worldSaveData.CharacterContainerSaveData.Key"                                                                    => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.CharacterSaveParameterMap.Key"                                                                     => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.CharacterSaveParameterMap.Value"                                                                   => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.FoliageGridSaveDataMap.Key"                                                                        => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value"                                                       => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value.InstanceDataMap.Key"                                   => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value.InstanceDataMap.Value"                                 => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.FoliageGridSaveDataMap.Value"                                                                      => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.ItemContainerSaveData.Key"                                                                         => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.MapObjectSaveData.MapObjectSaveData.ConcreteModel.ModuleMap.Value"                                 => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.MapObjectSaveData.MapObjectSaveData.Model.EffectMap.Value"                                         => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Key"                                                               => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Value"                                                             => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Value.SpawnerDataMapByLevelObjectInstanceId.Key"                   => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Guid,
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Value.SpawnerDataMapByLevelObjectInstanceId.Value"                 => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Value.SpawnerDataMapByLevelObjectInstanceId.Value.ItemMap.Value"   => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.WorkSaveData.WorkSaveData.WorkAssignMap.Value"                                                     => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.BaseCampSaveData.Key"                                                                              => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Guid,
		    ".worldSaveData.BaseCampSaveData.Value"                                                                            => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.BaseCampSaveData.Value.ModuleMap.Value"                                                            => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.ItemContainerSaveData.Value"                                                                       => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.CharacterContainerSaveData.Value"                                                                  => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.GroupSaveDataMap.Key"                                                                              => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Guid,
		    ".worldSaveData.GroupSaveDataMap.Value"                                                                            => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.EnemyCampSaveData.EnemyCampStatusMap.Value"                                                        => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.DungeonSaveData.DungeonSaveData.MapObjectSaveData.MapObjectSaveData.Model.EffectMap.Value"         => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.DungeonSaveData.DungeonSaveData.MapObjectSaveData.MapObjectSaveData.ConcreteModel.ModuleMap.Value" => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.InvaderSaveData.Key"                                                                               => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Guid,
		    ".worldSaveData.InvaderSaveData.Value"                                                                             => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.OilrigSaveData.OilrigMap.Value"                                                                    => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty,
		    ".worldSaveData.SupplySaveData.SupplyInfos.Key"                                                                    => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::Guid,
		    ".worldSaveData.SupplySaveData.SupplyInfos.Value"                                                                  => \Php2Core\Gaming\Engines\Unreal\Gvas\PropertyTypes::StructProperty
		];
	}
}
