<?php

namespace App\Command;

use App\Usecase\Beer\CreateBeer as CreateBeerUseCase;
use App\Usecase\BeerStyle\CreateBeerStyle as CreateBeerStyleUseCase;
use App\Usecase\Brewery\CreateBrewery as createBreweryUseCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(name: 'import:csv')]
final class ImportCsvCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface $serializer,
        private readonly CreateBeerUseCase $createBeerUseCase,
        private readonly CreateBeerStyleUseCase $createBeerStyleUseCase,
        private readonly CreateBreweryUseCase $createBreweryUseCase
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('Import csv data to generate Beer and Brewery entity.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Import open beer database CSV file');

        try {
            $this->import($io);
        }  catch (\Throwable $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success('Import finished');
        return Command::SUCCESS;
    }

    private function import(SymfonyStyle $io): void
    {
        $csvFile = $this->serializer->decode(file_get_contents('open-beer-database.csv'), 'csv', ['csv_delimiter' => ';']);

        $io->progressStart(count($csvFile));

        $breweries = [];
        $styles = [];

        foreach ($csvFile as $row) {
            $breweryId = (int) $row['brewery_id'] > 0 ? (int) $row['brewery_id'] : null;

            if (!isset($breweries[$breweryId])
                && $row['Brewer'] != ''
            ) {
                $breweries[$breweryId] = $this->createBreweryUseCase->__invoke(
                    $row['Brewer'],
                    $row['Address'] ?? null,
                    $row['City'] ?? null,
                    $row['Country'] ?? null
                );
            }

            $styleId = (int) $row['style_id'] > 0 ? (int) $row['style_id'] : null;

            if (!isset($styles[$styleId])
                && $row['Style'] != ''
            ) {
                $styles[$styleId] = $this->createBeerStyleUseCase->__invoke(
                    $row['Style'],
                );
            }

            $beer = $this->createBeerUseCase->__invoke(
                $row['Name'],
                round((float) $row['Alcohol By Volume'], 1),
                (int) $row['International Bitterness Units'],
                $breweryId != null ? $breweries[$breweryId] : null,
                $styleId != null ? $styles[$styleId] : null
            );

            $this->entityManager->persist($beer);
            $this->entityManager->flush();

            $io->progressAdvance();
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        $io->progressFinish();
    }
}