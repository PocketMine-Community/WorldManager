<?php

namespace PMCommunity\WorldManager\region;

use pocketmine\world\Position;

class Region {

    /** @var string */
    private $name;
    
    /** @var string */
    private $worldName;
    
    /** @var array */
    private $pos1;
    
    /** @var array */
    private $pos2;
    
    /** @var int */
    private $priority;
    
    /** @var array */
    private $flags;

    /**
     * Region constructor
     * @param string $name
     * @param string $worldName
     * @param array $pos1 [x, y, z]
     * @param array $pos2 [x, y, z]
     * @param int $priority
     * @param array $flags
     */
    public function __construct(string $name, string $worldName, array $pos1, array $pos2, int $priority = 0, array $flags = []) {
        $this->name = $name;
        $this->worldName = $worldName;
        $this->pos1 = $pos1;
        $this->pos2 = $pos2;
        $this->priority = $priority;
        
        // Set default flags if not provided
        $this->flags = array_merge([
            'build' => 'allow',
            'pvp' => 'allow',
            'entry' => 'allow',
            'mob-spawning' => 'allow'
        ], $flags);
    }

    /**
     * Check if a position is inside this region
     * @param Position $position
     * @return bool
     */
    public function isInside(Position $position): bool {
        if ($position->getWorld()->getFolderName() !== $this->worldName) {
            return false;
        }

        $x = $position->getX();
        $y = $position->getY();
        $z = $position->getZ();

        $minX = min($this->pos1[0], $this->pos2[0]);
        $maxX = max($this->pos1[0], $this->pos2[0]);
        $minY = min($this->pos1[1], $this->pos2[1]);
        $maxY = max($this->pos1[1], $this->pos2[1]);
        $minZ = min($this->pos1[2], $this->pos2[2]);
        $maxZ = max($this->pos1[2], $this->pos2[2]);

        return ($x >= $minX && $x <= $maxX) &&
               ($y >= $minY && $y <= $maxY) &&
               ($z >= $minZ && $z <= $maxZ);
    }

    /**
     * Get region name
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Get world name
     * @return string
     */
    public function getWorldName(): string {
        return $this->worldName;
    }

    /**
     * Get position 1
     * @return array
     */
    public function getPos1(): array {
        return $this->pos1;
    }

    /**
     * Get position 2
     * @return array
     */
    public function getPos2(): array {
        return $this->pos2;
    }

    /**
     * Get priority
     * @return int
     */
    public function getPriority(): int {
        return $this->priority;
    }

    /**
     * Set priority
     * @param int $priority
     */
    public function setPriority(int $priority): void {
        $this->priority = $priority;
    }

    /**
     * Get all flags
     * @return array
     */
    public function getFlags(): array {
        return $this->flags;
    }

    /**
     * Get specific flag value
     * @param string $flag
     * @return string
     */
    public function getFlag(string $flag): string {
        return $this->flags[$flag] ?? 'allow';
    }

    /**
     * Set flag value
     * @param string $flag
     * @param string $value
     */
    public function setFlag(string $flag, string $value): void {
        $this->flags[$flag] = $value;
    }

    /**
     * Check if flag allows action
     * @param string $flag
     * @return bool
     */
    public function isFlagAllowed(string $flag): bool {
        return $this->getFlag($flag) === 'allow';
    }

    /**
     * Convert region to array for saving
     * @return array
     */
    public function toArray(): array {
        return [
            'name' => $this->name,
            'world' => $this->worldName,
            'pos1' => $this->pos1,
            'pos2' => $this->pos2,
            'priority' => $this->priority,
            'flags' => $this->flags
        ];
    }

    /**
     * Create region from array
     * @param array $data
     * @return Region
     */
    public static function fromArray(array $data): Region {
        return new Region(
            $data['name'],
            $data['world'],
            $data['pos1'],
            $data['pos2'],
            $data['priority'] ?? 0,
            $data['flags'] ?? []
        );
    }

    /**
     * Get region volume
     * @return int
     */
    public function getVolume(): int {
        $width = abs($this->pos2[0] - $this->pos1[0]) + 1;
        $height = abs($this->pos2[1] - $this->pos1[1]) + 1;
        $depth = abs($this->pos2[2] - $this->pos1[2]) + 1;
        return $width * $height * $depth;
    }
}