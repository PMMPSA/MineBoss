<?php

namespace autoinv;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;

class Main extends PluginBase implements Listener {

  
  public function onEnable() {
    
    $this->getServer()->getPluginManager()->registerEvents($this,$this);
    
    }
    
  public function onBreak(BlockBreakEvent $ev) {
    if($ev->isCancelled()) {
    return false;
    }
   
				$p = $ev->getPlayer();
				$block = $ev->getBlock();
				
				switch($ev->getBlock()->getId()){
						case 1:
						$ev->setDrops([Item::get(1, 0, 1)]);
						break;
						
						case 2:
						$ev->setDrops([Item::get(2, 0, 1)]);
						break;
						
						case 3:
						$ev->setDrops([Item::get(3, 0, 1)]);
						break;
						
						case 4:
						$ev->setDrops([Item::get(4, 0, 1)]);
						break;
						
						case 129:
						$ev->setDrops([Item::get(129, 0, 1)]);
						break;
						
						case 73:
						$ev->setDrops([Item::get(331, 0, 2)]);
						break;
						
						case 21:
						$ev->setDrops([Item::get(21, 0, 1)]);
						break;
						
						case 56:
						$ev->setDrops([Item::get(56, 0, 1)]);
						break;
						
						case 14:
						$ev->setDrops([Item::get(14, 0, 1)]);
						break;
						
						case 16:
						$ev->setDrops([Item::get(263, 0, 2)]);
						break;
						
						case 15:
						$ev->setDrops([Item::get(15, 0, 1)]);
						break;
			   
				}
				 $drop = $ev->getDrops();
				  
				 $ev->setDrops([Item::get(0, 0, 0)]);
				  
				 foreach($drop as $entry) {
					
				 $p->getInventory()->addItem($entry);
				}
				
  }
 }