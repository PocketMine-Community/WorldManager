<?php

namespace PMCommunity\WorldManager\generator;

use pocketmine\block\VanillaBlocks;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\Generator;

class VoidGenerator extends Generator
{
    public function __construct(int $seed, string $preset) { parent::__construct($seed, $preset); }

    public function populateChunk(ChunkManager $world, int $chunkX, int $chunkZ): void {}
    public function generateChunk(ChunkManager $world, int $chunkX, int $chunkZ): void
    {
        $chunk = $world->getChunk($chunkX, $chunkZ);

        if ($chunkX === 16 && $chunkZ === 16) {
            $chunk->setBlockStateId(0, 64, 0, VanillaBlocks::BEDROCK()->getStateId());
        }
    }

}