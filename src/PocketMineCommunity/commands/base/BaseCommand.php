<?php

namespace PocketMineCommunity\commands\base;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;

abstract class BaseCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    /** @var SubCommand[] */
    private $subCommands = [];

    public function __construct(protected Plugin $plugin, string $name, string $description = "", string $usageMessage = null, array $aliases = []) {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("worldmanager.command");
        $this->setPermissionMessage("You don't have permission to use this command!");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->testPermission($sender)) {
            return;
        }

        if(empty($args)) {
            $this->onCommand($sender, $args);
            return;
        }

        $subCommand = strtolower(array_shift($args));

        if(isset($this->subCommands[$subCommand])) {
            $subCommandInstance = $this->subCommands[$subCommand];

            if(!$subCommandInstance->testPermission($sender)) {
                return;
            }

            $subCommandInstance->execute($sender, $args);
        } else {
            $this->onCommand($sender, array_merge([$subCommand], $args));
        }
    }

    public function registerSubCommand(SubCommand $subCommand): void {
        $this->subCommands[strtolower($subCommand->getName())] = $subCommand;
        foreach($subCommand->getAliases() as $alias) {
            $this->subCommands[strtolower($alias)] = $subCommand;
        }
    }

    abstract public function onCommand(CommandSender $sender, array $args): void;

    public function getSubCommands(): array {
        return $this->subCommands;
    }
}