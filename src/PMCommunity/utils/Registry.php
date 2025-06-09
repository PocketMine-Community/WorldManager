<?php

namespace PMCommunity\utils;

use PMCommunity\commands\subcommands\HelpSubCommand;
use PMCommunity\commands\WorldManagerCommand;
use pocketmine\Server;

class Registry
{

    static function initCommands() : void
    {
        $subCommands = [
            new HelpSubCommand("help", "Gives information about commands.", "/worldmanager help", [], "worldmanager.subcommand.help")
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