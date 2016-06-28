<?php

namespace AppBundle\Command;

use AppBundle\Entity\Spot;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Goutte\Client;

class ScrappingCommand extends ContainerAwareCommand
{

    protected $spots = [];

    protected function configure()
    {
        $this
            ->setName('scrapping:go')
            ->setDescription('Get data from URL');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $input->getOption('env');

        $output->writeln("-----------------------------------------------------");
        $output->writeln('>> Scrapping Data');

        $client = new Client();
        $doctrineManager = $this->getContainer()->get('doctrine')->getManager();

        // Go to the symfony.com website
        $crawler = $client->request('GET', 'https://www.tripadvisor.fr/Search?geo=&pid=3826&typeaheadRedirect=true&redirect=&startTime=1467117962675&uiOrigin=MASTHEAD&q=surfcamp+maroc&returnTo=https%253A__2F____2F__www__2E__tripadvisor__2E__fr__2F__&searchSessionId=B787F67F93403F05C53AB22B50F8C76A1467125166655ssid');

        $spots = [];
        $spot = new Spot();

        //1st filter
        $crawler->filter('.title > span > span')->each(function ($node) use ($spot) {

            $label = trim($node->text());
            $spot->setLabel($label);

        });

        // 2nd filter
        $crawler->filter('.title > span > span')->each(function ($node) use ($spot) {

            $label = trim($node->text());
            $spot->setLabel($label);

        });

        $this->spots[] = $spot;

        foreach($this->spots as $spot) {
            $doctrineManager->persist($spot);
        }

        $doctrineManager->flush();

        $output->writeln('<info> => Done</info>');
    }
}


