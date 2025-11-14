<?php

namespace PMCommunity\WorldManager\utils;

use PMCommunity\WorldManager\commands\subcommands\CreateSubCommand;
use PMCommunity\WorldManager\commands\subcommands\DeleteSubCommand;
use PMCommunity\WorldManager\commands\subcommands\DuplicateSubCommand;
use PMCommunity\WorldManager\commands\subcommands\HelpSubCommand;
use PMCommunity\WorldManager\commands\subcommands\ListSubCommand;
use PMCommunity\WorldManager\commands\subcommands\LoadSubCommand;
use PMCommunity\WorldManager\commands\subcommands\RegionSubCommand;
use PMCommunity\WorldManager\commands\subcommands\RenameSubCommand;
use PMCommunity\WorldManager\commands\subcommands\TeleportSubCommand;
use PMCommunity\WorldManager\commands\subcommands\UnloadSubCommand;
use PMCommunity\WorldManager\commands\WorldManagerCommand;
use PMCommunity\WorldManager\generator\VoidGenerator;
use PMCommunity\WorldManager\WorldManager;
use pocketmine\Server;
use pocketmine\world\generator\GeneratorManager;

class Registry {

    static function initCommands(): void {
        $subCommands = [
            new HelpSubCommand(WorldManager::getInstance(),
                "help",
                "Show help message",
                "/worldmanager help",
                [],
                "worldmanager.subcommand.help"
            ),
            new RegionSubCommand(WorldManager::getInstance(),
                "region",
                "Region management commands",
                "/worldmanager region <args>",
                ["rg"],
                "worldmanager.subcommand.region"
            ),
            new DeleteSubCommand(WorldManager::getInstance(),
                "delete",
                "Delete a world",
                "/worldmanager delete <world>",
                [],
                "worldmanager.subcommand.delete"
            ),
            new DuplicateSubCommand(WorldManager::getInstance(),
                "duplicate",
                "Duplicate a world",
                "/worldmanager duplicate <source> <newName>",
                ["clone"],
                "worldmanager.subcommand.duplicate"
            ),
            new ListSubCommand(WorldManager::getInstance(),
                "list",
                "List all worlds",
                "/worldmanager list",
                ["ls"],
                "worldmanager.subcommand.list"
            ),
            new TeleportSubCommand(WorldManager::getInstance(),
                "tp",
                "Teleport to a world",
                "/worldmanager tp <world>",
                ["teleport"],
                "worldmanager.subcommand.tp"
            ),
            new CreateSubCommand(WorldManager::getInstance(),
                "create",
                "Create a new world",
                "/worldmanager create <name> <generator>",
                ["new"],
                "worldmanager.subcommand.create"
            ),
            new LoadSubCommand(WorldManager::getInstance(),
                "load",
                "Load an existing world",
                "/worldmanager load <name>",
                [],
                "worldmanager.subcommand.load"
            ),
            new UnloadSubCommand(WorldManager::getInstance(),
                "unload",
                "Unload an existing world",
                "/worldmanager unload <name>",
                [],
                "worldmanager.subcommand.unload"
            ),
            new RenameSubCommand(WorldManager::getInstance(),
                "rename",
                "Rename a world",
                "/worldmanager rename <oldName> <newName>",
                [],
                "worldmanager.subcommand.rename"
            )
        ];

        $command = new WorldManagerCommand(WorldManager::getInstance(),
            "worldmanager",
            "Advanced world management system",
            "/worldmanager <args>",
            ["wm"]
        );

        foreach ($subCommands as $subCommand) {
            $command->registerSubCommand($subCommand);
        }

        Server::getInstance()->getCommandMap()->register("worldmanager", $command);
    }

    static function initGenerators() : void
    {
        $gens = [
            "void" => VoidGenerator::class // TODO: Ender generator
        ];

        foreach ($gens as $gen => $class) {
            GeneratorManager::getInstance()->addGenerator($class, $gen, fn() => null, true);
        }
    }
}