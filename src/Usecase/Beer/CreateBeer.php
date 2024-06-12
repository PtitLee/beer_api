<?php

namespace App\Usecase\Beer;

use App\Entity\Beer;
use App\Entity\BeerStyle;
use App\Entity\Brewery;

class CreateBeer
{
    public function __invoke(
        string $name,
        float $abv,
        int $ibu,
        ?Brewery $brewery = null,
        ?BeerStyle $beerStyle = null
    ): Beer
    {
        $beer = new Beer();
        $beer->setName($name);
        $beer->setAbv($abv);
        $beer->setIbu($ibu);
        $beer->setBrewery($brewery);
        $beer->setStyle($beerStyle);
        $beer->setCreatedAt(new \DateTime());
        $beer->setUpdatedAt(new \DateTime());

        return $beer;
    }
}