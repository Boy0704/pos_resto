<?php 

function kirim_sms($no_telp,$pesan)
{
	$curl = curl_init();
	$token = "O6yWfWUn1qnG71kkKP4eaph3Y88dKQUq31vQY4twImldMirdPYeR7uP4o7ADVoKq";
	$data = [
	    'phone' => $no_telp,
	    'message' => $pesan,
	];

	curl_setopt($curl, CURLOPT_HTTPHEADER,
	    array(
	        "Authorization: $token",
	    )
	);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($curl, CURLOPT_URL, "https://teras.wablas.com/api/sms/send");
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$result = curl_exec($curl);
	curl_close($curl);

	// echo "<pre>";
	return $result;
}

function kirim_wa($no_telp, $pesan)
{
	$curl = curl_init();
	$token = "O6yWfWUn1qnG71kkKP4eaph3Y88dKQUq31vQY4twImldMirdPYeR7uP4o7ADVoKq";
	$data = [
	    'phone' => $no_telp,
	    'message' => $pesan,
	];

	curl_setopt($curl, CURLOPT_HTTPHEADER,
	    array(
	        "Authorization: $token",
	    )
	);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($curl, CURLOPT_URL, "https://teras.wablas.com/api/send-message");
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$result = curl_exec($curl);
	curl_close($curl);

	// echo "<pre>";
	return $result;
}


function c_bln($table,$bulan)
{
	$CI =& get_instance();
	$tahun = date('Y');
	$d = $CI->db->query("SELECT * FROM $table WHERE created_at LIKE '$tahun-$bulan%' ")->num_rows();
	return $d;
}

function jam_kantor_keluar()
{
	$CI =& get_instance();

	$hari = date('D');
	$hari_db = get_data('hari','day',$hari,'hari');
	$jam_kantor = $CI->db->get_where('set_jam_kantor', array('hari'=>$hari_db));
	if ($jam_kantor->num_rows() > 0) {
		$d = $jam_kantor->row();
		return $d->jam_keluar;
	} else {
		return 'kosong';
	}
}

function jam_kantor_masuk()
{
	$CI =& get_instance();

	$hari = date('D');
	$hari_db = get_data('hari','day',$hari,'hari');
	$jam_kantor = $CI->db->get_where('set_jam_kantor', array('hari'=>$hari_db));
	if ($jam_kantor->num_rows() > 0) {
		$d = $jam_kantor->row();
		return $d->jam_masuk;
	} else {
		return 'kosong';
	}
}



function get_mac_address()
{
	$_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
	$_PERINTAH = "arp -a $_IP_ADDRESS";
	ob_start();
	system($_PERINTAH);
	$_HASIL = ob_get_contents();
	ob_clean();
	$_PECAH = strstr($_HASIL, $_IP_ADDRESS);
	$_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
	$_HASIL = substr($_PECAH_STRING[1], 0, 17);
	echo "IP Anda : ".$_IP_ADDRESS."
	MAC ADDRESS Anda : ".$_HASIL;
}

function durasi_jam($tgl1,$tgl2)
{
	$tanggal = new DateTime($tgl1); 

	$sekarang = new DateTime($tgl2);

	$perbedaan = $tanggal->diff($sekarang);

	//gabungkan
	// echo $perbedaan->y.' selisih tahun.';
	// echo $perbedaan->m.' selisih bulan.';
	// echo $perbedaan->d.' selisih hari.';
	// echo $perbedaan->h.' selisih jam.';
	// echo $perbedaan->i.' selisih menit.';
	$a = ($perbedaan->d * (3600 * 24)) + ($perbedaan->h * 3600) + ($perbedaan->i * 60);
	return $a / 60;
}

function durasi_tgl($tgl1,$tgl2)
{
	$datetime1 = date_create($tgl1);
  	$datetime2 = date_create($tgl2);
  	$difference = date_diff($datetime1, $datetime2);
  	$jam = $difference->h;
  	$menit = ($jam * 60) + $difference->i;
  	return $menit;
}

function hari_id($tanggal)
{
  $day = date('D', strtotime($tanggal));
  $dayList = array( 'Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>"Jum'at", 'Sat'=>'Sabtu');
  return $dayList[$day];
}

function stok_display($id_subkategori)
{
	$CI =& get_instance();
	$sql = "
	SELECT
		((COALESCE(SUM(in_qty),0) - COALESCE(SUM(out_qty),0)) ) AS stok_akhir 
	FROM
		stok_transfer
	WHERE
		id_subkategori='$id_subkategori'
		and milik='display';
	";
	$stok = $CI->db->query($sql)->row()->stok_akhir;
	return $stok;
}

function stok_gudang($id_subkategori)
{
	$CI =& get_instance();
	$sql = "
	SELECT
		((COALESCE(SUM(in_qty),0) - COALESCE(SUM(out_qty),0)) ) AS stok_akhir 
	FROM
		stok_transfer
	WHERE
		id_subkategori='$id_subkategori'
		and milik='gudang';
	";
	$stok = $CI->db->query($sql)->row()->stok_akhir;
	return $stok;
}

function cek_ppn($no_po)
{
	$cek = get_data('po_master','no_po',$no_po,'ppn');
	if ($cek == NULL) {
		$cek = 0;
	}
	return $cek;
}

function cek_return($n,$no)
{
	if ($n == '0') {
		return '<a href="app/ubah_return/'.$no.'" onclick="javasciprt: return confirm(\'Are You Sure ?\')"><label class="label label-info"><i class="fa fa-close"></i></label></a>';
	} else {
		return '<label class="label label-success"><i class="fa fa-check"></i></label>';
	}
}

function create_random($length)
{
    $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
    $string = '';
    for($i = 0; $i < $length; $i++) {
        $pos = rand(0, strlen($data)-1);
        $string .= $data{$pos};
    }
    return $string;
}

function upload_gambar_biasa($nama_gambar, $lokasi_gambar, $tipe_gambar, $ukuran_gambar, $name_file_form)
{
    $CI =& get_instance();
    $nmfile = $nama_gambar."_".time();
    $config['upload_path'] = './'.$lokasi_gambar;
    $config['allowed_types'] = $tipe_gambar;
    $config['max_size'] = $ukuran_gambar;
    $config['file_name'] = $nmfile;
    // load library upload
    $CI->load->library('upload', $config);
    // upload gambar 1
    if ( ! $CI->upload->do_upload($name_file_form)) {
    	return $CI->upload->display_errors();
    } else {
	    $result1 = $CI->upload->data();
	    $result = array('gambar'=>$result1);
	    $dfile = $result['gambar']['file_name'];
	    
	    return $dfile;
	}	
}

function get_ph($no_po,$total_h)
{
	$CI =& get_instance();
	// log_r($total_h);
	// if ($total_h = '') {
	// 	$total_h = 0;
	// }
	$ph = $CI->db->get_where('po_master', array('no_po'=>$no_po))->row()->potongan_harga;
	$d_ph = explode(';', $ph);
	$t_h_now = $total_h;
	foreach ($d_ph as $key => $value) {
		if (strstr($value, '%')) {
			$t_persen = str_replace('%', '', $value) /100;
			$n_persen = $t_persen * $t_h_now;
			$t_h_now = $t_h_now - $n_persen;
		} else {
			$t_h_now = $t_h_now - floatval($value);
			// log_r($t_h_now);
		}
	}
	return $t_h_now;

}

function get_diskon_beli($diskon,$total_h)
{
	$CI =& get_instance();
	// log_r($total_h);
	// if ($total_h = '') {
	// 	$total_h = 0;
	// }
	$ph = $diskon;
	$d_ph = explode(';', $ph);
	$t_h_now = $total_h;
	foreach ($d_ph as $key => $value) {
		if (strstr($value, '%')) {
			$t_persen = str_replace('%', '', $value) /100;
			$n_persen = $t_persen * $t_h_now;
			$t_h_now = $t_h_now - $n_persen;
		} else {
			$t_h_now = $t_h_now - floatval($value);
			// log_r($t_h_now);
		}
	}
	return $t_h_now;

}


function get_waktu()
{
	date_default_timezone_set('Asia/Jakarta');
	return date('Y-m-d H:i:s');
}
function select_option($name, $table, $field, $pk, $selected = null,$class = null, $extra = null, $option_tamabahan = null) {
    $ci = & get_instance();
    $cmb = "<select name='$name' class='form-control $class  ' $extra>";
    $cmb .= $option_tamabahan;
    $data = $ci->db->get($table)->result();
    foreach ($data as $row) {
        $cmb .="<option value='" . $row->$pk . "'";
        $cmb .= $selected == $row->$pk ? 'selected' : '';
        $cmb .=">" . strtoupper($row->$field ). "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function get_setting($select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM pengaturan_aplikasi where id_pengaturan='1' ")->row_array();
	return $data[$select];
}

function get_data($tabel,$primary_key,$id,$select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM $tabel where $primary_key='$id' ")->row_array();
	return $data[$select];
}

function get_produk($barcode,$select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM produk where barcode1='$barcode' or barcode2='$barcode' ")->row_array();
	return $data[$select];
}



function alert_biasa($pesan,$type)
{
	return 'swal("'.$pesan.'", "You clicked the button!", "'.$type.'");';
}

function alert_tunggu($pesan,$type)
{
	return '
	swal("Silahkan Tunggu!", {
	  button: false,
	  icon: "info",
	});
	';
}

function selisih_waktu($start_date)
{
	date_default_timezone_set('Asia/Jakarta');
	$waktuawal  = date_create($start_date); //waktu di setting

	$waktuakhir = date_create(date('Y-m-d H:i:s')); //2019-02-21 09:35 waktu sekarang

	//Membandingkan
	$date1 = new DateTime($start_date);
	$date2 = new DateTime(date('Y-m-d H:i:s'));
	if ($date2 < $date1) {
	    $diff  = date_diff($waktuawal, $waktuakhir);
		return $diff->d . ' hari '.$diff->h . ' jam lagi ';
	} else {
		return 'berlangsung';
	}

	

	// echo 'Selisih waktu: ';

	// echo $diff->y . ' tahun, ';

	// echo $diff->m . ' bulan, ';

	// echo $diff->d . ' hari, ';

	// echo $diff->h . ' jam, ';

	// echo $diff->i . ' menit, ';

	// echo $diff->s . ' detik, ';
}



function filter_string($n)
{
	$hasil = str_replace('"', "'", $n);
	return $hasil;
}

function cek_nilai_lulus()
{	
	$CI 	=& get_instance();
	$nilai = $CI->db->query("SELECT sum(nilai_lulus) as lulus FROM mapel ")->row()->lulus;
	return $nilai;
}



function log_r($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        exit;
    }

    function log_data($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        // exit;
    }