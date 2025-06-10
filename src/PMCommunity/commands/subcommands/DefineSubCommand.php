<?php

namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
use PMCommunity\region\Region;
use PMCommunity\WorldManager;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class DefineSubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        if (!($sender instanceof Player)) {
            $sender->sendMessage("§cThis command can only be used in-game!");
            return;
        }

        if (empty($args)) {
            $sender->sendMessage("§cUsage: /rg define <name>");
            return;
        }

        $regionName = $args[0];
        $plugin = WorldManager::getInstance();
        
        if ($plugin->getRegionManager()->regionExists($regionName)) {
            $sender->sendMessage("§cRegion '$regionName' already exists!");
            return;
        }

        $pos1 = $plugin->getPlayerPos1($sender->getName());
        $pos2 = $plugin->getPlayerPos2($sender->getName());

        if ($pos1 === null || $pos2 === null) {
            $sender->sendMessage("§cYou must set both positions first! Use /rg pos1 and /rg pos2");
            return;
        }

        $region = new Region(
            $regionName,
            $sender->getWorld()->getFolderName(),
            $pos1,
            $pos2
        );

        if ($plugin->getRegionManager()->addRegion($region)) {
            $sender->sendMessage("§aRegion '$regionName' created successfully!");
            $sender->sendMessage("§7Volume: " . $region->getVolume() . " blocks");
        } else {
            $sender->sendMessage("§cFailed to create region '$regionName'!");
        }
    }
}