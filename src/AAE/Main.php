<?php

namespace AAE;

use pocketmine\item\Item;

use pocketmine\Server;

use pocketmine\event\Listener;

use pocketmine\plugin\PluginBase;

use pocketmine\event\inventory\InventoryOpenEvent;

class Main extends PluginBase implements Listener{

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getLogger()->info("Enabled!");
	}

	public function onDisable(){

	}

	public function onInvOpen(InventoryOpenEvent $ev){
		$p = $ev->getPlayer();
		$contents = $p->getInventory()->getContents();
		foreach($contents as $i){
			if($i instanceof Item){
				if($i->hasEnchantments()){
					foreach($i->getEnchantments() as $e){
						if($e->getLevel() > 5){
							$p->getInventory()->removeItem($i);
							$this->getLogger()->info("Item ".$i->getName()." has been removed from ".$p->getName()."'s inv for a enchantment level over 5!");
						}
					}
				}
			}
		}
	}
}