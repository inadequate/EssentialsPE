<?php
namespace EssentialsPE\Commands;

use EssentialsPE\BaseCommand;
use EssentialsPE\Loader;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class Broadcast extends BaseCommand{
    public function __construct(Loader $plugin){
        parent::__construct($plugin, "broadcast", "Broadcast a message.", "/broadcast <message>", ["bcast"]);
        $this->setPermission("essentials.broadcast");
    }

    public function execute(CommandSender $sender, $alias, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }
        if(count($args) < 1){
            $sender->sendMessage(TextFormat::RED . $this->getUsage());
            return false;
        }
        $sender->getServer()->broadcastMessage(TextFormat::LIGHT_PURPLE . "[Broadcast] " . TextFormat::RESET . implode(" ", $args));
        return true;
    }
}
