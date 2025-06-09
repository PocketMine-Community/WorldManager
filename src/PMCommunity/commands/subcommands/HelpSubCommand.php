<?php

namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
use PMCommunity\WorldManager;
use pocketmine\command\CommandSender;

class HelpSubCommand extends SubCommand
{

    public function execute(CommandSender $sender, array $args): void
    {
        $sender->sendMessage(WorldManager::getInstance()->getHelpMessage());
    }

}