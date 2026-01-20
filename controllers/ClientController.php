<?php

class ClientController extends Controller
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function index()
    {
        $clients = $this->client->all();
        $this->render('clients/index', compact('clients'));
    }

    public function delete(int $id)
    {
        $this->client->delete($id);
        $this->notify('client.deleted', ['id' => $id]);
        $this->redirect('/clients');
    }
}
