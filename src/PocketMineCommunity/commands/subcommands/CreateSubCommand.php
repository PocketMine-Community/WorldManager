<?php

namespace PocketMineCommunity\commands\subcommands;

use PocketMineCommunity\commands\base\SubCommand;
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
            "normal" => "vanilla_normal",
            "nether" => "vanilla_nether",
            "end" => "ender",
            "flat" => "flat",
            "void" => "void"
        ];

        if(!isset($generators[$generatorType])) {
            $sender->sendMessage("§cInvalid generator type! Available types: " . implode(", ", array_keys($generators)));
            return;
        }

        $generatorClass = GeneratorManager::getInstance()->getGenerator($generators[$generatorType])->getGeneratorClass();
        Server::getInstance()->getWorldManager()->generateWorld(
            $name,
            WorldCreationOptions::create()->setGeneratorClass($generatorClass)
        );

        $sender->sendMessage("§aWorld '$name' created successfully with $generatorType generator!");
    }
}