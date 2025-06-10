<?php
namespace PMCommunity\commands\subcommands;

use PMCommunity\commands\base\SubCommand;
use PMCommunity\WorldManager;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Server;

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