<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Basis\Nats\Client;
use Basis\Nats\Message\Payload;

class Nats_publisher {
    private $nc;

    public function __construct() {
        $configuration = $this->nats_config->getConfiguration();    
        $this->nc = new Client($configuration);
    }

    public function publisher($subject, $message) {
        $payload = new Payload($message);
        $this->nc->publish($subject, $payload);
    }
}