<?php

trait Lytis
{
    public function getLytis(): string|null
    {
        if(in_array(substr($this->getAsmensKodas(), 0, 1), [3,5])) {
            return 'Vyras';
        } elseif (in_array(substr($this->getAsmensKodas(), 0, 1), [4,6])) {
            return 'Moteris';
        } else {
            return null;
        }
    }
}