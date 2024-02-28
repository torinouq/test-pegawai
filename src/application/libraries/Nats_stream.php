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

    public function jetstream(string $name, string $subjects, $message) {
        $s = $this->stream->getStream($name);
        $s->getConfiguration()
            ->setRetentionPolicy(RetentionPolicy::WORK_QUEUE)
            ->setStorageBackend(StorageBackend::FILE)
            ->setSubjects([$subjects]);
        
        $s->createIfNotExists();

        $s->put($subjects, $message);

        return $s;
    }
}