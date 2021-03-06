<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Meja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Meja_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'meja/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'meja/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'meja/index.html';
            $config['first_url'] = base_url() . 'meja/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Meja_model->total_rows($q);
        $meja = $this->Meja_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'meja_data' => $meja,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'meja/meja_list',
            'konten' => 'meja/meja_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Meja_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_meja' => $row->id_meja,
		'kode' => $row->kode,
		'nama_meja' => $row->nama_meja,
	    );
            $this->load->view('meja/meja_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('meja'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'meja/meja_form',
            'konten' => 'meja/meja_form',
            'button' => 'Create',
            'action' => site_url('meja/create_action'),
	    'id_meja' => set_value('id_meja'),
	    'kode' => set_value('kode'),
	    'nama_meja' => set_value('nama_meja'),
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
		'kode' => $this->input->post('kode',TRUE),
		'nama_meja' => $this->input->post('nama_meja',TRUE),
	    );

            $this->Meja_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('meja'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Meja_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'meja/meja_form',
                'konten' => 'meja/meja_form',
                'button' => 'Update',
                'action' => site_url('meja/update_action'),
		'id_meja' => set_value('id_meja', $row->id_meja),
		'kode' => set_value('kode', $row->kode),
		'nama_meja' => set_value('nama_meja', $row->nama_meja),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('meja'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_meja', TRUE));
        } else {
            $data = array(
		'kode' => $this->input->post('kode',TRUE),
		'nama_meja' => $this->input->post('nama_meja',TRUE),
	    );

            $this->Meja_model->update($this->input->post('id_meja', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('meja'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Meja_model->get_by_id($id);

        if ($row) {
            $this->Meja_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('meja'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('meja'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode', 'kode', 'trim|required');
	$this->form_validation->set_rules('nama_meja', 'nama meja', 'trim|required');

	$this->form_validation->set_rules('id_meja', 'id_meja', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Meja.php */
/* Location: ./application/controllers/Meja.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-10-05 14:00:10 */
/* https://jualkoding.com */