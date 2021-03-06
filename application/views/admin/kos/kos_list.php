<?php $this->load->view('admin/templates/header'); ?>
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
								<ul class="nav nav-tabs pull-right">
									<li><a href="<?php echo base_url() . 'admin/kos_managements/gotoForm/add'; ?>"><i class="icon-plus"></i> Add Data</a></li>
								</ul>
                                <span class="hidden-sm wht-color">Data Rumah Kos dan Toko Jamu</span>
                            </header>
							
                            <div class="panel-body">
                                <div class="adv-table">
                                    <?php
                                    $message = $this->session->flashdata('message');
                                    echo $message == '' ? '' : '<p id="message">' . $message . '</p>';
                                    ?>
                                    <section id="unseen">
                                        <table  class="display table table-bordered table-striped table-condensed" id="example">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
													<th>Nama Pemilik</th>
													<th>Alamat Pemilik</th>
													<th>Rw</th>
													<th>Jumlah Kamar</th>
													<th>Jumlah Orang per Kamar</th>
													<th>Ijin Usaha</th>
													<th>Harga Sewa</th>
													<th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;

                                                $jum = count(@$data_list);
                                                if ($jum > 0) {
                                                    foreach ($data_list as $row) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $no++ ?></td>
                                                            <td><?php echo $row->nama_pemilik ?></td> 
															<td><?php echo $row->alamat_pemilik ?></td>
															<td><?php echo $row->rw ?></td>
															<td><?php echo $row->jml_kamar ?></td>									                                                            
															<td><?php echo $row->jml_orang_perkamar ?></td>                                                             
															<td><?php echo $row->ijin_usaha?></td>
															<td><?php echo $row->harga_sewa?></td>
															<td><?php echo $row->ket?></td>
															<td>
                                                                <a href="<?php echo base_url() . 'admin/kos_managements/gotoForm/edit/' . $row->id_kos ?>"><button class = "btn btn-primary" title="Edit"><i class = "icon-pencil"></i></button></a>
                                                                <a href="<?php echo base_url() . 'admin/kos_managements/delete/' . $row->id_kos ?>" onclick="return confirm('Are you sure want to delete this?');"><button class = "btn btn-danger" title="Delete"><i class = "icon-trash "></i></button></a>
                                                            </td>

                                                        </tr>
													<?php
													} //end foreach
												} // end if
												?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
													<th>Nama Pemilik</th>
													<th>Alamat Pemilik</th>
													<th>Rw</th>
													<th>Jumlah Kamar</th>
													<th>Jumlah Orang per Kamar</th>
													<th>Ijin Usaha</th>
													<th>Harga Sewa</th>
													<th>Keterangan</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </section>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
<?php $this->load->view('admin/templates/footer'); ?>		