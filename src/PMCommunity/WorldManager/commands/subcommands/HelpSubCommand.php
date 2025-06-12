<?php

namespace PMCommunity\WorldManager\commands\subcommands;

use PMCommunity\WorldManager\commands\base\SubCommand;
use PMCommunity\WorldManager\WorldManager;
use pocketmine\command\CommandSender;

class HelpSubCommand extends SubCommand
{

    public function execute(CommandSender $sender, array $args): void
    {
        $page = isset($args[0]) && is_numeric($args[0]) ? (int)$args[0] : 1;
        $sender->sendMessage(WorldManager::getInstance()->getHelpMessage($page));
    }
}