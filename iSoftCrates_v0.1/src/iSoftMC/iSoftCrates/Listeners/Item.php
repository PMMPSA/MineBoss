<?php
namespace iSoftMC\iSoftCrates\Listeners;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\inventory\Inventory;
use pocketmine\event\player\PlayerItemHeldEvent;
class Item extends PluginBase implements Listener{
	 public function __construct($plugin){
	      $this->plugin = $plugin;
		}
	 public function onItemHeld(PlayerItemHeldEvent $event){
	      $item = $event->getItem();
	      $player = $event->getPlayer();
	      $inv = $player->getInventory();
	      if($item->getId() == 381){
		        $player->sendPopup("§f[§aVật Phẩm Để Quay Rương§f]");
		}
     }
   }