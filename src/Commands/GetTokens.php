<?php

namespace Netatmo\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Netatmo\Client;
use Netatmo\OAuth2;
use Netatmo\Exceptions;

class GetTokens extends Command
{
    protected function configure()
    {
        $this->setName("get-tokens")
            ->setDescription("Retrieve a new set of OAuth2 tokens from Netatmo");

        $this->addArgument(
            'client_id',
            InputArgument::REQUIRED,
            'oauth2 client id'
        );
        $this->addArgument(
            'client_secret',
            InputArgument::REQUIRED,
            'oauth2 client secret'
        );
        $this->addArgument(
            'username',
            InputArgument::REQUIRED,
            'oauth2 username'
        );
        $this->addArgument(
            'password',
            InputArgument::REQUIRED,
            'oauth2 password'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = OAuth2\Config::fromArray([
            'client_id' => $input->getArgument('client_id'),
            'client_secret' => $input->getArgument('client_secret'),
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
