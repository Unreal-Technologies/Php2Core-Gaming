<?php
namespace Php2Core\Gaming\Games\Palworld;

class StaticData implements \Php2Core\Gaming\Engines\Unreal\IGvasData
{
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
