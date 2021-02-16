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
  });
  
	
</script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
	
    <form method="POST" id="form_ppi" role="form">                     
          <div class="row">
            <div class="col-md-4">               
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url("asset/images/patient.png");?>" alt="<?php echo $identitas_pasien->NAMA; ?>">
                  <h3 class="profile-username text-center"><?php echo $identitas_pasien->NAMA; ?></h3> 
                  <p class="text-muted text-center">No. RM : <?php echo $identitas_pasien->NO_MEDREC; ?></p>
                  <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                      <b>NO REGISTER</b> <a class="pull-right"><?php echo $identitas_pasien->NO_REGISTER; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>TTL</b> <a class="pull-right"><?php echo $identitas_pasien->TMPT_LAHIR.' / '.$identitas_pasien->TGL_LAHIR; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Dx. Medis</b> <a class="pull-right"><?php echo $identitas_pasien->DIAGNOSA; ?></a>
                    </li>
					<li class="list-group-item">
                      <b>Ruang</b> <a class="pull-right"><?php echo $identitas_pasien->NMRUANG; ?></a>
                    </li>
					<li class="list-group-item">
                      <b>Tanggal Masuk</b> <a class="pull-right"><?php echo $identitas_pasien->TGLMASUKRG; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Jenis Kelamin</b> <a class="pull-right"><?php if($identitas_pasien->SEX == 'L') echo 'Laki-Laki';if($identitas_pasien->SEX == 'P') echo 'Perempuan'; ?></a>
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
                  <p align="center"><strong> DATA PASIEN HEALTHCARE ASSOCIATION INFECTIONS </strong></p>
				  <hr width="75%" align="center">
                </div>
                <div class="box-body">                
                  <div class="row">
                    <div class="col-md-12"> 
					<?php foreach($data as $data_pasien){ ?>
                        <p><strong>Tanggal Sensus :</strong> <?php echo date('j F Y',strtotime($data_pasien->TGL_SENSUS)); ?></p>     
                        <p><strong>Keg. Sensus / Alat :</strong> <?php echo $data_pasien->KEG_SENSUS.' / '.$data_pasien->ALAT;?></p>						
						<table class="table table-bordered">
							<thead>
								<th scope="col">Antibiotik</th>
								<th scope="col">Jenis Kultur HAIs</th>
								<th scope="col">Jenis Kuman / Tanggal</th>
								<th scope="col">Infeksi RS / Tanggal</th>
								<th scope="col">Transmisi</th>
								<th scope="col">Hasil Rontgen / Tanggal</th>
							</thead>
							<tbody>
								<td><?= $data_pasien->ANTIBIOTIK; ?></td>
								<td>
								<?php
								if (($data_pasien->DARAH) == '1') 
									echo "<p>Darah</p>";
								if (($data_pasien->SPUTUM) == '1') 
									echo "<p>Sputum</p>";
								if (($data_pasien->SWAB_LUKA) == '1') 
									echo "<p>Swab Luka</p>";
								if (($data_pasien->URINE) == '1') 
									echo "<p>Urine</p>";?>
								</td>
								<td><?= $data_pasien->JENIS_KUMAN.' / '.date('j F Y',strtotime($data_pasien->TGL_KUMAN)); ?></td>
								<td><?php
								if (($data_pasien->VAP) == '1') 
									echo "<p>VAP / ".date('j F Y',strtotime($data_pasien->TGL_VAP))."</p>";
								if (($data_pasien->HAP) == '1') 
									echo "<p>HAP / ".date('j F Y',strtotime($data_pasien->TGL_HAP))."</p>";
								if (($data_pasien->IDO) == '1') 
									echo "<p>IDO / ".date('j F Y',strtotime($data_pasien->TGL_IDO))."</p>";
								if (($data_pasien->ISK) == '1') 
									echo "<p>ISK / ".date('j F Y',strtotime($data_pasien->TGL_ISK))."</p>";
								if (($data_pasien->IADP) == '1') 
									echo "<p>IADP / ".date('j F Y',strtotime($data_pasien->TGL_IADP))."</p>";
								if (($data_pasien->DEKUB) == '1') 
									echo "<p>DEKUB / ".date('j F Y',strtotime($data_pasien->TGL_DEKUB))."</p>";
								if (($data_pasien->PLEB) == '1') 
									echo "<p>PLEB / ".date('j F Y',strtotime($data_pasien->TGL_PLEB))."</p>";?>
								</td>
								<td> <?php echo $data_pasien->TRANSMISI;?></td>
								<?php
								if ((($data_pasien->HASIL_RONTGEN)&&($data_pasien->TGL_RONTGEN)) != "") {?>
								<td><?= $data_pasien->HASIL_RONTGEN.' / '.date('j F Y',strtotime($data_pasien->TGL_RONTGEN)); ?></td>
								<?php } else { ?>
								<td> - </td>
								<?php } ?>
							</tbody>
						</table>
					<hr width="75%" align="center">
					<br/>
					<?php } ?>
                    </div> <!-- col-md-6 -->   
                  </div>
				  <hr width="75%" align="center">
				  <nav>
					<ul class="pager">
						<li><a class="green" href="<?=site_url('c_datappi/');?>"> <i class="fa fa-arrow-left"></i> Kembali </a></li>
						<li><a class="green" href="<?=site_url('c_datappi/downloadpdfppi/'.$data_pasien->NO_REGISTER.'/'.$data_pasien->TGL_SENSUS); ?>"> <i class="fa fa-print"></i> Cetak </a></li>
						<!-- php echo site_url('c_datappi/cetakk/'.$data_pasien->ID_SENSUS);  -->
					</ul>
				  </nav>
				<br/>
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