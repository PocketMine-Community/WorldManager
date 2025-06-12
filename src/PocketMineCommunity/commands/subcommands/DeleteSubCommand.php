<?php

namespace PocketMineCommunity\commands\subcommands;

use PocketMineCommunity\commands\base\SubCommand;
use PocketMineCommunity\WorldManager;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class DeleteSubCommand extends SubCommand {
    public function execute(CommandSender $sender, array $args): void {
        if(empty($args)) {
            $sender->sendMessage(TextFormat::RED."Usage: /worldmanager delete <world>");
            return;
        }

        $worldName = $args[0];
        $result = WorldManager::getInstance()->deleteWorld($worldName);

        if($result) {
            $sender->sendMessage(TextFormat::GREEN."World '{$worldName}' deleted successfully!");
        } else {
            $sender->sendMessage(TextFormat::RED."Failed to delete world '{$worldName}'!");
        }
    }
}