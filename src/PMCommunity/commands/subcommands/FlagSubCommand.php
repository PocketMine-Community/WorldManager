<?php

namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
use PMCommunity\WorldManager;
use pocketmine\command\CommandSender;

class FlagSubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        if (count($args) < 3) {
            $sender->sendMessage("§cUsage: /rg flag <region> <flag> <allow|deny>");
            $sender->sendMessage("§7Available flags: build, pvp, entry, mob-spawning");
            return;
        }

        $regionName = $args[0];
        $flagName = $args[1];
        $flagValue = strtolower($args[2]);

        if (!in_array($flagValue, ['allow', 'deny'])) {
            $sender->sendMessage("§cFlag value must be 'allow' or 'deny'!");
            return;
        }

        $validFlags = ['build', 'pvp', 'entry', 'mob-spawning'];
        if (!in_array($flagName, $validFlags)) {
            $sender->sendMessage("§cInvalid flag! Available flags: " . implode(', ', $validFlags));
            return;
        }

        $region = WorldManager::getInstance()->getRegionManager()->getRegion($regionName);
        if ($region === null) {
            $sender->sendMessage("§cRegion '$regionName' not found!");
            return;
        }

        $region->setFlag($flagName, $flagValue);
        WorldManager::getInstance()->getRegionManager()->saveRegions();
        
        $sender->sendMessage("§aFlag '$flagName' set to '$flagValue' for region '$regionName'");
    }
}