<?php
namespace Appsas;

class Asmuo
{
    private DateTime $gimimoData;

    /**
     * @throws Exception
     */
    public function __construct(private string $vardas, int $gmmd)
    {
        $this->gimimoData = new DateTime($gmmd);
    }

    public function getAmzius(): int
    {
        $now = new DateTime();
        $diff = $now->diff($this->gimimoData);
        return $diff->y;
    }

    public function getVardas(): string
    {
        return $this->vardas;
    }

    public function getGimimoData(): DateTime
    {
        return $this->gimimoData;
    }
}