<?php $this->load->view('layout/header'); ?>

<script type="text/javascript">
$(document).ready(function() {
	$(".select2").select2();
	$('#subbagian').change(function () {
        var subbagian = $(this).val();
        console.log(subbagian);  
        $.ajax({
            url: "<?=base_url()?>beranda/get_dpjp_database_pasien",       
            async: false,
            type: "POST",    
            data: "subbagian="+subbagian,  
            dataType: "html",
            success: function(data) {
                $('#dpjp').html(data);  
            }
        })
    });
});

	

</script>

<section>
<div class="container-fluid">
			
	
	<?php echo form_open('beranda/database_pasien');?>
	<div class="box">
		<div class="box-body">
			<div class="form-group row">
			<label for="" class="col-sm-2 form-control-label">Bagian/Sub Bagian</label>
			<div class="col-sm-6">
                <input type="input" class="form-control" id="subbgian" name="subbagian" readonly="" value="<?php echo str_replace("%20", " ", $subbagian) ?>" />
                <!-- <select name="subbagian" id="subbagian" class="form-control select2" style="width:100%" required>
                    <option value="<?php echo $subbagian ?>" selected disabled><?php echo $nama_subbagian ?></option>
                        <?php
                         	// foreach ($subbagian as $row) {
                          //   echo '<option value="'.$row->ID.'">'.$row->NM_BAGIAN.'</option>';
                          //   }
                        ?>
                </select> -->
			</div>
		</div>

		<div class="form-group row">
			<label for="" class="col-sm-2 form-control-label">DPJP</label>
			<div class="col-sm-6">
                <input type="input" class="form-control" id="dpjp" name="dpjp" readonly="" value="<?php echo $nama_dokter ?>" />
                <!-- <select name="dpjp" id="dpjp" class="form-control select2" style="width:100%" required>
                    <option value="<?php echo $subbagian ?>" selected disabled><?php echo $nama_dokter ?></option>
                        <?php
                         	// foreach ($dpjp as $row) {
                          //   echo '<option value="'.$row->ID_DOKTER.'">'.$row->NM_DOKTER.'</option>';
                          //   }
                        ?>
                </select> -->
			</div>
		</div>

		<!-- <div class="form-group row">
			<div class="col-sm-11"></div>
			<div class="col-sm-1">
				<button class="btn btn-info" type="submit">Submit</button>
			</div>
		</div> -->

		</div>
		<?php echo form_close();?>
	</div>

	<div class="box">
		<div class="box-body">
			<?php
				if($data_operasi!=""){
					foreach ($data_operasi as $row) {
					echo '<div class="row">';
					echo '<div class="col-xs-12">';
					echo "<span>".$row->NAMA_PASIEN."/".$row->NO_RM."/".date_format(date_create($row->TANGGAL_LAHIR),'d-M-Y')."/".date_format(date_create($row->TANGGAL_RENCANA_OP),'d-M-Y')."</span>";
					echo "</div>";
					echo "</div>";

					echo "<div class=row>";
					echo "<div class=col-sm-12>";
					echo "<span>".$row->DIAGNOSA."</span>";
					echo "</div>";
					echo "</div>";

					echo "<div class=row>";
					echo "<div class=col-sm-12>";
					echo "<span>".$row->NAMA_TINDAKAN."</span>";
					echo "</div>";
					echo "</div>";

					echo "<div class=row>";
					echo "<div class=col-sm-12>";
					echo "<span>".$row->NM_RUANGAN."</span>";
					echo "</div>";
					echo "</div>";
					echo '<hr width="100%">';
				}
				} 
				
			?>
		</div>
	</div>

	<!-- <div class="box">
		<div class="box-body">
			<table ui-jp="dataTable" ui-options="{
				          sAjaxSource: '<?php echo site_url('beranda/get_data_operasi'); ?>',
				          aoColumns: [
				            { mData: 'nama' },
				            { mData: 'no_rm' },
				            { mData: 'tgl_lahir' },
				            { mData: 'tgl_rencana' },
				            { mData: 'diagnosa' },
				            { mData: 'tindakan' },
				            { mData: 'ruangan' }
				          ]
				        }" class="table table-striped b-t b-b">
						<thead>
							<tr>
								<th width="auto">Nama Pasien</th>
								<th width="auto">No. RM</th>
								<th width="auto">Tgl Lahir</th>
								<th width="auto">Tgl Rencana OP</th>
								<th width="auto">Diagnosa</th>
								<th width="auto">Tindakan</th>
								<th width="auto">Ruangan</th>
							</tr>
						</thead>
					</table>
		</div>
	</div> -->
	</div>
</section>

<?php $this->load->view('layout/footer'); ?>