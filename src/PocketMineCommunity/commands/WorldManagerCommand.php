<?php

namespace PocketMineCommunity\commands;

use PocketMineCommunity\commands\base\BaseCommand;
use PocketMineCommunity\WorldManager;
use pocketmine\command\CommandSender;

class WorldManagerCommand extends BaseCommand {

    public function onCommand(CommandSender $sender, array $args): void {
        $page = isset($args[0]) && is_numeric($args[0]) ? (int)$args[0] : 1;
        $sender->sendMessage(WorldManager::getInstance()->getHelpMessage($page));
    }
}