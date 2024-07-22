<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

use App\Models\UserModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class ApiController extends ResourceController
{
    protected $apiKey = "asd";
    protected $user;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        $this->user = new UserModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    public function index()
    {
        //
    }

    public function show($id = null)
    {
        //
    }

    public function new()
    {
        //
    }

    public function create()
    {
        //
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
        //
    }

    public function delete($id = null)
    {
        //
    }

    public function monthly()
    {
        $data = [
            'query' => [],
            'results' => [],
            'status' => ["code" => 401, "description" => "Unauthorized"]
        ];

        $headers = $this->request->headers();
        $postData = $this->request->getPost();

        $data['query'] = $postData;

        array_walk($headers, function (&$value, $key) {
            $value = $value->getValue();
        });

        if ($headers["Key"] == $this->apiKey) {
            if ($postData['type'] == 'transaction') {
                $result = $this->transaction->select('COUNT(*) as jml')->like('created_at', '' . $postData['tahun'] . '-' . $postData['bulan'] . '', 'after')->first();
                $data['results'] = $result;
                $data['status'] = ["code" => 200, "description" => "OK"];
            } elseif ($postData['type'] == 'earning') {
                $result = $this->transaction->select('sum(total_harga) as jml')->like('created_at', '' . $postData['tahun'] . '-' . $postData['bulan'] . '', 'after')->first();
                $data['results'] = $result;
                $data['status'] = ["code" => 200, "description" => "OK"];
            } elseif ($postData['type'] == 'user') {
                $result = $this->user->select('COUNT(*) as jml')->like('created_at', '' . $postData['tahun'] . '-' . $postData['bulan'] . '', 'after')->first();
                $data['results'] = $result;
                $data['status'] = ["code" => 200, "description" => "OK"];
            }
        }

        return $this->respond($data);
    }

    public function yearly()
    {
        $data = [
            'query' => [],
            'results' => [],
            'status' => ["code" => 401, "description" => "Unauthorized"]
        ];

        $headers = $this->request->headers();
        $postData = $this->request->getPost();

        $data['query'] = $postData;

        array_walk($headers, function (&$value, $key) {
            $value = $value->getValue();
        });

        if ($headers["Key"] == $this->apiKey) {
            if ($postData['type'] == 'transaction') {
                $result = $this->transaction->select('COUNT(*) as jml')->like('created_at', $postData['tahun'], 'after')->first();
                $data['results'] = $result;
                $data['status'] = ["code" => 200, "description" => "OK"];
            } elseif ($postData['type'] == 'earning') {
                $result = $this->transaction->select('sum(total_harga) as jml')->like('created_at', $postData['tahun'], 'after')->first();
                $data['results'] = $result;
                $data['status'] = ["code" => 200, "description" => "OK"];
            } elseif ($postData['type'] == 'user') {
                $result = $this->user->select('COUNT(*) as jml')->like('created_at', $postData['tahun'], 'after')->first();
                $data['results'] = $result;
                $data['status'] = ["code" => 200, "description" => "OK"];
            }
        }

        return $this->respond($data);
    }
}
