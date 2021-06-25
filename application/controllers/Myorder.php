<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Myorder extends MY_Controller
{
    private $id;

    public function __construct()
    {
        parent::__construct();

        $is_login = $this->session->userdata('is_login');
        $this->id = $this->session->userdata('id');

        if (!$is_login) {   // Jika ternyata belum ada session
            redirect(base_url());
            return;
        }
    }

    public function index()
    {
        $data['title']      = 'Daftar Order';
        $data['content']    = $this->myorder->where('id_user', $this->id)   // Ambil list orders dari user ini
            ->orderBy('date', 'DESC')                   // Urutkan dari data terbaru
            ->get();
        $data['page']       = 'pages/myorder/index';

        $this->view($data);
    }

    /**
     * Untuk melihat detail dari suatu order
     */
    public function detail($invoice)
    {
        $data['order']  = $this->myorder->where('invoice', $invoice)->first();

        if (!$data['order']) {
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('myorder'));
        }

        $this->myorder->table   = 'order_detail';
        $data['order_detail']   = $this->myorder->select([
            'order_detail.id_orders', 'order_detail.id_product', 'order_detail.qty', 'order_detail.subtotal', 'product.title', 'product.image', 'product.price'
        ])
            ->join('product')
            ->where('order_detail.id_orders', $data['order']->id)
            ->get();

        if ($data['order']->status !== 'waiting') {
            $this->myorder->table   = 'orders_confirm';
            $data['order_confirm']  = $this->myorder->where('id_orders', $data['order']->id)->first();
        }

        $data['page']   = 'pages/myorder/detail';

        $this->view($data);
    }

    /**
     * Untuk melakukan konfirmasi pembayaran
     */
    public function confirm($invoice)
    {
        $data['order']  = $this->myorder->where('invoice', $invoice)->first();

        if (!$data['order']) {
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('myorder'));
        }

        if ($data['order']->status !== 'waiting') {
            $this->session->set_flashdata('warning', 'Bukti transfer sudah dikirim');
            redirect(base_url("myorder/detail/$invoice"));
        }

        if (!$_POST) {
            $data['input'] = (object) $this->myorder->getDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if (!empty($_FILES) && $_FILES['image']['name'] !== '') {   // Jika upload'an tidak kosong
            $imageName  = url_title($invoice, '-', true) . '-' . date('YmdHis');    // Membuat slug
            $upload     = $this->myorder->uploadImage('image', $imageName);         // Mulai upload
            if ($upload) {

                $data['input']->image = $upload['file_name'];
            } else {
                redirect(base_url("myorder/confirm/$invoice"));
            }
        }

        if (!$this->myorder->validate()) {
            $data['title']          = 'Konfirmasi Order';
            $data['form_action']    = base_url("myorder/confirm/$invoice");
            $data['page']           = 'pages/myorder/confirm';

            $this->view($data);
            return;
        }

        $this->myorder->table = 'orders_confirm';
        if ($this->myorder->create($data['input'])) {
            $this->myorder->table = 'orders';
            $this->myorder->where('id', $data['input']->id_orders)->update(['status' => 'paid']);

            $this->session->set_flashdata('success', 'Data berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Maaf, Terjadi suatu kesalahan');
        }

        redirect(base_url("myorder/detail/$invoice"));
    }

    public function image_required()
    {
        if (empty($_FILES) || $_FILES['image']['name'] === '') {
            $this->session->set_flashdata('image_error', 'Bukti transfer tidak boleh kosong');
            return false;   // Return false agar tidak melanjutkan proses
        }

        return true;
    }
}

/* End of file Myorder.php */
