<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class App extends CI_Controller {

	public $image = '';
	
	public function index()
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function jadikan_cover($id_mobil,$id_gambar)
    {

        $this->db->where('id_mobil', $id_mobil);
        $this->db->update('gambar_mobil', array('cover'=>'0'));

        $this->db->where('id_gambar', $id_gambar);
        $update = $this->db->update('gambar_mobil', array('cover'=>'1'));
        if ($update) {
            $this->session->set_flashdata('message', alert_biasa('Cover gambar diset !','success'));
            redirect('mobil/update/'.$id_mobil,'refresh');
        }

    }

    public function pengembangan()
    {
        $this->session->set_flashdata('message', alert_biasa('Sedang dalam pengembangan','info'));
        redirect("app");
    }
   

   
	

	

	
}
