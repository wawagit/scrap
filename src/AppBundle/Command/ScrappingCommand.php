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
        $crawler = $client->request('GET', 'http://www.symfony.com/blog/');

        $spots = [];
        $crawler->filter('h2 > a')->each(function ($node) {
            $spot = new Spot();

            $label = trim($node->text());
            $spot->setLabel($label);

            $this->spots[] = $spot;
        });

        foreach($this->spots as $spot) {
            $doctrineManager->persist($spot);
        }

        $doctrineManager->flush();

        $output->writeln('<info> => Done</info>');
    }
}


