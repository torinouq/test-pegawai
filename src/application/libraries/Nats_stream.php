<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Basis\Nats\Client;
use Basis\Nats\Stream\RetentionPolicy;
use Basis\Nats\Stream\StorageBackend;

class Nats_stream {
    private $nc;
    private $stream;

    public function __construct() {
        $this->nats_config = new Nats_config();
        $this->nc = $this->nats_config->getClient();
        $this->stream = $this->nc->getApi();
    }

    public function jetstream($name, $subjects, $message) {
        $s = $this->stream->getStream($name);
        $s->getConfiguration()
            ->setDenyDelete(false)
            // ->setRetentionPolicy(RetentionPolicy::WORK_QUEUE)
            ->setStorageBackend(StorageBackend::MEMORY)
            ->setSubjects([$name . '.' . $subjects]);
        
        $s->createIfNotExists();

        $s->put($name . '.' . $subjects, $message);

        return $s;
    }
}