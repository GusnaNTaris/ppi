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
	
	<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Update Data IDO') { ?>
    $('#form_ido').on('submit', function(e){       
         $("#btn-save").prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Sabar ya, Sedang mengirim Data IDO...');
         $.ajax({    
           url: "<?php echo base_url().'C_pasienido/senddata'; ?>",                       
           type: "POST",
           data: $('#form_ido').serialize(),
		   datatype: "html",
           success: function(result) {
             console.log(result);
             $("#btn-save").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> KIRIM DATA IDO');  
             swal("Sukses","Data IDO Berhasil Dikirim.", "success"); 
             location.reload(); 
           },
           error:function(event, textStatus, errorThrown) {
             $("#btn-save").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> KIRIM DATA IDO');
             swal("Gagal Mengirim Data IDO",formatErrorMessage(event, errorThrown), "error"); 
           }  
         }); 
         e.preventDefault();          
     });
	<?php }; ?>
	
	<?php if ($title == '<i class="fa fa-hospital-o"></i> Form Update Data IDO') { ?>
    $('#form_ido').on('submit', function(e){       
         $("#btn-update").prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Sabar ya, Sedang mengupdate Data IDO...');
         $.ajax({    
           url: "<?php echo site_url('C_pasienido/senddataupdate/'.$data_pasien->ID_IDO); ?>",                       
           type: "POST",
           data: $('#form_ido').serialize(),
		   datatype: "html",
           success: function(result) {
             console.log(result);
             $("#btn-update").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> UPDATE DATA IDO');  
             swal("Sukses","Data IDO Berhasil Diupdate.", "success"); 
             location.reload(); 
           },
           error:function(event, textStatus, errorThrown) {
             $("#btn-update").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> UPDATE DATA IDO');
             swal("Gagal Mengupdate Data IDO",formatErrorMessage(event, errorThrown), "error"); 
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
    <form method="POST" id="form_ido" role="form"> 
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
                  <p align="center"><strong> INPUT PASIEN INFEKSI DAERAH OPERASI </strong></p>
				  <hr width="75%" align="center">
                </div>			  
                <div class="box-body">                
                  <div class="row">
                    <div class="col-md-6">  
                      <div class="form-group">
                        <label for="Diagop">Diagnosa Operasi :</label>
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
							<input type="text" class="form-control" name="diagop" id="diagop" value="<?= $data_pasien->DIAGNOSA_OPERASI ;?>">
						<?php } else { ?>
							<input type="text" class="form-control" name="diagop" id="diagop" value="">
						<?php } ?>
                      </div>    
                      <div class="form-group">
                        <label for="Jenis_Operasi">Jenis Operasi :</label>
                        <select class="form-control" name="jenop" id="jenop" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
                          <option value="<?= $data_pasien->JENIS_OPERASI; ?>" selected><?= $data_pasien->JENIS_OPERASI; ?>*</option>
						<?php } else { ?>
						  <option value="" selected>-- Silahkan Pilih Jenis Operasi--</option>
						<?php } ?>
                          <option value="B">Bersih</option>
                          <option value="BT">Bersih Tercemar</option>
                          <option value="T">Tercemar</option>
                          <option value="K">Kotor</option>
                        </select>
					  </div>  
                      <div class="form-group">
                        <label for="ASA_Score">ASA Score :</label>
                        <select class="form-control" name="asa" id="asa" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
                          <option value="<?= $data_pasien->ASA_SCORE; ?>" selected><?= $data_pasien->ASA_SCORE; ?>*</option>
						<?php } else { ?>
						  <option value="" selected>-- Silahkan Pilih ASA Score--</option>
						<?php } ?>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
						  <option value="5">5</option>
                        </select>
					  </div>  
                      <div class="form-group">
                        <label for="Lama_Operasi">Lama Operasi :</label>
                        <select class="form-control" name="lop" id="lop" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
                          <option value="<?= $data_pasien->LAMA_OPERASI; ?>" selected><?= $data_pasien->LAMA_OPERASI; ?>*</option>
						<?php } else { ?>
						  <option value="" selected>-- Jangka Waktu Lama Operasi--</option>
						<?php } ?>
                          <option value="0-60">0-60 Menit</option>
                          <option value="60-300">60-300 Menit</option>
                          <option value=">300">Lebih dari 300 Menit</option>
                        </select>
                      </div>
					  <div class="form-group">
                        <label for="Risk_Score">Risk Score :</label>
                        <select class="form-control" name="rscore" id="rscore" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
                          <option value="<?= $data_pasien->TOTAL_RISK_SCORE; ?>" selected><?= $data_pasien->TOTAL_RISK_SCORE; ?>*</option>
						<?php } else { ?>
						  <option value="" selected>-- Silahkan Pilih Risk Score--</option>
						<?php } ?>
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                        </select>
                      </div>
                    </div> <!-- col-md-6 -->
         

                     <div class="col-md-6"> 
                       <div class="form-group">
                        <label for="tanggal_IDO">Tanggal Infeksi Daerah Operasi (IDO) :</label>     
                        <div class="input-group">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
                          <input type="text" class="form-control date_picker" name="tanggal_ido" id="tanggal_ido" value="<?php echo date('Y-m-d',strtotime($data_pasien->TANGGAL_IDO)); ?>">
						<?php } else { ?>
						  <input type="text" class="form-control date_picker" name="tanggal_ido" id="tanggal_ido" value="<?php echo date('Y-m-d',strtotime($data_pasien->TGL_IDO)); ?>">
						<?php } ?>
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div> 
                      </div>
                        <div class="form-group">
                        <label for="Sifat_Operasi">Sifat Operasi :</label>
                        <select class="form-control" name="sifop" id="sifop" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
                          <option value="<?= $data_pasien->SIFAT_OPERASI; ?>" selected><?= $data_pasien->SIFAT_OPERASI; ?>*</option>
						<?php } else { ?>
						  <option value="" selected>-- Sifat Operasi --</option>
						<?php } ?>
                          <option value="Cito">Cito</option>
                          <option value="Efektif">Efektif</option>
                        </select>
                      </div>  
                      <div class="form-group">
                        <label for="Antibiotik">Antibiotik :</label>
                        <select class="form-control" name="antib" id="antib" style="width: 100%;">
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
                          <option value="<?= $data_pasien->ANTIBIOTIK; ?>" selected><?= $data_pasien->ANTIBIOTIK; ?>*</option>
						<?php } else { ?>
						  <option value="" selected>-- Silahkan Pilih Antibiotik--</option>
						<?php } ?>
                          <option value="Propil">Propil</option>
                          <option value="Terapi">Terapi</option>
                        </select>
                      </div> 
					  <div class="form-group">
                        <label for="Diagop">Hasil Kultur (Swab Luka) :</label>
						<?php if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
							<input type="text" class="form-control" name="hkultur" id="hkultur" value="<?= $data_pasien->HASIL_KULTUR;?>">
						<?php } else { ?>
							<input type="text" class="form-control" name="hkultur" id="hkultur" value="">
						<?php } ?>
                      </div>
                      <div class="form-group">
                       <label for="button"></label>
					   <?php if ($title == '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
						  <button class="btn btn-primary btn-block" type="submit" id="btn-save"><i class="fa fa-paper-plane"></i>Simpan</button>
					   <?php } if ($title == '<i class="fa fa-hospital-o"></i> Form Update Data IDO') { ?>
						  <button class="btn btn-primary btn-block" type="submit" id="btn-update"><i class="fa fa-paper-plane"></i>Update</button>
					   <?php } if ($title != '<i class="fa fa-hospital-o"></i> Form Surveilans IDO') { ?>
						  <a class="green"> (*) pastikan data tersebut sudah diubah / tetap </a>
					   <?php } ?>
                      </div>

                        <div class="form-group">
                        <label for="Diagnosa"></label>
                      </div>                                                       
                    </div> <!-- col-md-6 -->                                            
                  </div>
				  <hr width="75%" align="center">
				  <nav>
					<ul class="pager">
						<li><a class="green" href="<?=site_url('c_pasienido');?>"> <i class="fa fa-arrow-left"></i> Kembali </a></li>
					</ul>
				  </nav>
				<br/>
                </div>
              </div>
			  <input type="hidden" id="usr" name="usr" value="<?php echo $user_info->USERID; ?>">
			  <input type="hidden"name="tgl_entry" id="tgl_entry" value="<?php echo date('Y-m-d');?>">
			  <input type="hidden"name="idsensus" id="idsensus" value="<?php echo $data_pasien->ID_SENSUS;?>">
            </div>
          </div>
    </form>
    </div>
  </div> 
</section>              
<?php
  $this->load->view("layout/footer");
?>