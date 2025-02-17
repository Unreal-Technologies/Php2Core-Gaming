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
				\Php2Core\Gaming\Games\Palworld\StaticData\Group::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\Group::decode
			],
			'.worldSaveData.CharacterSaveParameterMap.Value.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\Character::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\Character::decode
			],
			'.worldSaveData.ItemContainerSaveData.Value.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\ItemContainer::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\ItemContainer::decode
			],
			'.worldSaveData.ItemContainerSaveData.Value.Slots.Slots.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\ItemContainerSlot::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\ItemContainerSlot::decode
			],
			'.worldSaveData.CharacterContainerSaveData.Value.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\Debug::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\Debug::decode
			],
			'.worldSaveData.CharacterContainerSaveData.Value.Slots.Slots.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\CharacterContainer::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\CharacterContainer::decode
			],
			'.worldSaveData.DynamicItemSaveData.DynamicItemSaveData.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\DynamicItem::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\DynamicItem::decode
			],
			'.worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\FoliageModel::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\FoliageModel::decode
			],
			'.worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value.InstanceDataMap.Value.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\FoliageModelInstance::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\FoliageModelInstance::decode
			],
			'.worldSaveData.BaseCampSaveData.Value.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\BaseCamp::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\BaseCamp::decode
			],
			'.worldSaveData.BaseCampSaveData.Value.WorkerDirector.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\WorkerDirector::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\WorkerDirector::decode
			],
			'.worldSaveData.BaseCampSaveData.Value.WorkCollection.RawData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\WorkCollection::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\WorkCollection::decode
			],
			'.worldSaveData.BaseCampSaveData.Value.ModuleMap' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\BaseCampModule::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\BaseCampModule::decode
			],
			'.worldSaveData.WorkSaveData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\Work::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\Work::decode
			],
			'.worldSaveData.MapObjectSaveData' => [
				\Php2Core\Gaming\Games\Palworld\StaticData\MapObject::encode,
				\Php2Core\Gaming\Games\Palworld\StaticData\MapObject::decode
			]
		];
	}
	
	/**
	 * @return array
	 */
	public function TypeHints(): array
	{
		return [
		    ".worldSaveData.CharacterContainerSaveData.Key" => "StructProperty",
		    ".worldSaveData.CharacterSaveParameterMap.Key" => "StructProperty",
		    ".worldSaveData.CharacterSaveParameterMap.Value" => "StructProperty",
		    ".worldSaveData.FoliageGridSaveDataMap.Key" => "StructProperty",
		    ".worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value" => "StructProperty",
		    ".worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value.InstanceDataMap.Key" => "StructProperty",
		    ".worldSaveData.FoliageGridSaveDataMap.Value.ModelMap.Value.InstanceDataMap.Value" => "StructProperty",
		    ".worldSaveData.FoliageGridSaveDataMap.Value" => "StructProperty",
		    ".worldSaveData.ItemContainerSaveData.Key" => "StructProperty",
		    ".worldSaveData.MapObjectSaveData.MapObjectSaveData.ConcreteModel.ModuleMap.Value" => "StructProperty",
		    ".worldSaveData.MapObjectSaveData.MapObjectSaveData.Model.EffectMap.Value" => "StructProperty",
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Key" => "StructProperty",
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Value" => "StructProperty",
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Value.SpawnerDataMapByLevelObjectInstanceId.Key" => "Guid",
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Value.SpawnerDataMapByLevelObjectInstanceId.Value" => "StructProperty",
		    ".worldSaveData.MapObjectSpawnerInStageSaveData.Value.SpawnerDataMapByLevelObjectInstanceId.Value.ItemMap.Value" => "StructProperty",
		    ".worldSaveData.WorkSaveData.WorkSaveData.WorkAssignMap.Value" => "StructProperty",
		    ".worldSaveData.BaseCampSaveData.Key" => "Guid",
		    ".worldSaveData.BaseCampSaveData.Value" => "StructProperty",
		    ".worldSaveData.BaseCampSaveData.Value.ModuleMap.Value" => "StructProperty",
		    ".worldSaveData.ItemContainerSaveData.Value" => "StructProperty",
		    ".worldSaveData.CharacterContainerSaveData.Value" => "StructProperty",
		    ".worldSaveData.GroupSaveDataMap.Key" => "Guid",
		    ".worldSaveData.GroupSaveDataMap.Value" => "StructProperty",
		    ".worldSaveData.EnemyCampSaveData.EnemyCampStatusMap.Value" =>"StructProperty",
		    ".worldSaveData.DungeonSaveData.DungeonSaveData.MapObjectSaveData.MapObjectSaveData.Model.EffectMap.Value" => "StructProperty",
		    ".worldSaveData.DungeonSaveData.DungeonSaveData.MapObjectSaveData.MapObjectSaveData.ConcreteModel.ModuleMap.Value" => "StructProperty",
		    ".worldSaveData.InvaderSaveData.Key" => "Guid",
		    ".worldSaveData.InvaderSaveData.Value" =>"StructProperty",
		    ".worldSaveData.OilrigSaveData.OilrigMap.Value" => "StructProperty",
		    ".worldSaveData.SupplySaveData.SupplyInfos.Key" => "Guid",
		    ".worldSaveData.SupplySaveData.SupplyInfos.Value" => "StructProperty"
		];
	}
}
