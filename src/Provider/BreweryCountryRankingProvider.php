<?php

namespace App\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\BreweryRepository;

readonly class BreweryCountryRankingProvider implements ProviderInterface
{
    public function __construct(
        private BreweryRepository $breweryRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->breweryRepository->breweryByCountry();
    }
}