<?php

namespace App\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\BeerRepository;

readonly class BeerStyleRankingProvider implements ProviderInterface
{
    public function __construct(
        private BeerRepository $beerRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->beerRepository->beerByStyle();
    }
}