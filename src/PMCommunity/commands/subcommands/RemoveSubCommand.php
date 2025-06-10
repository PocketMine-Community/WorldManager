<?php

namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
use PMCommunity\WorldManager;
use pocketmine\command\CommandSender;

class RemoveSubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        if (empty($args)) {
            $sender->sendMessage("§cUsage: /rg remove <region>");
            return;
        }

        $regionName = $args[0];
        
        if (WorldManager::getInstance()->getRegionManager()->removeRegion($regionName)) {
            $sender->sendMessage("§aRegion '$regionName' removed successfully!");
        } else {
            $sender->sendMessage("§cRegion '$regionName' not found!");
        }
    }
}