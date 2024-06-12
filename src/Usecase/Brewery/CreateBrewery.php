<?php

namespace App\Usecase\Brewery;

use App\Entity\Brewery;

class CreateBrewery
{
    public function __invoke(
        string $name,
        ?string $street = null,
        ?string $city = null,
        ?string $country = null
    ): Brewery
    {
        $brewery = new Brewery();
        $brewery->setName($name);
        $brewery->setStreet($street);
        $brewery->setCity($city);
        $brewery->setCountry($country);
        $brewery->setCreatedAt(new \DateTime());
        $brewery->setUpdatedAt(new \DateTime());

        return $brewery;
    }
}