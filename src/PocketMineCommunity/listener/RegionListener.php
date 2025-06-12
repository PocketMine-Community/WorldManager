<?php

namespace PocketMineCommunity\listener;

use PocketMineCommunity\WorldManager;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\SpawnEgg;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class RegionListener implements Listener {

    /** @var WorldManager */
    private $plugin;

    public function __construct(WorldManager $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * Handle block break events
     * @param BlockBreakEvent $event
     */
    public function onBlockBreak(BlockBreakEvent $event): void {
        $player = $event->getPlayer();
        $position = $event->getBlock()->getPosition();

        if ($player->hasPermission("worldmanager.region.bypass")) {
            return;
        }

        if (!$this->plugin->getRegionManager()->isActionAllowed($position, 'build')) {
            $event->cancel();
            $player->sendMessage("§cYou cannot break blocks in this region!");
        }
    }

    /**
     * Handle block place events
     * @param BlockPlaceEvent $event
     */
    public function onBlockPlace(BlockPlaceEvent $event): void {
        $player = $event->getPlayer();
        
        if ($player->hasPermission("worldmanager.region.bypass")) {
            return;
        }

        $blockAgainst = $event->getBlockAgainst();
        $position = $blockAgainst->getPosition();
        
        if (!$this->plugin->getRegionManager()->isActionAllowed($position, 'build')) {
            $event->cancel();
            $player->sendMessage("§cYou cannot place blocks in this region!");
        }
    }

    /**
     * Handle PvP events
     * @param EntityDamageByEntityEvent $event
     */
    public function onEntityDamageByEntity(EntityDamageByEntityEvent $event): void {
        $victim = $event->getEntity();
        $damager = $event->getDamager();

        if (!($victim instanceof Player) || !($damager instanceof Player)) {
            return;
        }

        if ($damager->hasPermission("worldmanager.region.bypass")) {
            return;
        }
        if (!$this->plugin->getRegionManager()->isActionAllowed($victim->getPosition(), 'pvp')) {
            $event->cancel();
            $damager->sendMessage("§cPvP is not allowed in this region!");
        }
    }

    /**
     * Handle player movement (entry protection)
     * @param PlayerMoveEvent $event
     */
    public function onPlayerMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        $from = $event->getFrom();
        $to = $event->getTo();

        if ($player->hasPermission("worldmanager.region.bypass")) {
            return;
        }

        $fromRegions = $this->plugin->getRegionManager()->getRegionsAt($from);
        $toRegions = $this->plugin->getRegionManager()->getRegionsAt($to);
        foreach ($toRegions as $region) {
            $isInFromRegions = false;
            foreach ($fromRegions as $fromRegion) {
                if ($fromRegion->getName() === $region->getName()) {
                    $isInFromRegions = true;
                    break;
                }
            }

            if (!$isInFromRegions && !$region->isFlagAllowed('entry')) {
                $event->cancel();
                $player->sendMessage("§cYou cannot enter this region!");
                return;
            }
        }
    }

    /**
     * Handle player interaction (including spawn eggs)
     * @param PlayerInteractEvent $event
     */
    public function onPlayerInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        
        if (!($item instanceof SpawnEgg)) {
            return;
        }
        if ($player->hasPermission("worldmanager.region.bypass")) {
            return;
        }
        $block = $event->getBlock();
        $clickedPosition = $block->getPosition();
        $face = $event->getFace();
        $spawnPosition = $clickedPosition->getSide($face);
        if (!$this->plugin->getRegionManager()->isActionAllowed($spawnPosition, 'mob-spawning')) {
            $event->cancel();
            $player->sendMessage("§cYou cannot spawn mobs in this region!");
            return;
        }
        if (!$this->plugin->getRegionManager()->isActionAllowed($clickedPosition, 'mob-spawning')) {
            $event->cancel();
            $player->sendMessage("§cYou cannot spawn mobs in this region!");
        }
    }
}