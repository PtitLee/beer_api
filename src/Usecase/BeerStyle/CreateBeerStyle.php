<?php

namespace App\Usecase\BeerStyle;

use App\Entity\BeerStyle;

class CreateBeerStyle
{
    public function __invoke(
        string $name,
    ): BeerStyle
    {
        $beerStyle = new BeerStyle();
        $beerStyle->setName($name);
        $beerStyle->setCreatedAt(new \DateTime());
        $beerStyle->setUpdatedAt(new \DateTime());

        return $beerStyle;
    }
}