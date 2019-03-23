<?php

namespace AAE;

use pocketmine\item\Item;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

	public function onLoad(){
		@mkdir($this->getDataFolder());
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML,array("banneditems" => 383));
	}

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getLogger()->info(TF::GREEN."Enabled!");
		//if($this->getBanItem() === ){
		//	$this->getLogger()->info(TF::GOLD."The enchantment max level is changeable in the config.yml!(/root/plugins/AntiAbusiveEnchants/config.yml)");
		}
	}

	public function onDisable(){
		$this->getLogger()->info(TF::RED."Disabled!");
	}

	public function getBanItem(): array{
		return $this->config->get("banneditems");
	}

	public function onInvOpen(InventoryOpenEvent $ev){
		$p = $ev->getPlayer();
		$ban = $this->getBanItem();
		$contents = $p->getInventory()->getContents();
		foreach($contents as $i){
			if($i instanceof Item){
		
					foreach($i->getId() as $item){
						if($item === $ban){
							$p->getInventory()->removeItem($item);
							$this->getLogger()->info("Item ".$item->getName()." has been removed from ".$p->getName()."'s inv because it's a abusived item.");
					$p->sendMessage(TF::GREEN."[AntiAbusiveItem]".TF::BLUE.$i->getName()." has been removed from your inv because this is a banned item!");
							return true;
						}
					}
				}
			}
		}
	}
}
