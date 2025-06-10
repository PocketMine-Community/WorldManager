<?php

namespace PMCommunity;

use PMCommunity\listener\RegionListener;
use PMCommunity\region\RegionManager;
use PMCommunity\utils\Registry;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Filesystem;
use pocketmine\world\World;

class WorldManager extends PluginBase {

    private static self $instance;
    
    /** @var RegionManager */
    private $regionManager;
    
    /** @var array */
    private $playerPositions = [];

    public static function getInstance(): self {
        return self::$instance;
    }

    public function onEnable(): void {
        self::$instance = $this;
        $this->regionManager = new RegionManager($this);
        $this->getServer()->getPluginManager()->registerEvents(new RegionListener($this), $this);

        Registry::initCommands();
        
        $this->getLogger()->debug("WorldManager enabled!");
    }

    public function onDisable(): void {
        $this->regionManager?->saveRegions();
    }

    public function getRegionManager(): RegionManager {
        return $this->regionManager;
    }

    /**
     * Set player's position 1
     * @param string $playerName
     * @param array $position
     */
    public function setPlayerPos1(string $playerName, array $position): void {
        if (!isset($this->playerPositions[$playerName])) {
            $this->playerPositions[$playerName] = [];
        }
        $this->playerPositions[$playerName]['pos1'] = $position;
    }

    /**
     * Set player's position 2
     * @param string $playerName
     * @param array $position
     */
    public function setPlayerPos2(string $playerName, array $position): void {
        if (!isset($this->playerPositions[$playerName])) {
            $this->playerPositions[$playerName] = [];
        }
        $this->playerPositions[$playerName]['pos2'] = $position;
    }

    /**
     * Get player's position 1
     * @param string $playerName
     * @return array|null
     */
    public function getPlayerPos1(string $playerName): ?array {
        return $this->playerPositions[$playerName]['pos1'] ?? null;
    }

    /**
     * Get player's position 2
     * @param string $playerName
     * @return array|null
     */
    public function getPlayerPos2(string $playerName): ?array {
        return $this->playerPositions[$playerName]['pos2'] ?? null;
    }

    public function getVersion(): string {
        return $this->getDescription()->getVersion();
    }

    public function getHelpMessage(): string {
        $help = [
            "help" => "Show this help message",
            "region" => "Advanced region and world protection system",
            "delete" => "Delete a world",
            "duplicate" => "Duplicate a world",
            "list" => "List all worlds",
            "teleport" => "Teleport to a world",
            "create" => "Create a world",
            "load" => "Loads an existing world",
            "unload" => "Unloads an existing world",
            "rename" => "Rename a world",
        ];

        $helpMessage = "§aWorldManager §2" . $this->getVersion() . "\n";

        foreach ($help as $key => $value) {
            $helpMessage .= "§6/worldmanager $key §e» §6$value\n";
        }

        return $helpMessage;
    }

    public function deleteWorld(string $worldName): bool {
        $worldManager = $this->getServer()->getWorldManager();
        $worldPath = $this->getServer()->getDataPath() . "worlds/" . $worldName;

        if ($worldManager->isWorldLoaded($worldName)) {
            $world = $worldManager->getWorldByName($worldName);
            if ($world instanceof World) {
                $worldManager->unloadWorld($world);
            }
        }

        if (is_dir($worldPath)) {
            try {
                Filesystem::recursiveUnlink($worldPath);
                return true;
            } catch (\Throwable $e) {
                $this->getServer()->getLogger()->error("World delete error: " . $e->getMessage());
                return false;
            }
        }

        return false;
    }

    public function duplicateWorld(string $source, string $newName): bool {
        $sourcePath = $this->getServer()->getDataPath() . "worlds/" . $source;
        $targetPath = $this->getServer()->getDataPath() . "worlds/" . $newName;

        if (!is_dir($sourcePath)) {
            return false;
        }

        try {
            Filesystem::recursiveCopy($sourcePath, $targetPath);
            return true;
        } catch (\Throwable $e) {
            $this->getServer()->getLogger()->error("World copy error: " . $e->getMessage());
            return false;
        }
    }


    public function getAllWorlds(): array {
        $worldManager = $this->getServer()->getWorldManager();
        $worlds = [];
        $path = $this->getServer()->getDataPath() . "worlds/";

        foreach (scandir($path) as $file) {
            if ($file !== "." && $file !== ".." && is_dir($path . $file)) {
                $worlds[$file] = $worldManager->isWorldLoaded($file);
            }
        }

        return $worlds;
    }

    public function teleportToWorld(Player $player, string $worldName): bool {
        $worldManager = $this->getServer()->getWorldManager();

        if (!$worldManager->isWorldLoaded($worldName)) {
            if (!$worldManager->loadWorld($worldName)) {
                return false;
            }
        }

        $world = $worldManager->getWorldByName($worldName);
        if ($world instanceof World) {
            $player->teleport($world->getSpawnLocation());
            return true;
        }

        return false;
    }
}