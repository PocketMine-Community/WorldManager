<?php

namespace PMCommunity;

use PMCommunity\utils\Registry;
use pocketmine\plugin\PluginBase;

class WorldManager extends PluginBase {

    private static self $instance;

    public static function getInstance(): self {
        return self::$instance;
    }

    public function onEnable(): void {
        self::$instance = $this;
        Registry::initCommands();
    }

    function getVersion(): string
    {
        return $this->getDescription()->getVersion();
    }

    function getHelpMessage() : string
    {
        $help = [
            "help" => "Gives information about commands."
        ];

        $helpMessage = "§aWorldManager §2" . $this->getVersion() . "\n";

        foreach ($help as $key => $value) {
            $helpMessage .= "§6/worldmanager $key §e» §6$value\n";
        }

        return $helpMessage;
    }

}
