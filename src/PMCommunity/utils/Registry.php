<?php

namespace PMCommunity\utils;

use PMCommunity\commands\subcommands\DefineSubCommand;
use PMCommunity\commands\subcommands\FlagSubCommand;
use PMCommunity\commands\subcommands\HelpSubCommand;
use PMCommunity\commands\subcommands\ListSubCommand;
use PMCommunity\commands\subcommands\Pos1SubCommand;
use PMCommunity\commands\subcommands\Pos2SubCommand;
use PMCommunity\commands\subcommands\RemoveSubCommand;
use PMCommunity\commands\WorldManagerCommand;
use pocketmine\Server;

class Registry {

    static function initCommands(): void {
        $subCommands = [
            new HelpSubCommand("help", "Show help message", "/rg help", [], "worldmanager.subcommand.help"),
            new Pos1SubCommand("pos1", "Set position 1", "/rg pos1", [], "worldmanager.subcommand.pos1"),
            new Pos2SubCommand("pos2", "Set position 2", "/rg pos2", [], "worldmanager.subcommand.pos2"),
            new DefineSubCommand("define", "Create a region", "/rg define <name>", [], "worldmanager.subcommand.define"),
            new FlagSubCommand("flag", "Set region flag", "/rg flag <region> <flag> <allow|deny>", [], "worldmanager.subcommand.flag"),
            new RemoveSubCommand("remove", "Remove a region", "/rg remove <region>", ["delete"], "worldmanager.subcommand.remove"),
            new ListSubCommand("list", "List all regions", "/rg list", [], "worldmanager.subcommand.list")
        ];

        $command = new WorldManagerCommand(
            "rg",
            "Region protection system",
            "/rg <args>",
            ["region", "worldmanager"]
        );

        foreach ($subCommands as $subCommand) {
            $command->registerSubCommand($subCommand);
        }

        Server::getInstance()->getCommandMap()->register("rg", $command);
    }
}