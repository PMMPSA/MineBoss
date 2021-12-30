<?php
namespace iSoftMC\iSoftCrates;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat as C;

class Main extends PluginBase{
	public function onEnable(){
	  $this->getLogger()->info(C::GREEN."§7Enabled successfully!");
		$this->getCommand("ordinary")->setExecutor(new Commands\ordinary($this));
		$this->getCommand("rare")->setExecutor(new Commands\rare($this));
		$this->getCommand("legendary")->setExecutor(new Commands\legendary($this));
		$this->getCommand("mythic")->setExecutor(new Commands\mythic($this));
		$this->getServer()->getPluginManager()->registerEvents(new Listeners\Item($this),$this);
		}
	public function onDisable(){
	  $this->getLogger()->info(C::RED."§cĐã Vô Hiệu Hóa");
		}
	}