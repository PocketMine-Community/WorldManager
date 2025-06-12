<?php

namespace PocketMineCommunity\commands\subcommands;

use PocketMineCommunity\commands\base\SubCommand;
use PocketMineCommunity\WorldManager;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class DuplicateSubCommand extends SubCommand {
    public function execute(CommandSender $sender, array $args): void {
        if(count($args) < 2) {
            $sender->sendMessage(TextFormat::RED."Usage: /worldmanager duplicate <source> <newName>");
            return;
        }

        $source = $args[0];
        $newName = $args[1];
        $result = WorldManager::getInstance()->duplicateWorld($source, $newName);

        if($result) {
            $sender->sendMessage(TextFormat::GREEN."World duplicated to '{$newName}' successfully!");
        } else {
            $sender->sendMessage(TextFormat::RED."Failed to duplicate world!");
        }
    }
}