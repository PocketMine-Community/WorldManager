<?php
namespace PMCommunity\WorldManager\commands\subcommands;

use PMCommunity\WorldManager\commands\base\SubCommand;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class UnloadSubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        if(!isset($args[0])) {
            $sender->sendMessage("§cUsage: " . $this->getUsage());
            return;
        }

        $name = $args[0];
        if(!Server::getInstance()->getWorldManager()->isWorldLoaded($name)) {
            $sender->sendMessage("§cWorld '$name' is not loaded!");
            return;
        }

        Server::getInstance()->getWorldManager()->unloadWorld(Server::getInstance()->getWorldManager()->getWorldByName($name));
        $sender->sendMessage("§aWorld '$name' unloaded successfully!");
    }
}