<?php
namespace EssentialsPE\Commands;

use EssentialsPE\BaseCommand;
use EssentialsPE\Loader;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class World extends BaseCommand{
    public function __construct(Loader $plugin){
        parent::__construct($plugin, "world", "Teleport between worlds", "/world <world name>");
        $this->setPermission("essentials.world");
    }

    public function execute(CommandSender $sender, $alias, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }
        if(!$sender instanceof Player){
            $sender->sendMessage(TextFormat::RED . "Please run this command in-game");
            return false;
        }
        if(count($args) !== 1){
            $sender->sendMessage(TextFormat::RED . $this->getUsage());
            return false;
        }
        if(!$sender->hasPermission("essentials.worlds.*") || !$sender->hasPermission("essentials.worlds." . strtolower($args[0]))){
            $sender->sendMessage(TextFormat::RED . "[Error] You can't teleport to this world.");
            return false;
        }
        if(!$sender->getServer()->isLevelGenerated($args[0])){
            $sender->sendMessage(TextFormat::RED . "[Error] World doesn't exists");
            return false;
        }elseif(!$sender->getServer()->isLevelLoaded($args[0])){
            $sender->sendMessage(TextFormat::YELLOW . "Level is not loaded yet. Loading...");
            if(!$sender->getServer()->loadLevel($args[0])){
                $sender->sendMessage(TextFormat::RED . "[Error] The level couldn't be loaded");
                return false;
            }
        }
        $world = $sender->getServer()->getLevelByName($args[0]);
        $sender->teleport($world->getSpawnLocation(), 0, 0);
        $sender->sendMessage(TextFormat::YELLOW . "Teleporting...");
        return true;
    }
} 
