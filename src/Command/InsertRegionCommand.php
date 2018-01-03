<?php
/**
 * Created by PhpStorm.
 * User: lpu
 * Date: 12/16/17
 * Time: 7:42 PM
 */

namespace App\Command;


use App\Document\Region;
use App\Service\DoctrineDocumentManager;
use App\Service\WheatherClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InsertRegionCommand extends Command
{
    const BASE_URL = '/mf3-rpc-portlet/rest/lieu/children/climat/PAYS/PAYS007';
    protected static $defaultName = 'dju_api:insert:region';
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
            ->setDescription('Insert Region Data from Meteo France web site');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $res = $this->client->get(self::BASE_URL);

        if($res->getStatusCode() == 200){

            $jsonRegions = \GuzzleHttp\json_decode($res->getBody()->getContents(), true);

            foreach ($jsonRegions as $jsonRegion){
                $region = new Region();
                $region->setName($jsonRegion['value']);
                $region->setRegionCode($jsonRegion['id']);
                $this->dm->persist($region);
            }
            try{
                $this->dm->flush();
                $io->success('Success regions add');
            }catch (\Exception $exception){
                $io->error('Fail region add');
                $io->error($exception->getMessage());
            }
        }else{
            $io->error('Fail region add');
        }
    }
}