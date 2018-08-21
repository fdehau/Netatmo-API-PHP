<?php

namespace Netatmo\Sdk\Commands\OAuth2;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\OAuth2;
use Netatmo\Sdk\Config;
use Netatmo\Sdk\Exceptions;

class Token extends Command
{
    protected function configure()
    {
        $this->setName("oauth2:token")
            ->setDescription("Retrieve a new set of OAuth2 tokens from Netatmo");

        $this->addArgument('client_id', InputArgument::REQUIRED);
        $this->addArgument('client_secret', InputArgument::REQUIRED);
        $this->addArgument('username', InputArgument::REQUIRED);
        $this->addArgument('password', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = Config::fromArray([
            'oauth2' => [
                'client_id' => $input->getArgument('client_id'),
                'client_secret' => $input->getArgument('client_secret'),
            ]
        ]);
        $client = new Client($config);
        $grant = new OAuth2\Grants\Password(
            $input->getArgument('username'),
            $input->getArgument('password')
        );
        try {
            $res = $client->getTokens($grant);
            json_encode($res);
        } catch (Exceptions\OAuth2Error $ex) {
            $output->writeln([
                "Request to retrieve tokens failed with status code {$ex->getCode()}:",
                json_encode(
                    [
                        'error' => $ex->getError(),
                        'error_description' => $ex->getMessage(),
                    ],
                    JSON_PRETTY_PRINT
                )
            ]);
            exit(1);
        }
    }
}
