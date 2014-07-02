<?php
namespace EssentialsPE\Commands;

use EssentialsPE\BaseCommand;
use EssentialsPE\Loader;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Top extends BaseCommand{
    public function __construct(Loader $plugin){
        parent::__construct($plugin, "top", "Teleport to the highest block above you", "/top");
        $this->setPermission("essentials.command.top");
    }

    public function execute(CommandSender $sender, $alias, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }
        if(!$sender instanceof Player){
            $sender->sendMessage(TextFormat::RED . "Please run this command in-game.");
        }else{
            $level = $sender->getLevel();
            $block = $level->getHighestBlockAt($sender->getX(), $sender->getZ());
            if($block instanceof Vector3){
                $sender->sendMessage(TextFormat::YELLOW . "Teleporting...");
                $sender->teleport($block);
            }
        }
        return true;
    }
} 