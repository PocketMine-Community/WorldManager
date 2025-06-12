<?php

namespace PocketMineCommunity\commands\subcommands;

use PocketMineCommunity\commands\base\SubCommand;
use PocketMineCommunity\region\Region;
use PocketMineCommunity\WorldManager;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class RegionSubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        if (empty($args)) {
            $this->sendUsage($sender);
            return;
        }

        $subCommand = strtolower(array_shift($args));

        switch ($subCommand) {
            case 'pos1':
                $this->handlePos1($sender);
                break;
            case 'pos2':
                $this->handlePos2($sender);
                break;
            case 'define':
                $this->handleDefine($sender, $args);
                break;
            case 'flag':
                $this->handleFlag($sender, $args);
                break;
            case 'remove':
            case 'delete':
                $this->handleRemove($sender, $args);
                break;
            case 'list':
                $this->handleList($sender);
                break;
            default:
                $this->sendUsage($sender);
        }
    }

    private function sendUsage(CommandSender $sender): void {
        $sender->sendMessage(TextFormat::GOLD . "=== Region Commands ===");
        $sender->sendMessage(TextFormat::YELLOW . "/worldmanager region pos1" . TextFormat::GRAY . " - Set position 1");
        $sender->sendMessage(TextFormat::YELLOW . "/worldmanager region pos2" . TextFormat::GRAY . " - Set position 2");
        $sender->sendMessage(TextFormat::YELLOW . "/worldmanager region define <name>" . TextFormat::GRAY . " - Create a region");
        $sender->sendMessage(TextFormat::YELLOW . "/worldmanager region flag <region> <flag> <allow|deny>" . TextFormat::GRAY . " - Set region flag");
        $sender->sendMessage(TextFormat::YELLOW . "/worldmanager region remove <region>" . TextFormat::GRAY . " - Remove a region");
        $sender->sendMessage(TextFormat::YELLOW . "/worldmanager region list" . TextFormat::GRAY . " - List all regions");
    }

    private function handlePos1(CommandSender $sender): void {
        if (!($sender instanceof Player)) {
            $sender->sendMessage("§cThis command can only be used in-game!");
            return;
        }

        $position = $sender->getPosition();
        WorldManager::getInstance()->setPlayerPos1($sender->getName(), [
            (int)$position->getX(),
            (int)$position->getY(),
            (int)$position->getZ()
        ]);

        $sender->sendMessage("§aPosition 1 set to: " . (int)$position->getX() . ", " . (int)$position->getY() . ", " . (int)$position->getZ());
    }

    private function handlePos2(CommandSender $sender): void {
        if (!($sender instanceof Player)) {
            $sender->sendMessage("§cThis command can only be used in-game!");
            return;
        }

        $position = $sender->getPosition();
        WorldManager::getInstance()->setPlayerPos2($sender->getName(), [
            (int)$position->getX(),
            (int)$position->getY(),
            (int)$position->getZ()
        ]);

        $sender->sendMessage("§aPosition 2 set to: " . (int)$position->getX() . ", " . (int)$position->getY() . ", " . (int)$position->getZ());
    }

    private function handleDefine(CommandSender $sender, array $args): void {
        if (!($sender instanceof Player)) {
            $sender->sendMessage("§cThis command can only be used in-game!");
            return;
        }

        if (empty($args)) {
            $sender->sendMessage("§cUsage: /worldmanager region define <name>");
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
            $sender->sendMessage("§cYou must set both positions first! Use /worldmanager region pos1 and /worldmanager region pos2");
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

    private function handleFlag(CommandSender $sender, array $args): void {
        if (count($args) < 3) {
            $sender->sendMessage("§cUsage: /worldmanager region flag <region> <flag> <allow|deny>");
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

    private function handleRemove(CommandSender $sender, array $args): void {
        if (empty($args)) {
            $sender->sendMessage("§cUsage: /worldmanager region remove <region>");
            return;
        }

        $regionName = $args[0];

        if (WorldManager::getInstance()->getRegionManager()->removeRegion($regionName)) {
            $sender->sendMessage("§aRegion '$regionName' removed successfully!");
        } else {
            $sender->sendMessage("§cRegion '$regionName' not found!");
        }
    }

    private function handleList(CommandSender $sender): void {
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