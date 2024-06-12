<?php

namespace App\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\CheckinRepository;

readonly class EvalRankingProvider implements ProviderInterface
{
    public function __construct(
        private CheckinRepository $checkinRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $bestCheckins = $this->checkinRepository->findBy([], ['eval' => 'DESC'], 10);

        $beers = [];
        foreach ($bestCheckins as $checkin) {
            $beers[] = $checkin->getBeer();
        }

        return $beers;
    }
}