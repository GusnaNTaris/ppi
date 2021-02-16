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
  
	$('#form_tambahab').on('submit', function(e){       
         $("#btn-save").prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Menambah Antibiotik...');
         $.ajax({    
           url: "<?php echo base_url().'C_setorab/tambah'; ?>",                       
           type: "POST",
           dataType: "HTML",
           data: $('#form_tambahab').serialize(),
           success: function(result) {
             console.log(result);
             $("#btn-save").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-search"></i> Sabar ya, data sedang ditambah'); 
             swal("Sukses","Data Ditambahkan.", "success"); 
			 location.reload(); 
           },
           error:function(event, textStatus, errorThrown) {
             $("#btn-save").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> Sabar ya, data sedang ditambah');
             swal("Data yang anda input salah!",formatErrorMessage(event, errorThrown), "error"); 
           }  
         }); 
		e.preventDefault();
     });
	 
	$('#form_updateab').on('submit', function(e){       
         $("#btn-update").prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Mengupdate data Antibiotik...');
         $.ajax({    
           url: "<?php echo base_url().'C_setorab/update'; ?>",                       
           type: "POST",
           dataType: "HTML",
           data: $('#form_updateab').serialize(),
           success: function(result) {
             console.log(result);
             $("#btn-update").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-search"></i> Sabar ya, data sedang diupdate'); 
             swal("Sukses","Data Diupdate.", "success"); 
			 location.reload(); 
           },
           error:function(event, textStatus, errorThrown) {
             $("#btn-update").prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-paper-plane"></i> Sabar ya, data sedang diupdate');
             swal("Data yang anda input salah hehe!",formatErrorMessage(event, errorThrown), "error"); 
           }  
         }); 
		e.preventDefault();
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
      <div class="col-md-4">         
		<form method="POST" id="form_tambahab" role="form">
		<div class="box box-primary">		
          <div class="box-body box-profile">
			<div class="box-header with-border text-center">
			  <h4 class="box-title text">Tambah Antibiotik</h4>
			</div>
			<br/>
			<div class="form-group">
				<label for="namaantibiotik">Nama Antibiotik :</label>     
				<input type="text" class="form-control" name="antibiotik" id="antibiotik" value="">	
			</div>
			<div class="form-group">
                <label for="button"> </label>
                <button class="btn btn-primary btn-block" type="submit" id="btn-save"><i class="fa fa-paper-plane-o"></i> Tambah</button>
            </div>
		  </div>
		</div>
		</form>
		<form method="POST" id="form_updateab" role="form" > 
		<div class="box box-primary">
          <div class="box-body box-profile">
			<div class="box-header with-border text-center">
			  <h4 class="box-title text">Update Antibiotik</h4>
			</div>
			<div class="form-group">
				<br/>
				<label for="namaantibiotik">Nama Antibiotik :</label>  
				<select class="form-control" name="idantibio" id="idantibio" style="width: 100%;">
					<option value="">-- Silahkan Pilih Antibiotik--</option>
					<?php
					foreach($data_ab as $rowab)
					{
						echo '<option value="'.$rowab->ID_ANT.'">'.$rowab->NAMA_ANT.'</option>';				
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="isactive">Aktif/Nonaktif :</label>
				<select class="form-control" name="isactiveab" id="isactiveab" style="width: 100%;">
					<option value="">-- Silahkan Pilih Keadaan--</option>
					<option value="0">Nonaktif</option>
					<option value="1">Aktif</option>
				</select>
			</div>
			<div class="form-group">
                <label for="button"> </label>
                <button class="btn btn-primary btn-block" type="submit" id="btn-update"><i class="fa fa-paper-plane-o"></i> Update</button>
            </div>
		  </div>
		</div>
		</form>
	  </div> <!-- col-md-4 -->
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
					<th>KEADAAN</th>
				  </tr>
				</thead>
				<tbody>
				<?php 
				foreach($data_ab as $row)
				  {
				?>
					<tr>
						<td><?= $row->ID_ANT;?></td>
						<td><?= $row->NAMA_ANT;?></td>
						<?php if ($row->IS_ACTIVE == 1){ ?>
						<td>AKTIF</td>
						<?php } if ($row->IS_ACTIVE == 0) { ?>
						<td>NONAKTIF</td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
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
