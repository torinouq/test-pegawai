<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Kontak_model $kontak
 * @property Nats_stream $nats_stream
 */


use chriskacerguis\RestServer\RestController;

class Kontak extends RESTController {

    private $stream;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // $configuration = $this->nats_config->getConfiguration();

        // Membuat klien NATS
        $this->client = $this->nats_config->getClient();
        // $this->client->connect();
    }

    //Menampilkan data kontak
    function index_get() {
        $id = $this->uri->segment(2);

        if($id === null)
        {
            $kontak = $this->kontak->get_all();
        } else {
            $kontak = $this->kontak->get_by_id($id);
        }

        if($kontak)
        {
            // $this->client->publish('test', json_encode($kontak));
            $js = $this->nats_stream;
            $js->jetstream('KONTAK', 'test', json_encode($kontak));
            $this->response([
                'status' => true,
                'data' => $kontak
            ], RESTController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], RESTController::HTTP_NOT_FOUND);
        }

        // $kontak = $this->kontak_model->read($id);

        // $this->response($kontak, 200);
        // Contoh memanggil ping untuk memeriksa koneksi
        // $result = $this->client->publish('test', 'hallo '. uniqid());
        // $this->response([
        //     'status' => true,
        //     'message' => 'Ping result: ' . ($result ? 'Success' : 'Failed')
        // ], 200);
    }

    public function index_delete($id)
    {

        $this->kontak->delete($id);
        $this->response([
            'status' => true,
            'id' => $id,
            'message' => 'deleted'
        ], RESTController::HTTP_OK);
    }

    public function index_post()
    {
        $data = [
            'nama' => $this->post('nama'),
            'nomor' => $this->post('nomor')
        ];

        $this->kontak->insert($data);
            $this->response([
                'status' => true,
                'message' => 'new kontak has been created'
            ], RESTController::HTTP_CREATED);

    
    }

    public function index_put($id)
    {
        // $id = $this->put('id');
        $data = [
            'nama' => $this->put('nama'),
            'nomor' => $this->put('nomor')
        ];

        $this->kontak->update($id, $data);
            $this->response([
                'status' => true,
                'message' => 'data kontak has been updated'
            ], RESTController::HTTP_OK);
        

    }
}    
