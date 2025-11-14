<?php

namespace PMCommunity\WorldManager\commands\subcommands;

use PMCommunity\WorldManager\commands\base\SubCommand;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\world\generator\GeneratorManager;
use pocketmine\world\WorldCreationOptions;

class CreateSubCommand extends SubCommand {

    public function execute(CommandSender $sender, array $args): void {
        if(!isset($args[0])) {
            $sender->sendMessage("§cUsage: " . $this->getUsage());
            return;
        }

        $name = $args[0];
        $generatorType = strtolower($args[1] ?? "normal");

        if(Server::getInstance()->getWorldManager()->loadWorld($name)) {
            $sender->sendMessage("§cWorld '$name' already exists!");
            return;
        }

        $generators = [
            "normal", "classic" => "vanilla_normal",
            "nether" => "nether",
            "flat", "superflat" => "flat",
            "void", "empty", "air" => "void"
        ];

        if(!isset($generators[$generatorType])) {
            $sender->sendMessage("§cInvalid generator type! Available types: " . implode(", ", array_keys($generators)));
            return;
        }

        $type = $generators[$generatorType];

        $generator = GeneratorManager::getInstance()->getGenerator($type);

        if (is_null($generator)){
            $sender->sendMessage("§cUnexpected error occured. Please report issue on github page.");
            return;
        }

        $generatorClass = $generator->getGeneratorClass();
        Server::getInstance()->getWorldManager()->generateWorld(
            $name,
            WorldCreationOptions::create()->setGeneratorClass($generatorClass)
        );

        $sender->sendMessage("§aWorld '$name' created successfully with $generatorType generator!");
    }
}