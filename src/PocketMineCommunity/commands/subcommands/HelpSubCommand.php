<?php

namespace PocketMineCommunity\commands\subcommands;

use PocketMineCommunity\commands\base\SubCommand;
use PocketMineCommunity\WorldManager;
use pocketmine\command\CommandSender;

class HelpSubCommand extends SubCommand
{

    public function execute(CommandSender $sender, array $args): void
    {
        $page = isset($args[0]) && is_numeric($args[0]) ? (int)$args[0] : 1;
        $sender->sendMessage(WorldManager::getInstance()->getHelpMessage($page));
    }
}