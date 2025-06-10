<?php

namespace PMCommunity\commands;

use PMCommunity\commands\base\BaseCommand;
use PMCommunity\WorldManager;
use pocketmine\command\CommandSender;

class WorldManagerCommand extends BaseCommand {

    public function onCommand(CommandSender $sender, array $args): void {
        $sender->sendMessage(WorldManager::getInstance()->getHelpMessage());
    }
}