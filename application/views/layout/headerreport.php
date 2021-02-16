<?php 
if(!isset($_GET['rel'])){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<link rel="shortcut icon" href="<?php echo site_url('asset/images/logo.jpg'); ?>" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PPI</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/css/jquery-ui.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/css/sweetalert.css'); ?>">    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo site_url('asset/font/font-awesome/css/font-awesome.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/AdminLTE.min.css'); ?>">
    <!-- Choose a skin from the css/skins to reduce the load. -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/skins/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/css/jquery.autocomplete.css'); ?>">
    <!-- Morris charts -->
    <link rel="stylesheet" href="<?php echo site_url('asset/plugins/morris/morris.css'); ?>">
    <style type="text/css">
      .load_input {
          background: white url("<?php echo site_url('asset/images/ui-anim_basic_16x16.gif'); ?>") center center no-repeat;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;   
      } 
    </style>
    
	<!-- jQuery 2.1.4 -->
    <script src="<?php echo site_url('asset/js/jQuery-2.1.4.min.js'); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo site_url('asset/js/jquery-ui.min.js'); ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
		$.widget.bridge('uibutton', $.ui.button);
		var baseurl = "<?php print base_url(); ?>";
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo site_url('asset/js/bootstrap.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo site_url('asset/js/app.min.js'); ?>"></script>
    <script src="<?php echo site_url('asset/plugins/jquery.jclock.js'); ?>"></script>
    <script src="<?php echo site_url('asset/plugins/jquery.autocomplete.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo site_url('asset/plugins/datepicker/datepicker3.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
    <script src="<?php echo site_url('asset/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
    <!-- <script src="<?php echo site_url('asset/plugins/jquery-validation/js/jquery.validate.min.js'); ?>"></script> -->
    <link rel="stylesheet" href="<?php echo site_url('asset/plugins/timepicker/bootstrap-timepicker.css'); ?>">
    <script src="<?php echo site_url('asset/plugins/timepicker/bootstrap-timepicker.js'); ?>"></script>
    <script src="<?php echo site_url('asset/js/hmis.js'); ?>"></script>

    <!-- ChartJS 1.0.1 -->
    <script src="<?php echo site_url('asset/plugins/chartjs/Chart.min.js'); ?>"></script> 

    <!-- Morris.js charts -->
    <script src="<?php echo site_url('asset/plugins/morris/morris.min.js'); ?>"></script> 
    <script src="<?php echo site_url('asset/plugins/morris/raphael-min.js'); ?>"></script> 

    <!-- High charts -->
    <script src="<?php echo site_url('asset/highcharts/code/highcharts.js'); ?>"></script>
    <script src="<?php echo site_url('asset/highcharts/code/modules/drilldown.js'); ?>"></script> 
    <script src="<?php echo site_url('asset/highcharts/code/modules/data.js'); ?>"></script> 
	
	<!-- Mask Money -->
	<script src="<?php echo site_url('asset/js/jquery.maskMoney.js'); ?>" type="text/javascript"></script>
	

	<!-- Data Table -->
	<link rel="stylesheet" href="<?php echo site_url('asset/css/smoothness/jquery-ui.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('asset/css/dataTables.jqueryui.css'); ?>">
	<script src="<?php echo site_url('asset/js/jquery.dataTables.js'); ?>"></script>
	<script src="<?php echo site_url('asset/js/dataTables.jqueryui.js'); ?>"></script>
  <script src="<?php echo site_url('asset/js/sweetalert.min.js'); ?>"></script>  
	
	<!-- iCheck -->
	
	<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/all.css'); ?>">
	<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
	

	<!-- SELECT2 -->
	<link rel="stylesheet" href="<?php echo site_url('asset/plugins/select2/select2.min.css'); ?>">
	<script src="<?php echo site_url('asset/plugins/select2/select2.full.min.js'); ?>"></script>
	<!-- date range picker -->
  <script src="<?php echo site_url('asset/plugins/daterangepicker/moment.min.js'); ?>"></script>
  <script src="<?php echo site_url('asset/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <script type="text/javascript">
    function formatErrorMessage(jqXHR, exception)
    {
        if (jqXHR.status === 0) {
           return ('Not connected.\nPlease verify your network connection.');
        } else if (jqXHR.status == 404) {
            return ('The requested page not found.');
        }  else if (jqXHR.status == 401) {
            return ('Sorry!! You session has expired. Please login to continue access.');
        } else if (jqXHR.status == 500) {
            return ('Internal Server Error.');
        } else if (exception === 'parsererror') {
            return ('Requested JSON parse failed.');
        } else if (exception === 'timeout') {
            return ('Time out error.');
        } else if (exception === 'abort') {
            return ('Ajax request aborted.');
        } else {
            return ('Unknown error occured. Please try again.');
        }
    }
  </script>

	<div class="container">
	<div class="row-fluid">
	<div class="span12">
	  <table width="100%" border="0" class="">
		<tr>
		  <td width="11%" height="162" align="center"><img src="<?=base_url();?>asset/images/logos/logo_sumsell.png" /></td>
		  <td width="77%" align="center"><h2></h2>
			<h3 align="center"><strong>RSUP DR. MOHAMMAD HOESIN</strong></h3>
			<p align="center">Alamat : Jl. Jend. Sudirman Km 3.5 Telp. (0711) 354088 - Fax. (0711) 351318</p>
			<p align="center"><strong>===========================================================================</strong></p></td>
			 
		  <td width="12%" align="center"><img src="<?=base_url();?>asset/images/logos/baktihusada.png" /></td>
		
		</tr>
		
	  </table>
	  
	</div>
	</div>
	
<?php 
}
?>
