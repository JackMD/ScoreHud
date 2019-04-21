<?php
declare(strict_types = 1);

/**
 * @name PurePermsAddon
 * @main JackMD\ScoreHud\Addons\PurePermsAddon
 */

namespace JackMD\ScoreHud\Addons
{

	use JackMD\ScoreHud\addon\AddonBase;
	use pocketmine\Player;
	use _64FF00\PurePerms\PurePerms;

	class PurePermsAddon extends AddonBase{

		/**
		 * @param Player $player
		 * @param string $string
		 * @return array
		 */
		public function getProcessedTags(Player $player, string $string): array{
			$tags = [];

			if(strpos($string, "{rank}") !== false){
				$tags["{rank}"] = str_replace("{rank}", $this->getPlayerRank($player), $string);
			}

			if(strpos($string, "{prefix}") !== false){
				$tags["{prefix}"] = str_replace("{prefix}", $this->getPrefix($player), $string);
			}

			if(strpos($string, "{suffix}") !== false){
				$tags["{suffix}"] = str_replace("{suffix}", $this->getSuffix($player), $string);
			}

			return $tags;
		}

		/**
		 * @param Player $player
		 * @return string
		 */
		public function getPlayerRank(Player $player): string{
			/** @var PurePerms $purePerms */
			$purePerms = $this->getScoreHud()->getServer()->getPluginManager()->getPlugin("PurePerms");

			if($purePerms instanceof PurePerms){
				$group = $purePerms->getUserDataMgr()->getData($player)['group'];
				if($group !== null){
					return $group;
				}else{
					return "No Rank";
				}
			}else{
				return "Plugin not found";
			}
		}

		/**
		 * @param Player $player
		 * @param null   $levelName
		 * @return string
		 */
		public function getPrefix(Player $player, $levelName = null): string{
			/** @var PurePerms $purePerms */
			$purePerms = $this->getScoreHud()->getServer()->getPluginManager()->getPlugin("PurePerms");

			if($purePerms instanceof PurePerms){
				$prefix = $purePerms->getUserDataMgr()->getNode($player, "prefix");
				if($levelName === null){
					if(($prefix === null) || ($prefix === "")){
						return "No Prefix";
					}

					return (string) $prefix;
				}else{
					$worldData = $purePerms->getUserDataMgr()->getWorldData($player, $levelName);

					if(empty($worldData["prefix"]) || $worldData["prefix"] == null){
						return "No Prefix";
					}

					return $worldData["prefix"];
				}
			}else{
				return "Plugin not found";
			}
		}

		/**
		 * @param Player $player
		 * @param null   $levelName
		 * @return string
		 */
		public function getSuffix(Player $player, $levelName = null): string{
			/** @var PurePerms $purePerms */
			$purePerms = $this->getScoreHud()->getServer()->getPluginManager()->getPlugin("PurePerms");

			if($purePerms instanceof PurePerms){
				$suffix = $purePerms->getUserDataMgr()->getNode($player, "suffix");

				if($levelName === null){
					if(($suffix === null) || ($suffix === "")){
						return "No Suffix";
					}

					return (string) $suffix;
				}else{
					$worldData = $purePerms->getUserDataMgr()->getWorldData($player, $levelName);

					if(empty($worldData["suffix"]) || $worldData["suffix"] == null){
						return "No Suffix";
					}

					return $worldData["suffix"];
				}
			}else{
				return "Plugin not found";
			}
		}
	}
}