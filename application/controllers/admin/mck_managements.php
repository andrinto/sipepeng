<?php
	
	if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
	class Mck_managements extends CI_Controller {
		var $gallery_path;
		var $gallery_path_url;
		
		function __construct() {
			parent::__construct();
			$this->load->model('mck_model');
			$this->load->model('menu_model');
			$this->load->helper(array('form', 'url'));
			
			# menampilkan google map
			$this->load->library('googlemaps');
		}
		
		public function index() {
			//check sudah login atau belum
			if($this->session->userdata('is_login')){
				//menampilkan menu
				$data['menu_list'] = $this->menu_model->select_all()->result();
				$data['title'] = "MCK | SIPEPENG";
				$data['username'] = $this->session->userdata('username');	
				
				//mengambil uri status
				$status=$this->uri->segment(4);
				
				//status 1 = data awal
				if($status=='1'){       	
					$data['mck_list'] = $this->mck_model->select_all_data_awal()->result();
				}
				
				//status 2 = data verifikasi
				if($status=='2'){       	
					$data['mck_list'] = $this->mck_model->select_all_verifikasi()->result();
				}
				
				//status 3 = data progress
				if($status=='3'){       	
					$data['mck_list'] = $this->mck_model->select_all_sedang_dilaksanakan()->result();
				}
				
				//status 4 = data sudah dilaksanakan
				if($status=='4'){       	
					$data['mck_list'] = $this->mck_model->select_all_sudah_dilaksanakan()->result();
				}
				
				//status 5 = data sudah dilaksanakan
				if($status=='5'){       	
					$data['mck_list'] = $this->mck_model->select_all_tidak_dilaksanakan()->result();
				}		
				
				$data['status']= $status;
				$this->load->view('admin/mck/mck_list',$data);
				
				}else {
				redirect('public/homes');
			}
		}
		
		public function gotoForm() {
			//check sudah login atau belum
			if($this->session->userdata('is_login')){
				//menampilkan menu..wajib ada
				$data['menu_list'] = $this->menu_model->select_all()->result();
				// end menampilkan menu..wajib ada
				$data['title'] = "Data Awal MCK | SIPEPENG";
				$data['judulForm'] = "Data Awal MCK";
				$data['username'] = $this->session->userdata('username');
				
				//mengambil uri aksi
				$data['aksi']=$this->uri->segment(4);
				
				#google map yg bisa di klik otomatis dapetin koordinatnya
				$config['center'] = '-6.900282, 107.530010';
				$config['zoom'] = 'auto';
				$config['onclick'] = 'alert(\'You just clicked at: \' + event.latLng.lat() + \', \' + event.latLng.lng());';
				$this->googlemaps->initialize($config);
				$data['map'] = $this->googlemaps->create_map();
				#end google map
				
				if($data['aksi']=='edit'){
				//mengambil uri aksi
				$id_mck =$this->uri->segment(5);
				$data['mck_list'] = $this->mck_model->getMckById($id_mck);
				}
				
				$this->load->view('admin/mck/mck_olahdata', $data);
			}else {
				redirect('public/homes');
			}
		}
		
		public function process() {
			//menampilkan menu..wajib ada
			$data['menu_list'] = $this->menu_model->select_all()->result();
			// end menampilkan menu..wajib ada
			
			$aksi = $this->input->post('aksi');		
			$data['aksi']=$aksi;
			$id_mck = $this->input->post('id_mck');
			
			$this->form_validation->set_rules('rt', 'RT', 'trim|required|number');
			$this->form_validation->set_rules('rw', 'RW', 'trim|required|number');
			$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('ketersediaan_lahan', 'Ketersediaan Lahan', 'trim|required');
			
			
			//$this->form_validation->set_error_delimiters('', '<br/>');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
			
			if ($this->form_validation->run() == TRUE) {						
				$data['rt'] = $this->input->post('rt');
				$data['rw'] = $this->input->post('rw');
				$data['alamat'] = $this->input->post('alamat');
				$data['ketersediaan_lahan'] = $this->input->post('ketersediaan_lahan');
				$data['anggaran'] = $this->input->post('anggaran');
				$data['sumber_data'] = $this->input->post('sumber_data');
				$data['tahun_usulan'] = $this->input->post('tahun_usulan');
				$data['persetujuan_warga'] = $this->input->post('persetujuan_warga');
				$data['lat'] = $this->input->post('lat');
				$data['long'] = $this->input->post('long');
				$data['ket'] = $this->input->post('ket');
				$ket = "mck";
				
				//mengecek apakah foto di upload
				if($_FILES['foto']['name'] != "")
				{
					$foto = $this->upload_foto($ket,$data['tahun_usulan'],$data['rw'],$data['alamat']);
				}
				 $data['foto'] = $foto;
				 
				 //mengecek apakah dokumen di upload
				if($_FILES['dokumen']['name'] != "")
				{
					$dokumen = $this->upload_dokumen($ket,$data['tahun_usulan'],$data['rw'],$data['alamat']);
				}
					$data['dokumen'] = $dokumen;
				
				//mengecek aksi
				# jika tambah
				if($aksi=='add'){
					//proses menginput ke model
					$hasil = $this->mck_model->add($data);
					$this->session->set_flashdata('message', '<div class="alert alert-success"> Berhasil ditambah </div>');
				}
				# jika edit
				if($aksi=='edit'){
					
					//proses menginput ke model
					$hasil = $this->mck_model->update($id_mck);					
					 if ($hasil == TRUE) {
						$this->session->set_flashdata('message', '<div class="alert alert-success"> Berhasil diubah </div>');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-error"> Gagal ditambahkan </div>');
					}
				}
				
				$data['username'] = $this->session->userdata('username');
				redirect('admin/mck_managements/index/1',$data);
				
			} else {
				$data['title'] = "Data Awal MCK | SIPEPENG";
				$data['judulForm'] = "Data Awal MCK";
				$data['username'] = $this->session->userdata('username');
				$data['mck_list'] = $this->mck_model->getMckById($id_mck);
				$this->load->view('admin/mck/mck_olahdata', $data);
			}
			
		}
		
		
		function delete($id_mck) {
			$id_mck=$this->uri->segment(4);
			$status=$this->uri->segment(5);
			if (empty($id_mck)) {
				$this->session->set_flashdata('message', 'Error Invalid');
				redirect('admin/mck_managements/index/'.$status);
				} else {
				$this->mck_model->delete($id_mck);
				$this->session->set_flashdata('message', '<div class="alert alert-success"> Berhasil Dihapus </div>');
				redirect('admin/mck_managements/index/'.$status);
			}
		}
		
		//fungsi menampilkan berdasarkan id yg dipilih
		public function view($id_mck){
			//menampilkan menu..wajib ada
			$data['menu_list'] = $this->menu_model->select_all()->result();
			// end menampilkan menu..wajib ada
			$data['id_mck'] = $id_mck;
			$data['title'] = "View Data MCK | SIPEPENG";
			$data['judulForm'] = "Detail MCK";
			$data['mck_list'] = $this->mck_model->getMckById($id_mck);
			$data['username'] = $this->session->userdata('username');
			
			$config['center'] = '-6.900282, 107.530010';
			$config['zoom'] = 'auto';
			$this->googlemaps->initialize($config);

			$polyline = array();
			$polyline['points'] = array('-6.905027, 107.525885',
							'-6.904228, 107.528964');
			$this->googlemaps->add_polyline($polyline);
			$data['map'] = $this->googlemaps->create_map();
			# end google map
			
			$this->load->view('admin/mck/mck_view',$data);
		}
		
		function update_status_data_awal(){
			$id_mck=$this->uri->segment(4);
			$hasil = $this->mck_model->update_status_data_awal($id_mck);
			redirect('admin/mck_managements/index/1');
		}
		
		function update_status_verifikasi(){
			$id_mck=$this->uri->segment(4);
			$hasil = $this->mck_model->update_status_verifikasi($id_mck);
			redirect('admin/mck_managements/index/2');
		}
		function update_status_sedang_dilaksanakan(){
			$id_mck=$this->uri->segment(4);
			$hasil = $this->mck_model->update_status_sedang_dilaksanakan($id_mck);
			redirect('admin/mck_managements/index/3');
		}
		function update_status_sudah_dilaksanakan(){
			$id_mck=$this->uri->segment(4);
			$hasil = $this->mck_model->update_status_data_awal($id_mck);
			redirect('admin/mck_managements/index/4');
		}
		function update_status_tidak_dilaksanakan(){
			$id_mck=$this->uri->segment(4);
			$hasil = $this->mck_model->update_status_data_awal($id_mck);
			redirect('admin/mck_managements/index/5');		
		}
		
		
		
		
		# Upload Foto
		function upload_foto($ket,$tahun_usulan,$rw,$alamat)
		{
			$this->load->library('upload');
			
			$image_foto = "noimage.jpg";
			$field_name = "foto";
			$file_name = $_FILES['foto']['name'];
			
			if($file_name != "")
			{
				$config = array(
					'file_name'		=> preg_replace("/[^A-Za-z0-9_-\s]/", "", $ket."_".$tahun_usulan."_".$rw."_".$alamat),
					'overwrite'		=> TRUE,
					'remove_spaces'	=> TRUE,
					'allowed_types' => 'jpg|JPG|jpeg|JPEG|gif|png',
					'upload_path'	=> './assets/upload/foto',
					'max_size' 		=> 5000
				);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload($field_name))
				{
					$image_data = $this->upload->data();
					$image_foto = $image_data['file_name'];
				}
			}
			
			return $image_foto;
		}
		
		# Upload Dokumen
		function upload_dokumen($ket,$tahun_usulan,$rw,$alamat)
		{
			$this->load->library('upload');
			
			$image_dokumen = "no_image.jpg";
			$field_name = "dokumen";
			$file_name = $_FILES['dokumen']['name'];
			
			if($file_name != "")
			{
				$config = array(
					'file_name'		=> preg_replace("/[^A-Za-z0-9_-\s]/", "", $ket."_".$tahun_usulan."_".$rw."_".$alamat),
					'overwrite'		=> TRUE,
					'remove_spaces'	=> TRUE,
					'allowed_types' => 'jpg|JPG|jpeg|JPEG|gif|png',
					'upload_path'	=> './assets/upload/dokumen',
					'max_size' 		=> 5000
				);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload($field_name))
				{
					$image_data = $this->upload->data();
					$image_dokumen = $image_data['file_name'];
				}
			}
			
			return $image_dokumen;
		}
	}
	
?>