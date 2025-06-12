<?php

namespace PocketMineCommunity\commands\subcommands;

use PocketMineCommunity\commands\base\SubCommand;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class LoadSubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        if(!isset($args[0])) {
            $sender->sendMessage("§cUsage: " . $this->getUsage());
            return;
        }

        $name = $args[0];
        if(Server::getInstance()->getWorldManager()->isWorldLoaded($name)) {
            $sender->sendMessage("§cWorld '$name' is already loaded!");
            return;
        }

        if(!Server::getInstance()->getWorldManager()->loadWorld($name)) {
            $sender->sendMessage("§cWorld '$name' not found!");
            return;
        }

        $sender->sendMessage("§aWorld '$name' loaded successfully!");
    }
}