<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'transaksi/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'transaksi/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'transaksi/index.html';
            $config['first_url'] = base_url() . 'transaksi/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Transaksi_model->total_rows($q);
        $transaksi = $this->Transaksi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'transaksi_data' => $transaksi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Table Reservation',
            'konten' => 'transaksi/transaksi_list',
        );
        $this->load->view('v_index', $data);
    }

    public function simpan_pembayaran($id_transaksi)
    {
        $this->db->where('id_transaksi', $id_transaksi);
        $this->db->update('transaksi', [
            'total'=>$this->input->post('total'),
            'disc'=>$this->input->post('diskon'),
            'semua_total'=> $this->input->post('total') - ($this->input->post('total') * ( $this->input->post('diskon') / 100 )),
            'updated_at' => get_waktu()
        ]);
        ?>
        <script type="text/javascript">
            alert("berhasil disimpan");
            window.location="<?php echo base_url() ?>transaksi"
        </script>
        <?php
    }

    public function read($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_transaksi' => $row->id_transaksi,
		'no_transaksi' => $row->no_transaksi,
		'id_member' => $row->id_member,
		'nama' => $row->nama,
		'id_meja' => $row->id_meja,
		'durasi' => $row->durasi,
		'total' => $row->total,
		'disc' => $row->disc,
		'semua_total' => $row->semua_total,
		'created_at' => $row->created_at,
		'updated_at' => $row->updated_at,
		'id_user' => $row->id_user,
	    );
            $this->load->view('transaksi/transaksi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'transaksi/transaksi_form',
            'konten' => 'transaksi/transaksi_form',
            'button' => 'Create',
            'action' => site_url('transaksi/create_action'),
	    'id_transaksi' => set_value('id_transaksi'),
	    'no_transaksi' => 'TR'.time(),
	    'id_member' => set_value('id_member'),
	    'nama' => set_value('nama'),
	    'id_meja' => set_value('id_meja'),
	    'durasi' => set_value('durasi'),
	    'total' => set_value('total'),
	    'disc' => set_value('disc'),
	    'semua_total' => set_value('semua_total'),
	    'created_at' => set_value('created_at'),
	    'updated_at' => set_value('updated_at'),
	    'id_user' => set_value('id_user'),
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
		'no_transaksi' => $this->input->post('no_transaksi',TRUE),
		'id_member' => $this->input->post('id_member',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'id_meja' => $this->input->post('id_meja',TRUE),
		'durasi' => $this->input->post('durasi',TRUE),
		'total' => $this->input->post('total',TRUE),
		'disc' => $this->input->post('disc',TRUE),
		'semua_total' => $this->input->post('semua_total',TRUE),
		'created_at' => get_waktu(),
		'id_user' => $this->session->userdata('id_user'),
	    );

            $this->Transaksi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('transaksi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'transaksi/transaksi_form',
                'konten' => 'transaksi/transaksi_form',
                'button' => 'Update',
                'action' => site_url('transaksi/update_action'),
		'id_transaksi' => set_value('id_transaksi', $row->id_transaksi),
		'no_transaksi' => set_value('no_transaksi', $row->no_transaksi),
		'id_member' => set_value('id_member', $row->id_member),
		'nama' => set_value('nama', $row->nama),
		'id_meja' => set_value('id_meja', $row->id_meja),
		'durasi' => set_value('durasi', $row->durasi),
		'total' => set_value('total', $row->total),
		'disc' => set_value('disc', $row->disc),
		'semua_total' => set_value('semua_total', $row->semua_total),
		'created_at' => set_value('created_at', $row->created_at),
		'updated_at' => set_value('updated_at', $row->updated_at),
		'id_user' => set_value('id_user', $row->id_user),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_transaksi', TRUE));
        } else {
            $data = array(
		'no_transaksi' => $this->input->post('no_transaksi',TRUE),
		'id_member' => $this->input->post('id_member',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'id_meja' => $this->input->post('id_meja',TRUE),
		'durasi' => $this->input->post('durasi',TRUE),
		'total' => $this->input->post('total',TRUE),
		'disc' => $this->input->post('disc',TRUE),
		'semua_total' => $this->input->post('semua_total',TRUE),
		'created_at' => $this->input->post('created_at',TRUE),
		'updated_at' => get_waktu(),
        'id_user' => $this->session->userdata('id_user'),
	    );

            $this->Transaksi_model->update($this->input->post('id_transaksi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('transaksi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Transaksi_model->get_by_id($id);

        if ($row) {
            $this->Transaksi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('transaksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_transaksi', 'no transaksi', 'trim|required');
	$this->form_validation->set_rules('id_member', 'id member', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('id_meja', 'id meja', 'trim|required');
	$this->form_validation->set_rules('durasi', 'durasi', 'trim|required');
	
	

	$this->form_validation->set_rules('id_transaksi', 'id_transaksi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-10-12 11:33:01 */
/* https://jualkoding.com */