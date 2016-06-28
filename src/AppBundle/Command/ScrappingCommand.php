<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Goutte\Client;

class ScrappingCommand extends ContainerAwareCommand
{

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

        // Go to the symfony.com website
        $crawler = $client->request('GET', 'http://www.symfony.com/blog/');

        $crawler->filter('h2 > a')->each(function ($node) {
            print $node->text()."\n";
        });

        //$doctrineManager = $this->getContainer()->get('doctrine')->getManager();
        //$doctrineRepoTemplateWidget = $doctrineManager->getRepository('CoreCommonBundle:TemplateWidget');
        //$doctrineManager->flush();

        $output->writeln('<info> => Done</info>');
    }
}


