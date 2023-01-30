<?php

namespace Appsas\Models;

use Appsas\Models\ModelInterface;

class Address implements ModelInterface
{
    public int $id;
    public string $country_iso;
    public ?string $city;
    public ?string $street;
    public ?string $postcode;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'country_iso' => $this->country_iso,
            'city' => $this->city,
            'street' => $this->street,
            'postcode' => $this->postcode,
        ];
    }
}