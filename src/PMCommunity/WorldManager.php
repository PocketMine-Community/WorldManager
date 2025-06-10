<?php

namespace PMCommunity;

use PMCommunity\listener\RegionListener;
use PMCommunity\region\RegionManager;
use PMCommunity\utils\Registry;
use pocketmine\plugin\PluginBase;

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
        if ($this->regionManager !== null) {
            $this->regionManager->saveRegions();
        }
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

    function getVersion(): string {
        return $this->getDescription()->getVersion();
    }

    function getHelpMessage(): string {
        $help = [
            "help" => "Show this help message",
            "pos1" => "Set position 1 for region definition",
            "pos2" => "Set position 2 for region definition",
            "define <name>" => "Create a region using pos1 and pos2",
            "flag <region> <flag> <allow|deny>" => "Set region flag",
            "remove <region>" => "Delete a region",
            "list" => "List all regions"
        ];

        $helpMessage = "§aWorldManager §2" . $this->getVersion() . "\n";

        foreach ($help as $key => $value) {
            $helpMessage .= "§6/worldmanager $key §e» §6$value\n";
        }

        return $helpMessage;
    }
}