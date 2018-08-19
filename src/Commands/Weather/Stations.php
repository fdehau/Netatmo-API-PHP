<?php

namespace Netatmo\Sdk\Commands\Weather;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\OAuth2;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Exceptions;

class Stations extends Command
{
    protected function configure()
    {
        $this->setName("weather:stations")
            ->setDescription("Get weather stations");

        $this->addArgument("access_token", InputArgument::REQUIRED);
        $this->addArgument("device_id", InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // configure client
        $config = new OAuth2\Config(null, null);
        $client = new Client($config);
        $token = new OAuth2\Token($input->getArgument("access_token"));
        $client->setAccessToken($token);

        // prepare request
        $request = Requests\Weather\Stations::getDevice($input->getArgument("device_id"));
        $options = Requests\Options::fromArray(['decode_body' => false]);
        try {
            $res = $client->send($request, $options);
            echo json_encode($res) . PHP_EOL;
        } catch (Exceptions\ApiError $ex) {
            echo $ex->getMessage() . PHP_EOL;
            exit(1);
        }
    }
}
