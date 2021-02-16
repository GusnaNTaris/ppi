<?php $this->load->view('layout/header'); ?>
<script type="text/javascript">
$('.carousel').carousel()
</script>
<section>
<div class="container-fluid">
	<label></label>
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	  <!-- Indicators -->
	  <ol class="carousel-indicators">
		<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		<li data-target="#carousel-example-generic" data-slide-to="1"></li>
		<li data-target="#carousel-example-generic" data-slide-to="2"></li>
	  </ol>

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner" role="listbox">
		<div class="item active">
		  <img src="asset/images/1.jpg" alt="photo1">
		  <div class="carousel-caption">
			<h3>1</h3>
			<p>Input Pasien PPI, IDO</p>
		  </div>
		</div>
		<div class="item">
		  <img src="asset/images/2.jpg" alt="photo2">
		  <div class="carousel-caption">
			<h3>2</h3>
			<p>Insert/Update Data PPI, IDO</p>
		  </div>
		</div>
		<div class="item">
		  <img src="asset/images/3.jpg" alt="photo3">
		  <div class="carousel-caption">
			<h3>3</h3>
			<p>Cetak Data</p>
		  </div>
		</div>
	  </div>

	  <!-- Controls -->
	  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	  </a>
	</div>
</div>
</section>
<?php $this->load->view('layout/footer'); ?>
