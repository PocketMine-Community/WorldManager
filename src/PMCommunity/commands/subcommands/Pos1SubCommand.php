<?php

namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
use PMCommunity\WorldManager;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class Pos1SubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        if (!($sender instanceof Player)) {
            $sender->sendMessage("§cThis command can only be used in-game!");
            return;
        }

        $position = $sender->getPosition();
        WorldManager::getInstance()->setPlayerPos1($sender->getName(), [
            (int)$position->getX(),
            (int)$position->getY(),
            (int)$position->getZ()
        ]);
        
        $sender->sendMessage("§aPosition 1 set to: " . (int)$position->getX() . ", " . (int)$position->getY() . ", " . (int)$position->getZ());
    }
}