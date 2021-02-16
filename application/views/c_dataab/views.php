<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
$(function() {
  $('#table-pasien').dataTable({
      "columnDefs": [
        { "orderable": false, "targets": 2 }
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
  
  $('#form_tanggal').on('submit', function(e){       
         $("#btn-save").prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Mencari data...');
         $.ajax({    
           url: "<?php echo base_url().'c_dataab/views'; ?>",                       
           type: "POST",
           dataType: "HTML",
           data: $('#form_tanggal').serialize(),
           success: function(result) {
             console.log(result);
             $("#btn-save").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-search"></i> Sabar ya, data sedang dicari'); 
             swal("Sukses","Data Ditemukan.", "success"); 
           },
           error:function(event, textStatus, errorThrown) {
             $("#btn-save").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> Sabar ya, data sedang dicari');
             swal("Data yang anda input salah!",formatErrorMessage(event, errorThrown), "error"); 
           }  
         });          
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
	  <form method="POST" id="form_tanggal" role="form" action="<?= site_url('c_dataab/views'); ?>">   
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
				<li><a class="green" href="<?=site_url('c_dataab/downloadpdfab/'.$tglawal.'/'.$tglakhir); ?>"> <i class="fa fa-print"></i> Cetak </a></li>
				</ul>
			</nav>
		  </div>
		</div>
	  </div> <!-- col-md-4 -->
	  </form>
	  <div class="col-md-8">   
        <div class="box box-primary">
		  <div class="box-header with-border text-center">
			  <h4 class="box-title text"><strong>Tabel Data Antibiotik</strong></h4>
		  </div>
		  <div class="box-body">
		  <div class="table-responsive">
		  <table id="table-pasien" class="table table-bordered table-hover">
			<thead>
              <tr>
                <th>ID</th>
                <th>NAMA</th>
				<th>JUMLAH</th>
              </tr>
            </thead>
			<tbody>
			<?php 
			$sum = 0;
			foreach($data as $row)
			  {
				if ($row->IS_ACTIVE == '1') {
			?>
				<tr>
					<td><?= $row->ID_ANT;?></td>
					<td><?= $row->NAMA_ANT;?></td>
					<?php 	$coab = $this->M_dataab->count_antibiotik($row->ID_ANT,$tglawal,$tglakhir);
							$sum = $sum + $coab; ?>
					<td><?= $coab;?></td>
					</tr>
			<?php	
				}
			};
			?>
			</tbody>
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>TOTAL</th>
					<th><?= $sum; ?></th>
				</tr>
			</thead>
		  </table>
		  </div>
		  </div>
        </div>
	  </div>
    </div>
  </div> <!-- row -->
</section>
  
<?php
  $this->load->view('layout/footer.php');
?>
