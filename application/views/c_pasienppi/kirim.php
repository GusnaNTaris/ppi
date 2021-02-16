<?php
  $this->load->view("layout/header");
?>
<style type="text/css">
  @media screen and (min-width: 768px) {
    .box-body {
        padding: 15px;
    }
    .profile-username {
      margin-top: 10px;
    }
    textarea {
      resize: none;
    }
    .checkbox, .radio {
        margin-top: 0;
    }
  }
</style>
<script type="text/javascript">
  $(document).ready(function() {  
    $('.select2').select2();  
    $('.date_picker').datepicker({
      format: "yyyy-mm-dd",      
      autoclose: true,
      todayHighlight: true,
      beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
          inst.dpDiv.css({ top: rect.top + 40, left: rect.left + 0 });
        }, 0);
      }
    });
	<?php if ($title != '<i class="fa fa-hospital-o"></i>Update Form Surveilans PPI'){ ?>
		$('#form_ppi').on('submit', function(e){       
			 $("#btn-save").prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Mengirim Data PPI...');
			 $.ajax({    
			   url: "<?php echo base_url().'C_pasienppi/senddata'; ?>",                       
			   type: "POST",
			   dataType: "HTML",
			   data: $('#form_ppi').serialize(),
			   success: function(result) {
				 console.log(result);
				 $("#btn-save").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> KIRIM DATA PPI'); 
				 swal("Sukses","Data TB Berhasil Dikirim.", "success"); 
				 location.reload(); 
			   },
			   error:function(event, textStatus, errorThrown) {
				 $("#btn-save").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> KIRIM DATA PPI');
				 swal("Gagal Mengirim Data PPI",formatErrorMessage(event, errorThrown), "error"); 
			   }  
			 }); 
			 e.preventDefault();          
		 }); 
	 <?php }; ?>
	 <?php if ($title == '<i class="fa fa-hospital-o"></i>Update Form Surveilans PPI'){ ?>
		 $('#form_ppi').on('submit', function(e){       
			 $("#btn-update").prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Mengupdate Data PPI...');
			 $.ajax({    
			   url: "<?php echo site_url('C_pasienppi/senddataupdate/'.$data_pasien->ID_SENSUS); ?>",                       
			   type: "POST",
			   dataType: "HTML",
			   data: $('#form_ppi').serialize(),
			   success: function(result) {
				 console.log(result);
				 $("#btn-update").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> UPDATE DATA PPI'); 
				 swal("Sukses","Data TB Berhasil Di Update.", "success"); 
				 location.reload(); 
			   },
			   error:function(event, textStatus, errorThrown) {
				 $("#btn-update").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> UPDATE DATA PPI');
				 swal("Gagal Mengupdate Data PPI",formatErrorMessage(event, errorThrown), "error"); 
			   }  
			 }); 
			 e.preventDefault();          
		 });
	 <?php }; ?>
  }); 
 
</script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
	
    <form method="POST" id="form_ppi" role="form">                     
          <!-- <input type="hidden" name="id_personil" id="id_personil" value="">       -->
		  <input type="hidden" name="jenis_kelamin" value="<?php echo $data_pasien->SEX; ?>"> 
          <input type="hidden"name="nama_pasien" id="nama_pasien" value="<?php echo $data_pasien->NAMA; ?>">
          <input type="hidden" name="tmpt_lahir" id="tmpt_lahir" value="<?php echo $data_pasien->TMPT_LAHIR; ?>">
          <input type="hidden" name="tgl_lahir" id="tgl_lahir" value="<?php echo date('d-m-Y',strtotime($data_pasien->TGL_LAHIR)); ?>">
          <div class="row">
            <div class="col-md-4">               
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url("asset/images/patient.png");?>" alt="<?php echo $data_pasien->NAMA; ?>">

                  <h3 class="profile-username text-center"><?php echo $data_pasien->NAMA; ?></h3> 
                  <input type="hidden" name="kd_pasien" value="<?php echo $data_pasien->NAMA; ?>">
                  <p class="text-muted text-center">No. RM : <?php echo $data_pasien->NO_MEDREC; ?></p>
                  <input type="hidden" name="no_cm" value="<?php echo $data_pasien->NO_MEDREC; ?>">
                  <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                      <b>NO REGISTER</b> <a class="pull-right"><?php echo $data_pasien->NO_REGISTER; ?></a>
                      <input type="hidden" name="no_register" value="<?php echo $data_pasien->NO_REGISTER; ?>">
                    </li>

                    <li class="list-group-item">
                      <b>Jenis Kelamin</b> <a class="pull-right"><?php if($data_pasien->SEX == 'L') echo 'Laki-Laki';if($data_pasien->SEX == 'P') echo 'Perempuan'; ?></a>
                      <input type="hidden" name="sex" value="<?php echo $data_pasien->SEX; ?>">
                    </li>
                    <li class="list-group-item">
                      <b>Umur</b> 
                      <a class="pull-right">
                        <?php 
                          $tanggal = new DateTime(date('Y-m-d',strtotime($data_pasien->TGL_LAHIR))); 
                          $today = new DateTime('today');
                          echo $today->diff($tanggal)->y;
                        ?>  
                        <input type="hidden" name="umur" value="<?php echo $today->diff($tanggal)->y; ?>">
                      </a>
                    </li>
                    <li class="list-group-item">
                      <b>Tanggal Lahir</b> <a class="pull-right"><?php echo date('Y-m-d',strtotime($data_pasien->TGL_LAHIR)); ?></a>
                      <input type="hidden" name="tgl_lahir" value="<?php echo date('Y-m-d\TH:i.s.000\Z',strtotime($data_pasien->TGL_LAHIR)); ?>">
                    </li>
                    <li class="list-group-item">
                      <b>Tempat Lahir</b> <a class="pull-right"><?php echo $data_pasien->TMPT_LAHIR; ?></a>
                      <input type="hidden" name="alamat_lengkap" value="<?php echo $data_pasien->ALAMAT; ?>">
                    </li>
                   </ul>
              <!--     <button class="btn btn-primary btn-block" type="submit" id="btn-save"><i class="fa fa-paper-plane"></i>Simpan</button> -->
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <div class="col-md-8">   
              <div class="box box-primary">
				<div class="form-group">
				  <br/>
                  <p align="center"><strong> DATA PASIEN HEALTHCARE ASSOCIATION INFECTIONS </strong></p>
				  <hr width="75%" align="center">
                </div>			  
                <div class="box-body">                
                  <div class="row">
                    <div class="col-md-6">  
                      <div class="form-group">
						<div class="form-group">
							<label for="Ruang">Ruang (*) :</label>
							<select class="form-control" name="IDRG" id="IDRG" style="width: 100%;">
								<option value="<?php echo $data_pasien->IDRG;?>"><?php echo $data_pasien->NMRUANG;?></option>
								<?php 
								foreach($data_ruang as $value3){
									echo '<option value="'.$value3->IDRG.'">'.$value3->NMRUANG.'</option>';
								}
								?>
							</select>
						</div>
                      </div>    
                      <div class="form-group">
                        <label for="kd_wasor">Tanggal Masuk :</label>
                        <input type="text" class="form-control" name="tglmasukrg" id="tglmasukrg" value="<?php echo date('Y-m-d',strtotime($data_pasien->TGLMASUKRG)); ?>">
                      </div>  
                      <div class="form-group">
                        <label for="noregkab">Tanggal Keluar/Pindah :</label>
                        <input type="text" class="form-control" name="tglkeluarrg" id="tglkeluarrg" value="<?php echo date('Y-m-d',strtotime($data_pasien->TGLKELUARRG)); ?>">
                      </div>  
                      <div class="form-group">
                        <label for="Diagnosa">Diagnosa</label>
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
							<input type="text" class="form-control" name="diagnosa" id="diagnosa" value="<?= $data_pasien->DIAGNOSA;?>">
						<?php } else { ?>
							<input type="text" class="form-control" name="diagnosa" id="diagnosa" value="">
						<?php } ?>	
                      </div> 
					  <div class="form-group">
                        <label for="tanggal_mulai_pengobatan">Tanggal Sensus :</label>     
                        <div class="input-group">  
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
							<input type="text" class="form-control date_picker" name="tanggal_alat" id="tanggal_alat" value="<?= $data_pasien->TGL_SENSUS;?>" maxlength="10">
						<?php } else { ?>
							<input type="text" class="form-control date_picker" name="tanggal_alat" id="tanggal_alat" value="" maxlength="10">
						<?php } ?>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div> 
                      </div>
                        <div class="form-group">
                        <label for="Alat yang digunakan">Alat yang Digunakan :</label>
                        <select class="form-control" name="alat" id="alat" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
							<option value="<?= $data_pasien->ALAT ;?>" selected><?= $data_pasien->ALAT; ?></option>
						<?php } else { ?>
							<option value="" selected>-- Silahkan Pilih Alat--</option>
						<?php }
							foreach($list_alat as $value)
							{
								echo '<option value="'.$value->NAMA_ALAT.'">'.$value->NAMA_ALAT.'</option>';
							} 
						  ?>
                        </select>
                      </div>  
                      <div class="form-group">
                        <label for="Kegiatan Sensus">Kegiatan Sensus :</label> 
                        <select class="form-control" name="kegiatan" id="kegiatan" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
							<option value="<?= $data_pasien->KEG_SENSUS; ?>" selected><?= $data_pasien->KEG_SENSUS; ?></option>
						<?php } else { ?>
							<option value="" selected>-- Silahkan Pilih Kegiatan--</option>
						<?php } ?>
                          <option value="Pasang Alat">Pasang Alat</option>
                          <option value="Monitoring">Monitoring</option>
                          <option value="Lepas Alat">Lepas Alat</option>
						  <option value="Tirah Baring">Tirah Baring</option>
                        </select>
                      </div>					  
                      <div class="form-group">
                        <label for="Hasil Rontgen">Hasil Rontgen (*) : </label>
                        <?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI')AND(($data_pasien->ALAT == ' - (Tirah Baring)')OR($data_pasien->ALAT == 'ETT Ventilator'))){ ?>
							<input type="text" class="form-control" name="rontgen" id="rontgen" value="<?= $data_pasien->HASIL_RONTGEN; ?>">
						<?php } else { ?>
							<input type="text" class="form-control" name="rontgen" id="rontgen" value="" disabled>
						<?php } ?>
                      </div>
                      <div class="form-group">
                        <label for="tanggal_mulai_pengobatan">Tanggal Rontgen (*) :</label>     
                        <div class="input-group">
                        <?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI')AND(($data_pasien->ALAT == ' - (Tirah Baring)')OR($data_pasien->ALAT == 'ETT Ventilator'))){ ?>
							<input type="text" class="form-control date_picker" name="tanggal_rontgen" id="tanggal_rontgen" value="<?= $data_pasien->TGL_RONTGEN; ?>" maxlength="10">
						<?php } else { ?>
							<input type="text" class="form-control date_picker" name="tanggal_rontgen" id="tanggal_rontgen" value="" maxlength="10" disabled>
						<?php } ?>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div> 
                      </div>
					  <a class="green"> (*) Apabila pasien memakai ETT Ventilator atau  Tirah Baring dan membutuhkan pengisian Hasil Rontgen, Silahkan isi lagi pada update/insert data PPI</a> 
                    </div> <!-- col-md-6 -->
                     <div class="col-md-6">
					  <div class="form-group">
                        <label for="infeksirs">Jenis Infeksi Rumah Sakit :</label>
						</br>
						</br>
						<div class="form-inline">
							<div class="col-md-4">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->VAP == '1')){ ?>
							<input type="checkbox" name="VAP" id="VAP" value="1" checked>VAP
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_vap" id="tanggal_vap" value="<?=$data_pasien->TGL_VAP;?>" maxlength="10">
						<?php } else { ?>
							<input type="checkbox" name="VAP" id="VAP" value="1">VAP
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_vap" id="tanggal_vap" value="" maxlength="10" placeholder="Tanggal VAP">
						<?php } ?>
							</div>
						</div>
						</br>
						<div class="form-inline">
							<div class="col-md-4">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->HAP == '1')){ ?>
							<input type="checkbox" name="HAP" id="HAP" value="1" checked>HAP
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_hap" id="tanggal_hap" value="<?=$data_pasien->TGL_HAP;?>" maxlength="10">
						<?php } else { ?>
							<input type="checkbox" name="HAP" id="HAP" value="1">HAP
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_hap" id="tanggal_hap" value="" maxlength="10" placeholder="Tanggal HAP">
						<?php } ?>
							</div>
						</div>
						</br>
						<div class="form-inline">
							<div class="col-md-4">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->IDO == '1')){ ?>
							<input type="checkbox" name="IDO" id="IDO" value="1" checked>IDO 
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_ido" id="tanggal_ido" value="<?=$data_pasien->TGL_IDO;?>" maxlength="10">
						<?php } else { ?>
							<input type="checkbox" name="IDO" id="IDO" value="1">IDO 
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_ido" id="tanggal_ido" value="" maxlength="10" placeholder="Tanggal IDO">
						<?php } ?>
							</div>
						</div>
						</br>
						<div class="form-inline">
							<div class="col-md-4">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->ISK == '1')){ ?>
							<input type="checkbox" name="ISK" id="ISK" value="1" checked>ISK 
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_isk" id="tanggal_isk" value="<?=$data_pasien->TGL_ISK;?>" maxlength="10">
						<?php } else { ?>
							<input type="checkbox" name="ISK" id="ISK" value="1">ISK
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_isk" id="tanggal_isk" value="" maxlength="10" placeholder="Tanggal ISK">
						<?php } ?>
							</div>
						</div>
						</br>
						<div class="form-inline">
							<div class="col-md-4">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->IADP == '1')){ ?>
							<input type="checkbox" name="IADP" id="IADP" value="1" checked>IADP 
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_iadp" id="tanggal_iadp" value="<?=$data_pasien->TGL_IADP;?>" maxlength="10">
						<?php } else { ?>
							<input type="checkbox" name="IADP" id="IADP" value="1">IADP 
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_iadp" id="tanggal_iadp" value="" maxlength="10" placeholder="Tanggal IADP">
						<?php } ?>
							</div>
						</div>
						</br>
						<div class="form-inline">
							<div class="col-md-4">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->DEKUB == '1')){ ?>
							<input type="checkbox" name="DEKUB" id="DEKUB" value="1" checked>DEKUB 
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_dekub" id="tanggal_dekub" value="<?=$data_pasien->TGL_DEKUB;?>" maxlength="10">
						<?php } else { ?>
							<input type="checkbox" name="DEKUB" id="DEKUB" value="1">DEKUB 
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_dekub" id="tanggal_dekub" value="" maxlength="10" placeholder="Tanggal DEKUB">
						<?php } ?>
							</div>
						</div>
						</br>
						<div class="form-inline">
							<div class="col-md-4">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->PLEB == '1')){ ?>
							<input type="checkbox" name="PLEB" id="PLEB" value="1" checked> PLEB
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_pleb" id="tanggal_pleb" value="<?=$data_pasien->TGL_PLEB;?>" maxlength="10">
						<?php } else { ?>
							<input type="checkbox" name="PLEB" id="PLEB" value="1"> PLEB
							</div>
							<div class="col-md-7">
							<input type="text" class="form-control date_picker" name="tanggal_pleb" id="tanggal_pleb" value="" maxlength="10" placeholder="Tanggal PLEB">
						<?php } ?>
							</div>
						</div>
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
                      </div> 
					  <div class="form-group">
                        <label for="jeniskuman">Jenis Kuman</label>
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
							<input type="text" class="form-control" name="jeniskuman" id="jeniskuman" value="<?= $data_pasien->JENIS_KUMAN; ?>">
						<?php } else { ?>	
							<input type="text" class="form-control" name="jeniskuman" id="jeniskuman" value="">
						<?php } ?>
                      </div>
                      <div class="form-group">
						<label for="tanggal_mulai_pengobatan">Tanggal Terinfeksi Kuman :</label>     
                        <div class="input-group">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
                          <input type="text" class="form-control date_picker" name="tanggal_kuman" id="tanggal_kuman" value="<?= $data_pasien->TGL_KUMAN; ?>" maxlength="10">
						<?php } else { ?> 
						  <input type="text" class="form-control date_picker" name="tanggal_kuman" id="tanggal_kuman" value="" maxlength="10">
						<?php } ?>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>  
                      <div class="form-group">
                        <label for="jumlahkultur">Jenis Kultur Pendukung HAIs :</label>
						<br/>
						<label class="checkbox-inline">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->DARAH == '1')){ ?>
						<input type="checkbox" name="darah" id="darah" value="1" checked> Darah
						<?php } else { ?>
						<input type="checkbox" name="darah" id="darah" value="1"> Darah
						<?php } ?>
						</label>
						<label class="checkbox-inline">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->SPUTUM == '1')){ ?>
						<input type="checkbox" name="sputum" id="sputum" value="1" checked> Sputum
						<?php } else { ?>
						<input type="checkbox" name="sputum" id="sputum" value="1"> Sputum
						<?php } ?>
						</label>
						<label class="checkbox-inline">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->SWAB_LUKA == '1')){ ?>
							<input type="checkbox" name="sluka" id="sluka" value="1" checked> Swab Luka
						<?php } else { ?>	
							<input type="checkbox" name="sluka" id="sluka" value="1"> Swab Luka
						<?php } ?>
						</label>
						<label class="checkbox-inline">
						<?php if (($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI') AND ($data_pasien->URINE == '1')){ ?>
							<input type="checkbox" name="urine" id="urine" value="1" checked> Urine
						<?php } else { ?>		
							<input type="checkbox" name="urine" id="urine" value="1"> Urine
						<?php } ?>
						</label>
                      </div>
					  <br/>
					  <div class="form-group">
                        <label for="Antibiotik">Antibiotik :</label>
                        <select class="form-control" name="idantibio" id="idantibio" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
						  <option value="<?= $data_pasien->ID_ANT ?>"><?= $data_pasien->ANTIBIOTIK ?></option>
						<?php } else { ?>
                          <option value="">-- Silahkan Pilih Antibiotik--</option>
						<?php }
						foreach($data_ab as $rowab)
						{
							if (($rowab->IS_ACTIVE) == '1') {
								echo '<option value="'.$rowab->ID_ANT.'">'.$rowab->NAMA_ANT.'</option>';
							}
						}
						  ?>
                        </select>
                      </div>
					  <div class="form-group">
						<label for="Antibiotik">Transmisi :</label>
                        <select class="form-control" name="transmisi" id="transmisi" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
                          <option value="<?= $data_pasien->TRANSMISI ?>"><?= $data_pasien->TRANSMISI ?></option>
						<?php } else { ?>
                          <option value="">-- Silahkan Pilih Transmisi--</option>
						<?php } ?>
                          <option value="Kontak">Kontak</option>
						  <option value="Droplet">Droplet</option>
						  <option value="Airborne">Airborne</option>
						</select>
                      </div>
					  <div class="form-group">
                        <label for="button"> </label>
						<?php if ($title == '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
						<button class="btn btn-primary btn-block" type="submit" id="btn-save"><i class="fa fa-paper-plane"></i>Simpan</button>
						<?php } if ($title == '<i class="fa fa-hospital-o"></i>Insert Form Surveilans PPI') { ?>
						<button class="btn btn-primary btn-block" type="submit" id="btn-save"><i class="fa fa-paper-plane"></i>Insert</button>
						<?php } if ($title == '<i class="fa fa-hospital-o"></i>Update Form Surveilans PPI') { ?>
						<button class="btn btn-primary btn-block" type="submit" id="btn-update"><i class="fa fa-paper-plane"></i>Update</button>
						<?php } ?>
                      </div>                                                    
                    </div> <!-- col-md-6 -->                                            
                  </div>
				  <hr width="75%" align="center">
				  <nav>
					<ul class="pager">
						<?php if ($title == '<i class="fa fa-hospital-o"></i> Form Surveilans PPI'){ ?>
						<li><a class="green" href="<?=site_url('c_pasienppi');?>"> <i class="fa fa-arrow-left"></i> Kembali </a></li>
						<li><a class="green" href="<?=site_url('c_datappi');?>"> <i class="fa fa-arrow-right"></i> Berikutnya </a></li>
						<?php } else { ?>
						<li><a class="green" href="<?=site_url('c_datappi');?>"> <i class="fa fa-arrow-right"></i> Berikutnya </a></li>
						<?php } ?>
					</ul>
				  </nav>
				<br/>
                </div>
              </div>
			  <input type="hidden" id="usr" name="usr" value="<?php echo $user_info->USERID; ?>">
			  <input type="hidden"name="tgl_entry" id="tgl_entry" value="<?php echo date('Y-m-d');?>">
            </div>
          </div> 
    </form>
    </div>
  </div> 
</section>              
<?php
  $this->load->view("layout/footer");
?>
