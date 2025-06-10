<?php

namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
use PMCommunity\WorldManager;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class TeleportSubCommand extends SubCommand {
    public function execute(CommandSender $sender, array $args): void {
        if(!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED."This command can only be used in-game!");
            return;
        }

        if(empty($args)) {
            $sender->sendMessage(TextFormat::RED."Usage: /worldmanager teleport <world>");
            return;
        }

        $worldName = $args[0];
        $result = WorldManager::getInstance()->teleportToWorld($sender, $worldName);

        if(!$result) {
            $sender->sendMessage(TextFormat::RED."World '{$worldName}' not found or not loaded!");
        }
    }
}