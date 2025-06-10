<?php

namespace PMCommunity\utils;

use PMCommunity\commands\subcommands\DefineSubCommand;
use PMCommunity\commands\subcommands\FlagSubCommand;
use PMCommunity\commands\subcommands\HelpSubCommand;
use PMCommunity\commands\subcommands\ListSubCommand;
use PMCommunity\commands\subcommands\Pos1SubCommand;
use PMCommunity\commands\subcommands\Pos2SubCommand;
use PMCommunity\commands\subcommands\RegionSubCommand;
use PMCommunity\commands\subcommands\RemoveSubCommand;
use PMCommunity\commands\WorldManagerCommand;
use pocketmine\Server;

class Registry {

    static function initCommands(): void {
        $subCommands = [
            new HelpSubCommand("help", "Show help message", "/rg help", [], "worldmanager.subcommand.help"),
            new RegionSubCommand(
                "region",
                "Region management commands",
                "/worldmanager region <args>",
                ["rg"],
                "worldmanager.subcommand.region"
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

        Server::getInstance()->getCommandMap()->register("rg", $command);
    }
}