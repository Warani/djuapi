<?php

namespace App\Command;


use App\Document\Statement;
use App\Document\Station;
use App\Service\DoctrineDocumentManager;
use App\Service\WheatherClient;
use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

class InsertStatementCommand extends Command
{
    const BASE_URL = '/mf3-rpc-portlet/rest/climat/RELEVES/ANNUELLE/STATID/STATION_CLIM_FR?echeance=0201YEAR';

    protected static $defaultName = 'dju_api:insert:statement';

    private $dm;
    private $client;

    public function __construct($name = null, DoctrineDocumentManager $documentManager, WheatherClient $client)
    {
        parent::__construct($name);
        $this->dm = $documentManager->getManager();
        $this->client = $client->getClient();
    }

    protected function configure()
    {
        $this
            ->setDescription('Insert Statement Data from Meteo France web site');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $stopWatch = new Stopwatch();
        $stopWatch->start('statement');
        $stations = $this->dm->getRepository(Station::class)->findAll();


        foreach ($stations as $station){
            $io->note("Start Insert For station ". $station->getName());
            $startYear = Carbon::create(2003);
            $endYear = Carbon::create();
            $progress = new ProgressBar($output, $startYear->diffInYears($endYear));

            while ($startYear <= $endYear){
                $url = str_replace('STATID', $station->getstationCode(), self::BASE_URL);
                $url = str_replace('YEAR', $startYear->year, $url);
                $res = $this->client->get($url);
                if($res->getStatusCode() == 200){
                    $data = \GuzzleHttp\json_decode($res->getBody()->getContents(), true);
                    $series = $data['listSeries'];
                    foreach ($series as $elem){
                        $statement = new Statement();
                        $statement->setStation($station);
                        $statement->setYear($startYear->year);
                        $statement->setType($elem['nomParametre']);
                        $statement->setUnit($elem['unite']);
                        $statement->setValues($elem['valeurs']);
                        $this->dm->persist($statement);
                    }
                }else{
                    $io->error('Faill get Data for station '.$station->getStationCode(). ' in '.$startYear);
                }
                $progress->advance();
                $startYear->addYear(1);
            }
            $progress->finish();
            try{
                $this->dm->flush();
                $this->dm->clear(Statement::class);
            }catch (\Exception $exception){
                $io->error($exception->getMessage());
            }

            $io->writeln('');
            $io->note("End Insert For station ". $station->getName());
        }
        $stopWatch->stop('statement');
        $io->comment(Helper::formatMemory($stopWatch->getEvent('statement')->getMemory()));
        $io->comment(Helper::formatTime($stopWatch->getEvent('statement')->getDuration()/1000));

    }
}