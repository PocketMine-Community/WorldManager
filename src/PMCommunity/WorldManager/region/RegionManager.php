<?php

namespace PMCommunity\WorldManager\region;

use PMCommunity\WorldManager\WorldManager;
use pocketmine\utils\Config;
use pocketmine\world\Position;

class RegionManager {

    /** @var WorldManager */
    private $plugin;
    
    /** @var Region[] */
    private $regions = [];
    
    /** @var Config */
    private $config;

    public function __construct(WorldManager $plugin) {
        $this->plugin = $plugin;
        $this->loadRegions();
    }

    /**
     * Load regions from config file
     */
    public function loadRegions(): void {
        $this->config = new Config($this->plugin->getDataFolder() . "regions.yml", Config::YAML);
        $data = $this->config->getAll();
        
        foreach ($data as $regionData) {
            $this->regions[$regionData['name']] = Region::fromArray($regionData);
        }
        
    }

    /**
     * Save regions to config file
     */
    public function saveRegions(): void {
        $data = [];
        foreach ($this->regions as $region) {
            $data[] = $region->toArray();
        }
        
        $this->config->setAll($data);
        $this->config->save();
    }

    /**
     * Add a new region
     * @param Region $region
     * @return bool
     */
    public function addRegion(Region $region): bool {
        if (isset($this->regions[$region->getName()])) {
            return false;
        }
        
        $this->regions[$region->getName()] = $region;
        $this->saveRegions();
        return true;
    }

    /**
     * Remove a region
     * @param string $name
     * @return bool
     */
    public function removeRegion(string $name): bool {
        if (!isset($this->regions[$name])) {
            return false;
        }
        
        unset($this->regions[$name]);
        $this->saveRegions();
        return true;
    }

    /**
     * Get region by name
     * @param string $name
     * @return Region|null
     */
    public function getRegion(string $name): ?Region {
        return $this->regions[$name];
    }

    /**
     * Get all regions
     * @return Region[]
     */
    public function getRegions(): array {
        return $this->regions;
    }

    /**
     * Get regions at a specific position
     * @param Position $position
     * @return Region[]
     */
    public function getRegionsAt(Position $position): array {
        $regions = [];
        foreach ($this->regions as $region) {
            if ($region->isInside($position)) {
                $regions[] = $region;
            }
        }

        usort($regions, function(Region $a, Region $b) {
            return $b->getPriority() - $a->getPriority();
        });
        
        return $regions;
    }

    /**
     * Get the highest priority region at a position
     * @param Position $position
     * @return Region|null
     */
    public function getHighestPriorityRegion(Position $position): ?Region {
        $regions = $this->getRegionsAt($position);
        return $regions[0] ?? null;
    }

    /**
     * Check if an action is allowed at a position
     * @param Position $position
     * @param string $flag
     * @return bool
     */
    public function isActionAllowed(Position $position, string $flag): bool {
        $region = $this->getHighestPriorityRegion($position);
        
        if ($region === null) {
            return true;
        }
        
        return $region->isFlagAllowed($flag);
    }

    /**
     * Check if region name exists
     * @param string $name
     * @return bool
     */
    public function regionExists(string $name): bool {
        return isset($this->regions[$name]);
    }

    /**
     * Get region count
     * @return int
     */
    public function getRegionCount(): int {
        return count($this->regions);
    }
}