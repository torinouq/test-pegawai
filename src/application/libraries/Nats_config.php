<?php
use Basis\Nats\Configuration;
use Basis\Nats\Client;

class Nats_config {

    public function getClient() {
        // Konfigurasi koneksi NATS
        $config = [
            'host' => '10.200.1.130',
            'jwt' => null,
            'lang' => 'php',
            'pass' => null,
            'pedantic' => false,
            'port' => 4222,
            'reconnect' => true,
            'timeout' => 1,
            'token' => null,
            'user' => null,
            'nkey' => null,
            'verbose' => false,
            'version' => 'dev',
            'tlsCertFile' => "./certs/client-cert.pem",
            'tlsKeyFile'  => "./certs/client-key.pem",
            'tlsCaFile'  => "./certs/ca-cert.pem", // Pa
        ];

        $configuration = new Configuration($config);

        // default delay mode is constant - first retry be in 1ms, second in 1ms, third in 1ms
        $configuration->setDelay(0.001);

        // linear delay mode - first retry be in 1ms, second in 2ms, third in 3ms, fourth in 4ms, etc...
        $configuration->setDelay(0.001, Configuration::DELAY_LINEAR);

        // exponential delay mode - first retry be in 10ms, second in 100ms, third in 1s, fourth if 10 seconds, etc...
        $configuration->setDelay(0.01, Configuration::DELAY_EXPONENTIAL);

        $client = new Client($configuration);

        return $client;
    }
}
