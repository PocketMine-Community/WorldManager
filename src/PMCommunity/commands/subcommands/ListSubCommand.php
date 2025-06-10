<?php

namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
use PMCommunity\WorldManager;
use pocketmine\command\CommandSender;

class ListSubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        $regions = WorldManager::getInstance()->getRegionManager()->getRegions();
        
        if (empty($regions)) {
            $sender->sendMessage("§eNo regions defined.");
            return;
        }

        $sender->sendMessage("§a=== Regions (" . count($regions) . ") ===");
        
        foreach ($regions as $region) {
            $pos1 = $region->getPos1();
            $pos2 = $region->getPos2();
            
            $sender->sendMessage("§6" . $region->getName() . " §7(Priority: " . $region->getPriority() . ")");
            $sender->sendMessage("  §7World: " . $region->getWorldName());
            $sender->sendMessage("  §7Pos1: " . implode(", ", $pos1) . " | Pos2: " . implode(", ", $pos2));
            $sender->sendMessage("  §7Volume: " . $region->getVolume() . " blocks");
            
            $flags = $region->getFlags();
            $flagStrings = [];
            foreach ($flags as $flag => $value) {
                $color = $value === 'allow' ? '§a' : '§c';
                $flagStrings[] = $color . $flag . ': ' . $value;
            }
            $sender->sendMessage("  §7Flags: " . implode("§7, ", $flagStrings));
            $sender->sendMessage("");
        }
    }
}