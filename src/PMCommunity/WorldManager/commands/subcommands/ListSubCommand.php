<?php
namespace PMCommunity\WorldManager\commands\subcommands;

use PMCommunity\WorldManager\commands\base\SubCommand;
use PMCommunity\WorldManager\WorldManager;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class ListSubCommand extends SubCommand {
    public function execute(CommandSender $sender, array $args): void {
        $worlds = WorldManager::getInstance()->getAllWorlds();

        $sender->sendMessage(TextFormat::GOLD."=== Available Worlds (".count($worlds).") ===");
        foreach($worlds as $world => $status) {
            $color = $status ? TextFormat::GREEN : TextFormat::RED;
            $statusText = $status ? "LOADED" : "UNLOADED";
            $playerCount = $status ? count(Server::getInstance()->getWorldManager()->getWorldByName($world)->getPlayers()) : 0;
            $sender->sendMessage(TextFormat::YELLOW."- ".$world." ".$color."[".$statusText."]".($status ? TextFormat::GRAY." (".$playerCount." players)" : ""));
        }
    }
}