<?php
namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class RenameSubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        if(count($args) < 2) {
            $sender->sendMessage("§cUsage: " . $this->getUsage());
            return;
        }

        $oldName = $args[0];
        $newName = $args[1];
        $worldManager = Server::getInstance()->getWorldManager();
        $oldPath = Server::getInstance()->getDataPath() . "worlds/" . $oldName;
        $newPath = Server::getInstance()->getDataPath() . "worlds/" . $newName;

        if(!is_dir($oldPath)) {
            $sender->sendMessage("§cWorld '$oldName' does not exist!");
            return;
        }

        if(is_dir($newPath)) {
            $sender->sendMessage("§cWorld '$newName' already exists!");
            return;
        }

        if($worldManager->isWorldLoaded($oldName)) {
            $worldManager->unloadWorld($worldManager->getWorldByName($oldName));
        }

        rename($oldPath, $newPath);
        $sender->sendMessage("§aWorld renamed from '$oldName' to '$newName'!");
    }
}