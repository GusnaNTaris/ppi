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
	
</script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
    <form method="POST" id="form_ido" role="form"> 
          <div class="row">
            <div class="col-md-4">               
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url("asset/images/patient.png");?>" alt="<?php echo $data_pasien->NAMA; ?>">

                  <h3 class="profile-username text-center"><?php echo $data_pasien->NAMA; ?></h3> 
                  <p class="text-muted text-center">No. RM : <?php echo $data_pasien->NO_MEDREC; ?></p>
                  <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                      <b>NO REGISTER</b> <a class="pull-right"><?php echo $data_pasien->NO_REGISTER; ?></a>
                      <input type="hidden" name="no_register" value="<?php echo $data_pasien->NO_REGISTER; ?>">
                  </li>
                  <li class="list-group-item">
                      <b>Jenis Kelamin</b> <a class="pull-right"><?php if($data_pasien->SEX == 'L') echo 'Laki-Laki';if($data_pasien->SEX == 'P') echo 'Perempuan'; ?></a>
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
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <div class="col-md-8"> 
              <div class="box box-primary">
				<div class="form-group">
				  <br/>
                  <p align="center"><strong> DATA PASIEN INFEKSI DAERAH OPERASI </strong></p>
				  <hr width="75%" align="center">
                </div>
                <div class="box-body">                
                  <div class="row">
                    <div class="col-md-6">  
                      <div class="form-group">
                        <p><strong>Diagnosa Operasi :</strong></p>
                        <p><?php echo $data_pasien->DIAGNOSA_OPERASI; ?></p>
                      </div>    
                      <div class="form-group">
                        <p><strong>Jenis Operasi :</strong></p>
                        <p><?php
						if($data_pasien->JENIS_OPERASI == 'B')
							echo "Bersih";
						if($data_pasien->JENIS_OPERASI == 'BT')
							echo "Bersih Tercampur";
						if($data_pasien->JENIS_OPERASI == 'T')
							echo "Tercampur";
						if($data_pasien->JENIS_OPERASI == 'K')
							echo "Kotor";
						?></p>
					  </div>  
                      <div class="form-group">
                        <p><strong>ASA Score :</strong></p>
                        <p><?php echo $data_pasien->ASA_SCORE; ?></p>
					  </div>  
                      <div class="form-group">
                        <p><strong>Lama Operasi :</strong></p>
                        <p><?php echo $data_pasien->LAMA_OPERASI; ?> menit</p>
                      </div>
					  <div class="form-group">
                        <p><strong>Total Risk Score :</strong></p>
                        <p><?php echo $data_pasien->TOTAL_RISK_SCORE; ?></p>
                      </div>
                    </div> <!-- col-md-6 -->
         

                     <div class="col-md-6">
                       <div class="form-group">
                        <p><strong>Tanggal Infeksi Daerah Operasi (IDO) :</strong></p>     
                        <div class="input-group">
                          <p><?php echo $data_pasien->TANGGAL_IDO; ?></p>
                        </div> 
                      </div>
                        <div class="form-group">
                        <p><strong>Sifat Operasi :</strong></p>
                        <p><?php echo $data_pasien->SIFAT_OPERASI; ?></p>
                      </div>  
                      <div class="form-group">
                        <p><strong>Antibiotik :</strong></p>
                        <p><?php echo $data_pasien->ANTIBIOTIK; ?></p>
                      </div> 
					  <div class="form-group">
                        <p><strong>Hasil Kultur (Swab Luka) :</strong></p>
                        <p><?php echo $data_pasien->HASIL_KULTUR; ?></p>
                      </div>
                      </div>                                                       
                    </div> <!-- col-md-6 -->                                            
                  </div>
				  <hr width="75%" align="center">
				  <nav>
					<ul class="pager">
						<li><a class="green" href="<?=site_url('c_dataido');?>"> <i class="fa fa-arrow-left"></i> Kembali </a></li>
						<li><a class="green" href="<?=site_url('c_dataido/downloadpdfido/'.$data_pasien->ID_IDO); ?>"> <i class="fa fa-print"></i> Cetak </a></li>
					</ul>
				  </nav>
				<br/>
				</div>
                </div>
              </div>
            </div>
          </div>
    </form>
    </div>
  </div> 
</section>              
<?php
  $this->load->view("layout/footer");
?>