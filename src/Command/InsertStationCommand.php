<?php
/**
 * Created by PhpStorm.
 * User: lpu
 * Date: 12/16/17
 * Time: 7:42 PM
 */

namespace App\Command;


use App\Document\Region;
use App\Document\Station;
use App\Service\DoctrineDocumentManager;
use App\Service\WheatherClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InsertStationCommand extends Command
{
    const BASE_URL = 'mf3-rpc-portlet/rest/lieu/children/climat/REG_FRANCE/REGID';

    protected static $defaultName = 'dju_api:insert:station';

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
            ->setDescription('Insert Station Data from Meteo France web site');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $regions = $this->dm->getRepository(Region::class)->findAll();

        foreach ($regions as $region){
            $url = str_replace('REGID', $region->getRegionCode(), self::BASE_URL);

            $res = $this->client->get($url);

            if($res->getStatusCode() == 200){
                $jsonStations = \GuzzleHttp\json_decode($res->getBody()->getContents(), true);
                foreach ($jsonStations as $info){
                    $station = new Station();
                    $station->setName($info["nomAffiche"]);
                    $station->setStationCode($info["id"]);
                    $station->setRegion($region);
                    if($info["codePostal"]){
                        $station->setPostalCode($info["codePostal"]);
                    }
                    if($info["lat"]){
                        $station->setLat($info["lat"]);
                    }
                    if($info["lon"]){
                        $station->setLong($info["lon"]);
                    }
                    $this->dm->persist($station);
                }
            }else{

                $io->error('Fail stations add for region with id '.$region->getRegionCode());
            }

        }
        try{
            $this->dm->flush();
            $io->success('Success stations add');
        }catch (\Exception $exception){
            $io->error('Fail stations add');
            $io->error($exception->getMessage());
        }

    }
}