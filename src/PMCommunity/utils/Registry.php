<?php

namespace PMCommunity\utils;

use PMCommunity\commands\subcommands\CreateSubCommand;
use PMCommunity\commands\subcommands\DefineSubCommand;
use PMCommunity\commands\subcommands\DeleteSubCommand;
use PMCommunity\commands\subcommands\DuplicateSubCommand;
use PMCommunity\commands\subcommands\FlagSubCommand;
use PMCommunity\commands\subcommands\HelpSubCommand;
use PMCommunity\commands\subcommands\ListSubCommand;
use PMCommunity\commands\subcommands\LoadSubCommand;
use PMCommunity\commands\subcommands\Pos1SubCommand;
use PMCommunity\commands\subcommands\Pos2SubCommand;
use PMCommunity\commands\subcommands\RegionSubCommand;
use PMCommunity\commands\subcommands\RemoveSubCommand;
use PMCommunity\commands\subcommands\RenameSubCommand;
use PMCommunity\commands\subcommands\TeleportSubCommand;
use PMCommunity\commands\subcommands\UnloadSubCommand;
use PMCommunity\commands\WorldManagerCommand;
use pocketmine\Server;

class Registry {

    static function initCommands(): void {
        $subCommands = [
            new HelpSubCommand(
                "help",
                "Show help message",
                "/worldmanager help",
                [],
                "worldmanager.subcommand.help"
            ),
            new RegionSubCommand(
                "region",
                "Region management commands",
                "/worldmanager region <args>",
                ["rg"],
                "worldmanager.subcommand.region"
            ),
            new DeleteSubCommand(
                "delete",
                "Delete a world",
                "/worldmanager delete <world>",
                [],
                "worldmanager.subcommand.delete"
            ),
            new DuplicateSubCommand(
                "duplicate",
                "Duplicate a world",
                "/worldmanager duplicate <source> <newName>",
                ["clone"],
                "worldmanager.subcommand.duplicate"
            ),
            new ListSubCommand(
                "list",
                "List all worlds",
                "/worldmanager list",
                ["ls"],
                "worldmanager.subcommand.list"
            ),
            new TeleportSubCommand(
                "tp",
                "Teleport to a world",
                "/worldmanager tp <world>",
                ["teleport"],
                "worldmanager.subcommand.tp"
            ),
            new CreateSubCommand(
                "create",
                "Create a new world",
                "/worldmanager create <name>",
                ["new"],
                "worldmanager.subcommand.create"
            ),
            new LoadSubCommand(
                "load",
                "Load an existing world",
                "/worldmanager load <name>",
                [],
                "worldmanager.subcommand.load"
            ),
            new UnloadSubCommand(
                "unload",
                "Unload an existing world",
                "/worldmanager unload <name>",
                [],
                "worldmanager.subcommand.unload"
            ),
            new RenameSubCommand(
                "rename",
                "Rename a world",
                "/worldmanager rename <oldName> <newName>",
                [],
                "worldmanager.subcommand.rename"
            )
        ];

        $command = new WorldManagerCommand(
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
}