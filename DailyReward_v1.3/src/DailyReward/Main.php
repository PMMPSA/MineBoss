<?php

namespace DailyReward;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as F;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\event\player\{PlayerJoinEvent, PlayerQuitEvent};

class Main extends PluginBase implements Listener{
	public function onEnable(){
		@mkdir($this->getDataFolder());
		$this->saveResource("reward.yml");
		$this->saveResource("config.yml");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->config = new Config($this->getDataFolder(). "config.yml", Config::YAML, array("first_join" => "§f[§l§eQuà Online§r§f]: Ngày đầu tiên Online bạn nhận được §eSteak§f với số lượng là §e5", "daily_join" => "§f[§l§eQuà Online§r§f]: §a§l{player}§r§f bạn đã Online liên tiếp §a{count}§f ngày!"));
		$this->players = new Config($this->getDataFolder(). "players.yml", Config::YAML, array());
		$this->reward = new Config($this->getDataFolder(). "reward.yml", Config::YAML, array('1' => array('type' => 'item', 'id' => 364, 'meta' => 0, 'count' => 5, 'custom_name' => 'Quà Online', 'enchant' => array('ench_id' => 1, 'ench_level' => 1))));
		$this->getServer()->getLogger()->info(F::GREEN."DailyReward đã kích hoạt!");
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		$date = date("Y-m-d");
		$config = $this->config->getAll();
		if($this->players->exists($name)){
			$dateold = date_create($this->players->get($name)["date"]);
			$today = date_create($date);
			$interval = date_diff($dateold, $today);
			$days = $interval->format("%d");
			switch($days){
				case 0:
				    break;
				case 1:
				    $count = $this->players->get($name)["count"];
					if($this->reward->exists($count)){
						$this->players->set($name, array("date" => $date,"count" => ++$count));
						$this->giveReward($player, $count);
						$player->sendMessage(str_replace(["{player}", "{count}"], [$name, $count], $config["daily_join"]));
					}else{
						$this->players->set($name, array("date" => $date,"count" => 1));
						$player->sendMessage($config["first_join"]);
						$this->giveReward($player, 1);
					}
					$this->players->save();
					break;
				default:
				    $this->players->set($name, array("date" => $date,"count" => 1));
					$this->players->save();
					$player->sendMessage($config["first_join"]);
			}
		}else{
			$this->players->set($name, array("date" => $date,"count" => 1));
			$this->players->save();
			$player->sendMessage($config["first_join"]);
			$this->giveReward($player, 1);
		}
	}
	
	public function giveReward($player, $count){
		$reward = $this->reward->get($count);
		$type = $reward["type"];
		switch($type){
			case "item":
			    if(isset($reward["id"], $reward["meta"], $reward["count"]) && is_numeric($reward["id"]) && is_numeric($reward["meta"]) && is_numeric($reward["count"])){
					$item = Item::get($reward["id"], $reward["meta"], $reward["count"]);
					if(isset($reward["custom_name"]))$item->setCustomName($reward["custom_name"]);
					if(isset($reward["enchant"], $reward["enchant"]["ench_id"])){
						$enchant = Enchantment::getEnchantment($reward["enchant"]["ench_id"]);
						$enchantLevel = isset($reward["enchant"]["ench_level"]) ?  $reward["enchant"]["ench_level"] : 1;
						$enchant->setLevel($enchantLevel);
						$item->addEnchantment($enchant);
					}
					$player->getInventory()->addItem($item);
				}
			break;
		}
	}
}