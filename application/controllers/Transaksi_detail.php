<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi_detail extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_detail_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'transaksi_detail/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'transaksi_detail/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'transaksi_detail/index.html';
            $config['first_url'] = base_url() . 'transaksi_detail/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Transaksi_detail_model->total_rows($q);
        $transaksi_detail = $this->Transaksi_detail_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'transaksi_detail_data' => $transaksi_detail,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Detail Transaksi',
            'konten' => 'transaksi_detail/transaksi_detail_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Transaksi_detail_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_detail_trx' => $row->id_detail_trx,
		'id_transaksi' => $row->id_transaksi,
		'id_paket' => $row->id_paket,
		'deskripsi' => $row->deskripsi,
		'harga' => $row->harga,
		'qty' => $row->qty,
		'subtotal' => $row->subtotal,
		'created_at' => $row->created_at,
		'updated_at' => $row->updated_at,
	    );
            $this->load->view('transaksi_detail/transaksi_detail_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi_detail'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Detail Transaksi',
            'konten' => 'transaksi_detail/transaksi_detail_form',
            'button' => 'Create',
            'action' => site_url('transaksi_detail/create_action'),
	    'id_detail_trx' => set_value('id_detail_trx'),
	    'id_transaksi' => set_value('id_transaksi'),
	    'id_paket' => set_value('id_paket'),
	    'deskripsi' => set_value('deskripsi'),
	    'harga' => set_value('harga'),
	    'qty' => set_value('qty'),
	    'subtotal' => set_value('subtotal'),
	    'created_at' => set_value('created_at'),
	    'updated_at' => set_value('updated_at'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_transaksi' => $this->input->post('id_transaksi',TRUE),
		'id_paket' => $this->input->post('id_paket',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'qty' => $this->input->post('qty',TRUE),
		'subtotal' => $this->input->post('subtotal',TRUE),
		'created_at' => get_waktu(),
	    );

            $this->Transaksi_detail_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('transaksi_detail'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Transaksi_detail_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Detail Transaksi',
                'konten' => 'transaksi_detail/transaksi_detail_form',
                'button' => 'Update',
                'action' => site_url('transaksi_detail/update_action'),
		'id_detail_trx' => set_value('id_detail_trx', $row->id_detail_trx),
		'id_transaksi' => set_value('id_transaksi', $row->id_transaksi),
		'id_paket' => set_value('id_paket', $row->id_paket),
		'deskripsi' => set_value('deskripsi', $row->deskripsi),
		'harga' => set_value('harga', $row->harga),
		'qty' => set_value('qty', $row->qty),
		'subtotal' => set_value('subtotal', $row->subtotal),
		'created_at' => set_value('created_at', $row->created_at),
		'updated_at' => set_value('updated_at', $row->updated_at),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi_detail'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_detail_trx', TRUE));
        } else {
            $data = array(
		'id_transaksi' => $this->input->post('id_transaksi',TRUE),
		'id_paket' => $this->input->post('id_paket',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'qty' => $this->input->post('qty',TRUE),
		'subtotal' => $this->input->post('subtotal',TRUE),
		'updated_at' => get_waktu(),
	    );

            $this->Transaksi_detail_model->update($this->input->post('id_detail_trx', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('transaksi_detail'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Transaksi_detail_model->get_by_id($id);

        if ($row) {
            $this->Transaksi_detail_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('transaksi_detail'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi_detail'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_transaksi', 'id transaksi', 'trim|required');
	$this->form_validation->set_rules('id_paket', 'id paket', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');
	$this->form_validation->set_rules('qty', 'qty', 'trim|required');
	$this->form_validation->set_rules('subtotal', 'subtotal', 'trim|required');

	$this->form_validation->set_rules('id_detail_trx', 'id_detail_trx', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Transaksi_detail.php */
/* Location: ./application/controllers/Transaksi_detail.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-10-12 12:12:58 */
/* https://jualkoding.com */