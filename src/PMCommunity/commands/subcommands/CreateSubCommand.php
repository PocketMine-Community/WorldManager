<?php

namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
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
        if(Server::getInstance()->getWorldManager()->loadWorld($name)) {
            $sender->sendMessage("§cWorld '$name' already exists!");
            return;
        }

        Server::getInstance()->getWorldManager()->generateWorld($name, WorldCreationOptions::create()->setGeneratorClass(GeneratorManager::getInstance()->getGenerator("vanilla_normal")->getGeneratorClass()));

        // TODO: Generator options

        $sender->sendMessage("§aWorld '$name' created successfully!");
    }
}