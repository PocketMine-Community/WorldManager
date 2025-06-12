<?php

namespace PMCommunity\WorldManager\commands\base;

use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;

abstract class SubCommand implements PluginOwned {
    use PluginOwnedTrait;

    /** @var string */
    private $name;
    /** @var string */
    private $description;
    /** @var string */
    private $usage;
    /** @var string[] */
    private $aliases = [];
    /** @var string */
    private $permission;

    public function __construct(protected Plugin $plugin, string $name, string $description = "", string $usage = "", array $aliases = [], string $permission = "") {
        $this->name = $name;
        $this->description = $description;
        $this->usage = $usage;
        $this->aliases = $aliases;
        $this->permission = $permission;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getUsage(): string {
        return $this->usage;
    }

    public function getAliases(): array {
        return $this->aliases;
    }

    public function getPermission(): string {
        return $this->permission;
    }

    public function testPermission(CommandSender $sender): bool {
        if(empty($this->permission)) {
            return true;
        }

        if($sender->hasPermission($this->permission)) {
            return true;
        }

        $sender->sendMessage("You don't have permission to use this sub-command!");
        return false;
    }

    abstract public function execute(CommandSender $sender, array $args): void;
}