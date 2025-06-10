<?php

namespace PMCommunity\commands;

use PMCommunity\commands\base\BaseCommand;
use pocketmine\command\CommandSender;

class WorldManagerCommand extends BaseCommand {

    public function onCommand(CommandSender $sender, array $args): void {
        $sender->sendMessage("§cUsage: /rg help");
        $sender->sendMessage("§7Use §6/rg help §7to see all available commands");
    }
}