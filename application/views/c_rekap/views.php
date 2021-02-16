<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
$(function() {
  $('#table-pasien').dataTable({
      "columnDefs": [
        { "orderable": false, "targets": 6 }
      ]
  });
 
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
<?php 
  if ($this->session->userdata('notification')) {
    echo $this->session->userdata('notification'); 
    $this->session->unset_userdata('notification');
  }  
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
	  <form method="POST" id="form_tanggal" role="form" action="<?= site_url('c_rekap/views'); ?>">   
      <div class="col-md-4">               
		<div class="box box-primary">
          <div class="box-body box-profile">
			<div class="box-header with-border text-center">
			  <h4 class="box-title text">Rentang Tanggal</h4>
			</div>
			<div class="form-group">
				<br/>
				<label for="tanggal_mulai_pengobatan">Tanggal Awal :</label>     
				<div class="input-group">
					<input type="text" class="form-control date_picker" name="tglawal" id="tglawal" value="<?= $tglawal; ?>" maxlength="10">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
			</div>
			<div class="form-group">
				<label for="tanggal_mulai_pengobatan">Tanggal Akhir :</label>     
				<div class="input-group">
					<input type="text" class="form-control date_picker" name="tglakhir" id="tglakhir" value="<?= $tglakhir; ?>" maxlength="10">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
			</div>
			<div class="form-group">
                <label for="Antibiotik">Ruang :</label>
				<select class="form-control" name="idrg" id="idrg" style="width: 100%;">
                    <option value="$idrg"><?= "(".$nmruang.")* Pilih Kembali untuk Mencari"; ?></option>
                    <?php 	
					foreach($data_ruang as $value2){
						echo '<option value="'.$value2->IDRG.'">'.$value2->NMRUANG.'</option>';
					}
					?>
                </select>
            </div>
			<div class="form-group">
                <label for="button"> </label>
                <button class="btn btn-primary btn-block" type="submit" id="btn-save"><i class="fa fa-search"></i> Cari</button>
            </div>
		  </div>
		</div>
		<div class="box box-primary">
          <div class="box-body box-profile">
			<nav>
				<ul class="pager">
				<li><a class="green" href="<?=site_url('');?>"> <i class="fa fa-arrow-left"></i> Kembali </a></li>
				<li><a class="green" href="<?=site_url('c_rekap/downloadpdfrb/'.$idrg.'/'.$tglawal.'/'.$tglakhir); ?>"> <i class="fa fa-print"></i> Cetak </a></li>
				</ul>
			</nav>
		  </div>
		</div>
	  </div> <!-- col-md-4 -->
	  </form>
	  <div class="col-md-4">   
        <div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>Jenis Operasi</strong></h4>
		  </div>
		  <div class="box-body">
		  <table class="table table-bordered">
			<thead>
              <tr>
                <th>NO</th>
                <th>JENIS OPERASI</th>
				<th>JUMLAH</th>
              </tr>
            </thead>
			<tbody>
			  <tr>
				<td>1</td>
				<td>BERSIH</td>
				<td><?= $this->M_rekap->count_jenisoperasi('B',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>BERSIH TERCEMAR</td>
				<td><?= $this->M_rekap->count_jenisoperasi('BT',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>3</td>
				<td>TERCEMAR</td>
				<td><?= $this->M_rekap->count_jenisoperasi('T',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>4</td>
				<td>KOTOR</td>
				<td><?= $this->M_rekap->count_jenisoperasi('K',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			</tbody>
		  </table>
		  </div>
        </div>
		<div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>Lama Operasi</strong></h4>
		  </div>
		  <div class="box-body">
		  <table class="table table-bordered">
			<thead>
              <tr>
                <th>NO</th>
                <th>LAMA OPERASI</th>
				<th>JUMLAH</th>
              </tr>
            </thead>
			<tbody>
			  <tr>
				<td>1</td>
				<td>0-60 Menit</td>
				<td><?= $this->M_rekap->count_lamaoperasi('0-60',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>60-300 Menit</td>
				<td><?= $this->M_rekap->count_lamaoperasi('60-300',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>3</td>
				<td>Lebih 300 Menit</td>
				<td><?= $this->M_rekap->count_lamaoperasi('>300',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			</tbody>
		  </table>
		  </div>
        </div>
		<div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>ASA Score</strong></h4>
		  </div>
		  <div class="box-body">
		  <table class="table table-bordered">
			<thead>
              <tr>
                <th>ASA SCORE</th>
				<th>JUMLAH</th>
              </tr>
            </thead>
			<tbody>
			  <tr>
				<td>1</td>
				<td><?= $this->M_rekap->count_asascore('1',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<td><?= $this->M_rekap->count_asascore('2',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>3</td>
				<td><?= $this->M_rekap->count_asascore('3',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>4</td>
				<td><?= $this->M_rekap->count_asascore('4',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>5</td>
				<td><?= $this->M_rekap->count_asascore('5',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			</tbody>
		  </table>
		  </div>
        </div>
		<div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>Risk Score</strong></h4>
		  </div>
		  <div class="box-body">
		  <table class="table table-bordered">
			<thead>
              <tr>
                <th>RISK SCORE</th>
				<th>JUMLAH</th>
              </tr>
            </thead>
			<tbody>
			  <tr>
				<td>0</td>
				<td><?= $this->M_rekap->count_riskscore('0',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>1</td>
				<td><?= $this->M_rekap->count_riskscore('1',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<td><?= $this->M_rekap->count_riskscore('2',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>3</td>
				<td><?= $this->M_rekap->count_riskscore('3',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			</tbody>
		  </table>
		  </div>
        </div>
	  </div><!-- col md-4 -->
	  <div class="col-md-4">
		<div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>Pemakaian Antibiotik</strong></h4>
		  </div>
		  <div class="box-body">
		  <table class="table table-bordered">
			<thead>
              <tr>
                <th>NO</th>
                <th>PEMAKAIAN</th>
				<th>JUMLAH</th>
              </tr>
            </thead>
			<tbody>
			  <tr>
				<td>1</td>
				<td>Profilaksis</td>
				<td><?= $this->M_rekap->count_ab('Propil',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>Terapi</td>
				<td><?= $this->M_rekap->count_ab('Terapi',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			</tbody>
		  </table>
		  </div>
        </div>
		
		<div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>Pemeriksaan Kultur</strong></h4>
		  </div>
		  <div class="box-body">
		  <table class="table table-bordered">
			<thead>
              <tr>
                <th>NO</th>
                <th>JENIS KULTUR</th>
				<th>JUMLAH</th>
              </tr>
            </thead>
			<tbody>
			  <tr>
				<td>1</td>
				<td>Darah</td>
				<td><?= $this->M_rekap->count_darah($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>Urine</td>
				<td><?= $this->M_rekap->count_urine($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>3</td>
				<td>Sputum</td>
				<td><?= $this->M_rekap->count_sputum($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>4</td>
				<td>Swab Luka</td>
				<td><?= $this->M_rekap->count_swabluka($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			</tbody>
		  </table>
		  </div>
        </div>
		
		<div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>HAIs</strong></h4>
		  </div>
		  <div class="box-body">
		  <table class="table table-bordered">
			<thead>
              <tr>
                <th>NO</th>
                <th>HAI</th>
				<th>JUMLAH</th>
              </tr>
            </thead>
			<tbody>
			  <tr>
				<td>1</td>
				<td>VAP</td>
				<td><?= $this->M_rekap->count_vap($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>IADP</td>
				<td><?= $this->M_rekap->count_iadp($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>3</td>
				<td>ISK</td>
				<td><?= $this->M_rekap->count_isk($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>4</td>
				<td>IDO</td>
				<td><?= $this->M_rekap->count_ido($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>5</td>
				<td>HAP</td>
				<td><?= $this->M_rekap->count_hap($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			</tbody>
		  </table>
		  </div>
        </div>
		
		<div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>Infeksi RS Lain</strong></h4>
		  </div>
		  <div class="box-body">
		  <table class="table table-bordered">
			<thead>
              <tr>
                <th>NO</th>
                <th>JENIS INFEKSI</th>
				<th>JUMLAH</th>
              </tr>
            </thead>
			<tbody>
			  <tr>
				<td>1</td>
				<td>PLEB</td>
				<td><?= $this->M_rekap->count_pleb($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>DEKUB</td>
				<td><?= $this->M_rekap->count_dekub($idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			</tbody>
		  </table>
		  </div>
        </div>
		
		<div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>Tindakan</strong></h4>
		  </div>
		  <div class="box-body">
		  <table class="table table-bordered">
			<thead>
              <tr>
                <th>NO</th>
                <th>ALAT</th>
				<th>JUMLAH PASIEN</th>
				<th>JUMLAH HARI</th>
              </tr>
            </thead>
			<tbody>
			  <tr>
				<td>1</td>
				<td>CVC</td>
				<td><?= $this->M_rekap->count_pasienalat('CVC',$idrg,$tglawal,$tglakhir); ?></td>
				<td><?= $this->M_rekap->count_haripasien('CVC',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>IV Line</td>
				<td><?= $this->M_rekap->count_pasienalat('IV Line ',$idrg,$tglawal,$tglakhir); ?></td>
				<td><?= $this->M_rekap->count_haripasien('IV Line ',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>3</td>
				<td>UC</td>
				<td><?= $this->M_rekap->count_pasienalat('UC',$idrg,$tglawal,$tglakhir); ?></td>
				<td><?= $this->M_rekap->count_haripasien('UC',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>4</td>
				<td>ETT Ventilator</td>
				<td><?= $this->M_rekap->count_pasienalat('ETT Ventilator',$idrg,$tglawal,$tglakhir); ?></td>
				<td><?= $this->M_rekap->count_haripasien('ETT Ventilator',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>5</td>
				<td>NGT</td>
				<td><?= $this->M_rekap->count_pasienalat('NGT',$idrg,$tglawal,$tglakhir); ?></td>
				<td><?= $this->M_rekap->count_haripasien('NGT',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			  <tr>
				<td>5</td>
				<td>Tirah Baring</td>
				<td><?= $this->M_rekap->count_pasienalat(' - (Tirah Baring)',$idrg,$tglawal,$tglakhir); ?></td>
				<td><?= $this->M_rekap->count_haripasien(' - (Tirah Baring)',$idrg,$tglawal,$tglakhir); ?></td>
			  </tr>
			</tbody>
		  </table>
		  </div>
        </div>	
	  </div><!-- col-md-4 2 -->
    </div>
  </div> <!-- row -->
</section>
  
<?php
  $this->load->view('layout/footer.php');
?>
