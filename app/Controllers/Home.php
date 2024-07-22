<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use Dompdf\Options;
use Dompdf\Dompdf;

class Home extends BaseController
{
    protected $product;
    protected $transaction;
    protected $transaction_detail;
    
    
    function __construct()
    {
        helper('form');
        helper('number');
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }
    public function index(): string
    {
        $product = $this->product->findAll();
        $data['product'] = $product;
        return view('v_home', $data);
    }

    public function transaksi()
    {
        $username = session()->get('username');
        $data['username'] = $username;
    
        $buy = $this->transaction->where('username', $username)->findAll();
        $data['buy'] = $buy;
    
        $product = [];
    
        if (!empty($buy)) {
            foreach ($buy as $item) {
                $detail = $this->transaction_detail->select('transaction_detail.*, product.nama, product.harga, product.foto')->join('product', 'transaction_detail.product_id=product.id')->where('transaction_id', $item['id'])->findAll();
    
                if (!empty($detail)) {
                    $product[$item['id']] = $detail;
                }
            }
        }
        
    
        $data['product'] = $product;
        

        return view('v_transaksi', $data);
    }

    public function updateTransaksi()
    {
        $transaction = new TransactionModel();
        
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        
        $transaction->update($id, ['status' => $status]);
        
        return redirect()->to('/transaksi');
    }

    public function downloadTransaksi()
    {
        $transaction = new TransactionModel();
        $transaction = $transaction->findAll();

        $html = view('transaksi_pdf', ['transaksi' => $transaction]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('transaksi.pdf', ['Attachment' => 1]);
    }


    

    public function faq()
    {
        return view('v_faq');
    }

    public function profile()
{
    $username = session()->get('username');
    $data['username'] = $username;

    $buy = $this->transaction->where('username', $username)->findAll();
    $data['buy'] = $buy;

    $product = [];

    if (!empty($buy)) {
        foreach ($buy as $item) {
            $detail = $this->transaction_detail->select('transaction_detail.*, product.nama, product.harga, product.foto')->join('product', 'transaction_detail.product_id=product.id')->where('transaction_id', $item['id'])->findAll();

            if (!empty($detail)) {
                $product[$item['id']] = $detail;
            }
        }
    }

    $data['product'] = $product;

    return view('v_profile', $data);
}
    public function contact()
    {
        return view('v_contact');
    }
}
