<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket_bermain extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Paket_bermain_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'paket_bermain/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'paket_bermain/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'paket_bermain/index.html';
            $config['first_url'] = base_url() . 'paket_bermain/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Paket_bermain_model->total_rows($q);
        $paket_bermain = $this->Paket_bermain_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'paket_bermain_data' => $paket_bermain,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'paket_bermain/paket_bermain_list',
            'konten' => 'paket_bermain/paket_bermain_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Paket_bermain_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_paket' => $row->id_paket,
		'paket' => $row->paket,
		'jam' => $row->jam,
		'deskripsi' => $row->deskripsi,
	    );
            $this->load->view('paket_bermain/paket_bermain_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_bermain'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'paket_bermain/paket_bermain_form',
            'konten' => 'paket_bermain/paket_bermain_form',
            'button' => 'Create',
            'action' => site_url('paket_bermain/create_action'),
	    'id_paket' => set_value('id_paket'),
	    'paket' => set_value('paket'),
	    'jam' => set_value('jam'),
	    'deskripsi' => set_value('deskripsi'),
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
		'paket' => $this->input->post('paket',TRUE),
		'jam' => $this->input->post('jam',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
	    );

            $this->Paket_bermain_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('paket_bermain'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Paket_bermain_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'paket_bermain/paket_bermain_form',
                'konten' => 'paket_bermain/paket_bermain_form',
                'button' => 'Update',
                'action' => site_url('paket_bermain/update_action'),
		'id_paket' => set_value('id_paket', $row->id_paket),
		'paket' => set_value('paket', $row->paket),
		'jam' => set_value('jam', $row->jam),
		'deskripsi' => set_value('deskripsi', $row->deskripsi),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_bermain'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_paket', TRUE));
        } else {
            $data = array(
		'paket' => $this->input->post('paket',TRUE),
		'jam' => $this->input->post('jam',TRUE),
		'deskripsi' => $this->input->post('deskripsi',TRUE),
	    );

            $this->Paket_bermain_model->update($this->input->post('id_paket', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('paket_bermain'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Paket_bermain_model->get_by_id($id);

        if ($row) {
            $this->Paket_bermain_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('paket_bermain'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_bermain'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('paket', 'paket', 'trim|required');
	$this->form_validation->set_rules('jam', 'jam', 'trim|required');
	$this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');

	$this->form_validation->set_rules('id_paket', 'id_paket', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Paket_bermain.php */
/* Location: ./application/controllers/Paket_bermain.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-10-05 14:00:17 */
/* https://jualkoding.com */