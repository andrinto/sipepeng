<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lain_managements extends CI_Controller {

    var $gallery_path;
    var $gallery_path_url;

    function __construct() {
        parent::__construct();
        $this->load->model('lain_model');
        $this->load->model('menu_model');
        $this->load->helper(array('form', 'url'));

        # menampilkan google map
        $this->load->library('googlemaps');
    }

    public function index() {
        //check sudah login atau belum
        if ($this->session->userdata('is_login')) {

            $data['title'] = "Kegiatan Lain-Lain | SIPEPENG";
            $data['username'] = $this->session->userdata('username');

            /////////////////////// KOPI DI TIAP FUNGSI /////////////////////////////
            #menampilkan menu
            #menampilkan menu sesuai hak ases				
            $akses = $this->access_lib->hak_akses($this->session->userdata('id_jenis_pengguna'));
            $data['menu_list'] = $akses;
            #end menampilkan menu sesuai hak ases	
            #jumlah status menu
            #drainase
            $data['jumDrainaseVerifikasi'] = $this->home_model->getJumlahDrainaseVerifikasi();
            $data['jumDrainaseBelumDilaksanakan'] = $this->home_model->getJumlahDrainaseBelumDilaksanakan();
            $data['jumDrainaseBelumSelesai'] = $this->home_model->getJumlahDrainaseBelumSelesai();
            $data['jumStatusDrainase'] = $data['jumDrainaseVerifikasi'] + $data['jumDrainaseBelumDilaksanakan'] + $data['jumDrainaseBelumSelesai'];
            /////////////////////// END KOPI DI TIAP FUNGSI /////////////////////////////
            //mengambil uri status
            $status = $this->uri->segment(4);

            //status 1 = data awal
            if ($status == '1') {
                $data['lain_list'] = $this->lain_model->select_all_data_awal()->result();
            }

            //status 2 = data verifikasi
            if ($status == '2') {
                $data['lain_list'] = $this->lain_model->select_all_verifikasi()->result();
            }

            //status 3 = data progress
            if ($status == '3') {
                $data['lain_list'] = $this->lain_model->select_all_sedang_dilaksanakan()->result();
            }

            //status 4 = data sudah dilaksanakan
            if ($status == '4') {
                $data['lain_list'] = $this->lain_model->select_all_sudah_dilaksanakan()->result();
            }

            //status 5 = data tidak dilaksanakan
            if ($status == '5') {
                $data['lain_list'] = $this->lain_model->select_all_tidak_dilaksanakan()->result();
            }

            $data['status'] = $status;
            $this->load->view('admin/lain/lain_list', $data);
        } else {
            redirect('public/homes');
        }
    }

    public function gotoForm() {
        //check sudah login atau belum
        if ($this->session->userdata('is_login')) {

            $data['title'] = "Data Awal Kegiatan Lain-Lain | SIPEPENG";
            $data['judulForm'] = "Data Awal Kegiatan Lain-Lai";
            $data['username'] = $this->session->userdata('username');

            /////////////////////// KOPI DI TIAP FUNGSI /////////////////////////////
            #menampilkan menu
            #menampilkan menu sesuai hak ases				
            $akses = $this->access_lib->hak_akses($this->session->userdata('id_jenis_pengguna'));
            $data['menu_list'] = $akses;
            #end menampilkan menu sesuai hak ases	
            #jumlah status menu
            #drainase
            $data['jumDrainaseVerifikasi'] = $this->home_model->getJumlahDrainaseVerifikasi();
            $data['jumDrainaseBelumDilaksanakan'] = $this->home_model->getJumlahDrainaseBelumDilaksanakan();
            $data['jumDrainaseBelumSelesai'] = $this->home_model->getJumlahDrainaseBelumSelesai();
            $data['jumStatusDrainase'] = $data['jumDrainaseVerifikasi'] + $data['jumDrainaseBelumDilaksanakan'] + $data['jumDrainaseBelumSelesai'];
            /////////////////////// END KOPI DI TIAP FUNGSI /////////////////////////////
            //mengambil uri aksi
            $data['aksi'] = $this->uri->segment(4);

            #google map yg bisa di klik otomatis dapetin koordinatnya
            $config['center'] = '-6.900282, 107.530010';
            $config['zoom'] = 'auto';

            $this->googlemaps->initialize($config);

            #marker A
            $marker = array();
            $marker['position'] = '-6.900282, 107.530010'; //posisi awal
            $marker['draggable'] = true;
            $marker['ondragend'] = 'getLokasi(event.latLng.lat(), event.latLng.lng());'; //buat javascript di viewnya namanya getLokasi
            $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
            $this->googlemaps->add_marker($marker);

            //fungsi untuk membuat peta 
            $data['map'] = $this->googlemaps->create_map();
            #end google map

            if ($data['aksi'] == 'edit') {
                //mengambil uri aksi
                $id_lain = $this->uri->segment(5);
                $data['lain_list'] = $this->lain_model->getlainById($id_lain);
            }

            $this->load->view('admin/lain/lain_olahdata', $data);
        } else {
            redirect('public/homes');
        }
    }

    public function process() {
        ///////////////////// KOPI DI TIAP FUNGSI /////////////////////////////
        // #menampilkan menu
        // #menampilkan menu sesuai hak ases				
        // $akses = $this->access_lib->hak_akses($this->session->userdata('id_jenis_pengguna'));
        // $data['menu_list'] = $akses;
        // #end menampilkan menu sesuai hak ases	
        // #jumlah status menu
        // #drainase
        // $data['jumDrainaseVerifikasi'] = $this->home_model->getJumlahDrainaseVerifikasi();
        // $data['jumDrainaseBelumDilaksanakan'] = $this->home_model->getJumlahDrainaseBelumDilaksanakan();
        // $data['jumDrainaseBelumSelesai'] = $this->home_model->getJumlahDrainaseBelumSelesai();
        // $data['jumStatusDrainase'] = $data['jumDrainaseVerifikasi'] + $data['jumDrainaseBelumDilaksanakan'] + $data['jumDrainaseBelumSelesai'];
        ///////////////////// END KOPI DI TIAP FUNGSI /////////////////////////////

        $aksi = $this->input->post('aksi');
        $data['aksi'] = $aksi;
        $id_lain = $this->input->post('id_lain');

        $this->form_validation->set_rules('rt', 'RT', 'trim|required|number');
        $this->form_validation->set_rules('rw', 'RW', 'trim|required|number');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('ketersediaan_lahan', 'Ketersediaan Lahan', 'trim|required');


        //$this->form_validation->set_error_delimiters('', '<br/>');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

        if ($this->form_validation->run() == TRUE) {
            $data['rt'] = $this->input->post('rt');
            $data['rw'] = $this->input->post('rw');
            $data['nama_kegiatan'] = $this->input->post('nama_kegiatan');
            $data['alamat'] = $this->input->post('alamat');
            $data['ketersediaan_lahan'] = $this->input->post('ketersediaan_lahan');
            $data['anggaran'] = $this->input->post('anggaran');
            $data['sumber_data'] = $this->input->post('sumber_data');
            $data['tahun_usulan'] = $this->input->post('tahun_usulan');
            $data['persetujuan_warga'] = $this->input->post('persetujuan_warga');
            $data['long'] = $this->input->post('long');
            $data['lat'] = $this->input->post('lat');
            $data['ket'] = $this->input->post('ket');
            $ket = "lain";

            //mengecek apakah foto di upload
            if ($_FILES['foto']['name'] != "") {
                $foto = $this->upload_foto($ket, $data['tahun_usulan'], $data['rw'], $data['alamat']);
            }
            $data['foto'] = $foto;

            //mengecek apakah dokumen di upload
            if ($_FILES['dokumen']['name'] != "") {
                $dokumen = $this->upload_dokumen($ket, $data['tahun_usulan'], $data['rw'], $data['alamat']);
            }
            $data['dokumen'] = $dokumen;

            //mengecek aksi
            # jika tambah
            if ($aksi == 'add') {
                //proses menginput ke model
                $hasil = $this->lain_model->add($data);
                $this->session->set_flashdata('message', '<div class="alert alert-success"> Berhasil ditambah </div>');
            }
            # jika edit
            if ($aksi == 'edit') {

                //proses menginput ke model
                $hasil = $this->lain_model->update($data, $id_lain);
                if ($hasil == TRUE) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success"> Berhasil diubah </div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-error"> Gagal ditambahkan </div>');
                }
            }

            $data['username'] = $this->session->userdata('username');
            redirect('admin/lain_managements/index/1', $data);
        } else {
            $data['title'] = "Data Awal Kegiatan Lain-Lain | SIPEPENG";
            $data['judulForm'] = "Data Awal Kegiatan Lain-Lain";
            $data['username'] = $this->session->userdata('username');
            $data['lain_list'] = $this->lain_model->getlainById($id_lain);
            $this->load->view('admin/lain/lain_olahdata', $data);
        }
    }

    function delete($id_lain) {
        $id_lain = $this->uri->segment(4);
        $status = $this->uri->segment(5);
        if (empty($id_lain)) {
            $this->session->set_flashdata('message', 'Error Invalid');
            redirect('admin/lain_managements/index/' . $status);
        } else {
            $this->lain_model->delete($id_lain);
            $this->session->set_flashdata('message', '<div class="alert alert-success"> Berhasil Dihapus </div>');
            redirect('admin/lain_managements/index/' . $status);
        }
    }

    //fungsi menampilkan berdasarkan id yg dipilih
    public function view($id_lain) {

        $data['id_lain'] = $id_lain;
        $data['title'] = "View Data Kegiatan Lain-Lain | SIPEPENG";
        $data['judulForm'] = "Detail Kegiatan Lain-Lain";
        $data['lain_list'] = $this->lain_model->getlainById($id_lain);
        $data['username'] = $this->session->userdata('username');

        /////////////////////// KOPI DI TIAP FUNGSI /////////////////////////////
        #menampilkan menu
        #menampilkan menu sesuai hak ases				
        $akses = $this->access_lib->hak_akses($this->session->userdata('id_jenis_pengguna'));
        $data['menu_list'] = $akses;
        #end menampilkan menu sesuai hak ases	
        #jumlah status menu
        #drainase
        $data['jumDrainaseVerifikasi'] = $this->home_model->getJumlahDrainaseVerifikasi();
        $data['jumDrainaseBelumDilaksanakan'] = $this->home_model->getJumlahDrainaseBelumDilaksanakan();
        $data['jumDrainaseBelumSelesai'] = $this->home_model->getJumlahDrainaseBelumSelesai();
        $data['jumStatusDrainase'] = $data['jumDrainaseVerifikasi'] + $data['jumDrainaseBelumDilaksanakan'] + $data['jumDrainaseBelumSelesai'];
        /////////////////////// END KOPI DI TIAP FUNGSI /////////////////////////////
        # menampilkan google map ke dalam view berdasarkan koordinat didalam database
        $config['center'] = '-6.900282, 107.530010';
        $config['zoom'] = '16';
        $this->googlemaps->initialize($config);

        #garis di google map
        $polyline = array();
        $polyline['points'] = array($data['lain_list']['lat'] . "," . $data['lain_list']['long']);
        $this->googlemaps->add_polyline($polyline);

        #marker / tanda di google map
        $marker = array();
        $marker['position'] = $data['lain_list']['lat'] . "," . $data['lain_list']['long'];
        $marker['infowindow_content'] = "RW : " . $data['lain_list']['rw'] . " <br /> Alamat:  " . $data['lain_list']['alamat'];
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
        $this->googlemaps->add_marker($marker);

        #buat peta google map
        $data['map'] = $this->googlemaps->create_map();
        # end menampilkan google map ke dalam view berdasarkan koordinat didalam database


        $this->load->view('admin/lain/lain_view', $data);
    }

    function update_status_data_awal() {
        $id_lain = $this->uri->segment(4);
        $hasil = $this->lain_model->update_status_data_awal($id_lain);
        //message berhasil loncat
        $this->session->set_flashdata('message', '<div class="alert alert-success"> Data berhasil diverifikasi. <br /> Klik menu Data Verifikasi </div>');

        redirect('admin/lain_managements/index/1');
    }

    function update_status_verifikasi() {
        $id_lain = $this->uri->segment(4);
        $hasil = $this->lain_model->update_status_verifikasi($id_lain);
        //message berhasil loncat
        $this->session->set_flashdata('message', '<div class="alert alert-success"> Data berhasil diproses. <br /> Klik menu Data Sedang dilaksanakan </div>');

        redirect('admin/lain_managements/index/2');
    }

    function update_status_sedang_dilaksanakan() {
        $id_lain = $this->uri->segment(4);
        $hasil = $this->lain_model->update_status_sedang_dilaksanakan($id_lain);
        //message berhasil loncat
        $this->session->set_flashdata('message', '<div class="alert alert-success"> Data berhasil dilaksanakan. <br /> Klik menu Data Sudah Dilaksanakan </div>');

        redirect('admin/lain_managements/index/3');
    }

    function update_status_sudah_dilaksanakan() {
        $id_lain = $this->uri->segment(4);
        $hasil = $this->lain_model->update_status_data_awal($id_lain);
        redirect('admin/lain_managements/index/4');
    }

    function update_status_tidak_dilaksanakan() {
        $id_lain = $this->input->post('id');
        $hasil = $this->lain_model->update_status_tidak_dilaksanakan($id_lain);
        //message berhasil loncat
        $this->session->set_flashdata('message', '<div class="alert alert-success"> Data permintaan ditolak. <br /> Klik menu Data Tidak Dilaksanakan </div>');

        redirect('admin/lain_managements/index/2');
    }

    # Upload Foto

    function upload_foto($ket, $tahun_usulan, $rw, $alamat) {
        $this->load->library('upload');

        $image_foto = "noimage.jpg";
        $field_name = "foto";
        $file_name = $_FILES['foto']['name'];

        if ($file_name != "") {
            $config = array(
                'file_name' => preg_replace("/[^A-Za-z0-9_-\s]/", "", $ket . "_" . $tahun_usulan . "_" . $rw . "_" . $alamat),
                'overwrite' => TRUE,
                'remove_spaces' => TRUE,
                'allowed_types' => 'jpg|JPG|jpeg|JPEG|gif|png',
                'upload_path' => './assets/upload/foto',
                'max_size' => 5000
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload($field_name)) {
                $image_data = $this->upload->data();
                $image_foto = $image_data['file_name'];
            }
        }

        return $image_foto;
    }

    # Upload Dokumen

    function upload_dokumen($ket, $tahun_usulan, $rw, $alamat) {
        $this->load->library('upload');

        $image_dokumen = "no_image.jpg";
        $field_name = "dokumen";
        $file_name = $_FILES['dokumen']['name'];

        if ($file_name != "") {
            $config = array(
                'file_name' => preg_replace("/[^A-Za-z0-9_-\s]/", "", $ket . "_" . $tahun_usulan . "_" . $rw . "_" . $alamat),
                'overwrite' => TRUE,
                'remove_spaces' => TRUE,
                'allowed_types' => 'jpg|JPG|jpeg|JPEG|gif|png',
                'upload_path' => './assets/upload/dokumen',
                'max_size' => 5000
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload($field_name)) {
                $image_data = $this->upload->data();
                $image_dokumen = $image_data['file_name'];
            }
        }

        return $image_dokumen;
    }

}

?>