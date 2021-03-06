<?php $this->load->view('admin/templates/header'); ?>
 <!--header google map start-->
<?php 
$mapjs = isset($map['js']) ? $map['js'] : '';											
echo $mapjs; 

//cek status tambah atau edit
if(strtolower($aksi) == 'add') {
		$aksi = 'add';
		$namaform="Tambah";
		}
    else if(strtolower($aksi) == 'edit') {
		$aksi = 'edit';
		$namaform="Ubah";
		}
?>
 <!--header  google map end-->
<link href="<?php echo base_url(); ?>assets/admin/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/admin/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/admin/css/table-responsive.css" rel="stylesheet" />
<body>

    <section id="container" >
        <!--header start-->
        <?php $this->load->view('admin/templates/top-nav'); ?>
        <!--header end-->
        <!--sidebar start-->
             <?php $this->load->view('admin/templates/menu_admin'); ?>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue tab-right ">
                                <span class="hidden-sm wht-color"><? echo $namaform." " .$judulForm ?></span>
                            </header>
                            <div class="panel-body">
                                <form method="post" action="<?php echo base_url('admin/lain_managements/process'); ?>" class="form-horizontal" id="validation-events" role="form" enctype="multipart/form-data">
								<input type="hidden" name="aksi" value="<? echo $aksi ?>" />
								<input type="hidden" name="id_lain" value="<?php echo set_value('id_lain', isset($lain_list['id_lain']) ? $lain_list['id_lain'] : ''); ?>" />
                                     <span class="help-inline"><?php echo form_error('id_lain'); ?></span>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="rt">RT: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="rt" name="rt" placeholder="RT" value="<?php echo set_value('rt', isset($lain_list['rt']) ? $lain_list['rt'] : ''); ?>"  data-validation="number">
                                            <span class="help-inline"><?php echo form_error('rt'); ?></span>
                                        </div>
                                    </div><!--end control-group-->
                                    
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="rw">RW: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="rw" name="rw" placeholder="RW" value="<?php echo set_value('rw', isset($lain_list['rw']) ? $lain_list['rw'] : ''); ?>"  data-validation="number">
                                            <span class="help-inline"><?php echo form_error('rw'); ?></span>
                                        </div>
                                    </div><!--end control-group-->
                                     
									<div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="nama_kegiatan">Nama Kegiatan: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" placeholder="Nama Kegiatan" value="<?php echo set_value('nama_kegiatan', isset($lain_list['nama_kegiatan']) ? $lain_list['nama_kegiatan'] : ''); ?>" >
                                            <span class="help-inline"><?php echo form_error('nama_kegiatan'); ?></span>
                                        </div>
                                    </div><!--end control-group-->
                                    
                                  <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="alamat">Alamat: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <textarea class="form-control" id="alamat" name="alamat" data-validation="length" data-validation-length="min10"><?php echo set_value('alamat', isset($lain_list['alamat']) ? $lain_list['alamat'] : ''); ?></textarea>                                           
                                            <span class="help-inline"><?php echo form_error('alamat'); ?></span>
                                        </div>
                                    </div><!--end form-group-->                                     

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="ketersediaan_lahan">Ketersediaan Lahan: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="ketersediaan_lahan" name="ketersediaan_lahan" placeholder="Ketersediaan Lahan" value=" <?php echo set_value('ketersediaan_lahan', isset($lain_list['ketersediaan_lahan']) ? $lain_list['ketersediaan_lahan'] : ''); ?>" data-validation="number" data-validation-allowing="float" data-validation-help="satuan dalam meter,gunakan titik misalnya 0.3">
                                            <span class="help-inline"><?php echo form_error('ketersediaan_lahan'); ?></span>
                                        </div>
                                    </div><!--end control-group-->

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="long_awal">Peta: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <?php 
												$map = isset($map['html']) ? $map['html'] : '';											
												echo $map; 
											?>
                                        </div>
                                    </div><!--end control-group--> 
									
									
									<div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="long_awal">Longitude: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="long" name="long" placeholder=Longitude" value="<?php echo set_value('long', isset($lain_list['long']) ? $lain_list['long'] : ''); ?>">
                                            <span class="help-inline"><?php echo form_error('long'); ?></span>
                                        </div>
                                    </div><!--end control-group-->

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="lat">Latitude: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="lat" name="lat" placeholder="Latitude" value="<?php echo set_value('lat', isset($lain_list['lat']) ? $lain_list['lat'] : ''); ?>">
                                            <span class="help-inline"><?php echo form_error('lat'); ?></span>
                                        </div>
                                    </div><!--end control-group-->

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="anggaran">Anggaran: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">                                               	  
                                            <input type="text" class="form-control" id="anggaran" name="anggaran" placeholder="Silakan isi anggaran" value="<?php echo set_value('anggaran', isset($lain_list['anggaran']) ? $lain_list['anggaran'] : ''); ?>">
                                            <span class="help-inline"><?php echo form_error('anggaran'); ?></span>
                                        </div>
                                    </div><!--end control-group-->

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="sumber_data">Sumber Data: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="sumber_data" name="sumber_data" placeholder="Silakan isi Sumber Data" value="<?php echo set_value('sumber_data', isset($lain_list['sumber_data']) ? $lain_list['sumber_data'] : ''); ?>" data-validation-help="Sumber data MCK berasal darimana">
                                            <span class="help-inline"><?php echo form_error('sumber_data'); ?></span>
                                        </div>
                                    </div><!--end control-group-->

                                   <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="tahun_usulan">Tahun Usulan: <span class="text-error">*</span></label>
                                        <div class="col-md-3 col-xs-11">
                                            <div data-date-minviewmode="years" data-date-viewmode="years" data-date-format=" yyyy" data-date="102/2012"  class="input-append date dpYears">
                                         <input type="text" class="form-control" id="tahun_usulan" name="tahun_usulan" placeholder="Silakan isi tahun Usulan" value="<?php echo set_value('tahun_usulan', isset($lain_list['tahun_usulan']) ? $lain_list['tahun_usulan'] : ''); ?>" readonly>
                                            <span class="help-inline"><?php echo form_error('tahun_usulan'); ?></span>
                                              <span class="input-group-btn add-on">
                                                <button class="btn btn-danger" type="button"><i class="icon-calendar"></i></button>
                                              </span>
                                      </div>
                                        </div>
                                    </div><!--end control-group-->
									
									<div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="sumber_data">Persetujuan Warga: <span class="text-error">*</span></label>
                                        <div class="col-md-3 col-xs-11">											
											 <?php 
												 $options = array(
													  'Ada'  => 'Ada',
													  'Tidak'    => 'Tidak'
													);
												 
												 echo form_dropdown('persetujuan_warga', $options, set_value('persetujuan_warga', isset($lain_list['persetujuan_warga']) ? $lain_list['persetujuan_warga'] : ''), 'class="form-control m-bot15"'); ?>
                                            <span class="help-inline"><?php echo form_error('persetujuan_warga'); ?></span>
                                        </div>
                                    </div><!--end control-group-->

                                   <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="ket">Keterangan: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                           <textarea class="form-control" id="ket" name="ket"> <?php echo set_value('ket', isset($lain_list['ket']) ? $lain_list['ket'] : ''); ?></textarea>                                           
                                            <span class="help-inline"><?php echo form_error('ket'); ?></span>
                                        </div>
                                    </div><!--end control-group-->

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="foto">Foto: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="file" class="form-control" id="foto" name="foto" placeholder="Foto" value="<?php echo set_value('foto'); ?>" data-validation="mime size" data-validation-allowing="jpg, png, gif" 
													data-validation-max-size="512kb">
                                            <span class="help-inline"><?php echo form_error('foto'); ?></span>
                                        </div>
                                    </div><!--end control-group-->

                                     <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" for="dokumen">Dokumen: <span class="text-error">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="file" class="form-control" id="dokumen" name="dokumen" placeholder="Dokumen" value="<?php echo set_value('dokumen'); ?>">
                                            <span class="help-inline"><?php echo form_error('dokumen'); ?></span>
                                        </div>
                                    </div><!--end control-group-->


                                                                        
                                    <div class="form-group">
                                        <div class="col-lg-10"> 
                                            <button type="submit" class="btn btn-primary"><?echo $namaform ?></button>
                                            <button type="reset" class="btn btn-primary">Reset</button>
                                        </div>
                                    </div><!--end control-group-->

                                </form><!--end form-->
                            </div>
                        </section>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
		   <?php $this->load->view('admin/templates/footer'); ?>
		   
	 <!--js only this page-->	   
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/fuelux/js/spinner.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/jquery-multi-select/js/jquery.multi-select.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/jquery-multi-select/js/jquery.quicksearch.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/js/advanced-form-components.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
     
	<script type="text/javascript">
		//FUNGSI MENANGKAP Latitude DAN lONGITUDE DAN MENYIMPANNYA KE DALAM VARIABEL ID DI FORM
		function getLokasi(newLat, newLng)
		{			
					document.getElementById('lat').value= newLat;
					document.getElementById('long').value= newLng;
		}
		
	</script>		