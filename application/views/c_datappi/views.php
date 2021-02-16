<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
$(function() {
  $('#table-pasien').dataTable({
      "columnDefs": [
        { "orderable": false, "targets": 4}
      ]
  });
  
  $('.auto_search_by_noppi').autocomplete({
    serviceUrl: '<?php echo site_url();?>/rjcautocomplete/data_pasien_by_nocm',
    onSelect: function (suggestion) {
      $('#cari_no_cm').val(''+suggestion.no_cm);
      $('#no_medrec_baru').val(''+suggestion.no_medrec);
    }
  });
  
 
  $('#cari_tgl').datepicker({
    format: "yyyy-mm-dd",
    endDate: '0',
    autoclose: true,
    todayHighlight: true,
  });
    
}); 

function cek_search_per(val_search_per){
  if(val_search_per=='NO_REGISTER'){
    $("#cari_no_register").css("display", ""); // To unhide
  }

}
</script>
<?php 
  if ($this->session->userdata('notification')) {
    echo $this->session->userdata('notification'); 
    $this->session->unset_userdata('notification');
  }  
?>
<section class="content-header">
  <div class="small-box" style="background: #e4efe0">
    <div class="inner">
      <div class="container-fluid text-center" style="padding: 15px;">
        <?php echo form_open('C_datappi/search');?>
          <div class="form-inline">               
            <select name="search_per" id="search_per" class="form-control"  onchange="cek_search_per(this.value)">
              <option value="noregister">No IPD</option>
			  <option value="noppi">No PPI</option>
            </select>
            <!--auto_search_by_nocm-->
            <input type="search" maxlength="10" class="auto_search_by_nocm form-control" id="cari" name="cari" placeholder="Pencarian Nomor">
            <input type="hidden" class="form-control" id="no_medrec_baru" name="no_medrec_baru" >
            
            <button type="submit" class="btn btn-primary" type="button"><i class="fa fa-search"></i> Cari Pasien</button>
          </div>    
        <?php echo form_close();?>
      </div>
    </div>
  </div>
</section>
<?php if ($this->session->flashdata('success')) { 
		echo $this->session->flashdata('success'); ?>
<?php } ?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border text-center">
          <h4 class="box-title text-bold">DAFTAR PASIEN PPI</h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
          <table id="table-pasien" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Tgl. Sensus</th>
                <th>No. register</th>
				<th>ID PPI</th>
                <th>Nama</th>
                <th>Ruang</th>
				<th>Keg. Sensus</th>
                <th class="text-center" width="10%">Edit</th>
				<th class="text-center" width="10%">Insert</th>
				<th class="text-center" width="10%">Cetak</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($data_pasien != "") {
                  foreach($data_pasien as $row){
              ?>
                <tr>
                  <td><?php echo $row->TGL_SENSUS;?></td>
                  <td><?php echo $row->NO_REGISTER;?></td>
				  <td><?php echo $row->ID_SENSUS;?></td>
                  <td><?php echo $row->NAMA;?></td>
                  <td><?php echo $row->NMRUANG;?></td>
				  <td><?php echo $row->KEG_SENSUS;?></td>
				  <td class="text-center">
					<a href="<?php echo site_url('c_datappi/update/'.$row->NO_REGISTER.'/'.$row->ID_SENSUS); ?>" class="btn btn-primary btn-block btn-xs">Edit / Update Data PPI</a>
				  </td>
				  <td class="text-center">
                    <a href="<?php echo site_url('c_datappi/insert/'.$row->NO_REGISTER.'/'.$row->ID_SENSUS); ?>" class="btn btn-primary btn-block btn-xs">Insert Data PPI</a>
				  </td>
				  <td class="text-center">
					<a href="<?php echo site_url('c_datappi/cetak/'.$row->NO_REGISTER.'/'.$row->TGL_SENSUS); ?>" class="btn btn-primary btn-block btn-xs">Cetak Data PPI</a>
				  </td>
                </tr>
              <?php } 
                } 
              ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- row -->
      
  
</section>
  
<?php
  $this->load->view('layout/footer.php');
?>
