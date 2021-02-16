<?php
$this->load->library('Pdf');
$pdf = new Pdf('P', 'inch', 'A4', true, 'UTF-8', false);

$pdf->SetHeaderMargin(40);
$pdf->SetTopMargin(40);
$pdf->setFooterMargin(1);
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetAuthor(' AUTHOR ');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);
$pdf->AddPage('P', array(145.7 , 235.3));
$pdf->SetTitle('Data IDO');
            $i=0;



// DATA KESELURUHAN
$pdf->SetFont('times', 'B', '10');
$pdf->cell(0,0, 'REKAP DATA KESELURUHAN', 0, 1);
$pdf->ln(2);
$pdf->SetFont('times', 'B', '8');
$pdf->cell(0,0, 'Ruang                   : '.$nmruang, 0, 1);
$pdf->ln(2);
$pdf->cell(0,0, 'Rentang Tanggal : '.$tglawal.' s/d '.$tglakhir, 0, 1);
$pdf->ln(4);
$pdf->SetFont('times', '', '7');
$html=	'<table cellspacing="1" bgcolor="#ffffff" cellpadding="1">
			<thead>
			<tr bgcolor="#666666">
				<th width="20" align="center"><strong>NO</strong></th>
				<th width="90" align="center"><strong>JENIS OPERASI</strong></th>
				<th width="40" align="center"><strong>JUMLAH</strong></th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20" align="center"><strong>NO</strong></th>
				<th width="90" align="center"><strong>ANTIBIOTIK</strong></th>
				<th width="40" align="center"><strong>JUMLAH</strong></th>
			</tr>
			</thead>
			<tbody>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  1</th>
				<th width="90">  Bersih</th>
				<th width="40">  '.$this->M_rekap->count_jenisoperasi('B',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  17</th>
				<th width="90">  Profilaksis</th>
				<th width="40">  '.$this->M_rekap->count_ab('Propil',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  2</th>
				<th width="90">  Bersih Tercemar</th>
				<th width="40">  '.$this->M_rekap->count_jenisoperasi('BT',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  18</th>
				<th width="90">  Terapi</th>
				<th width="40">  '.$this->M_rekap->count_ab('Terapi',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  3</th>
				<th width="90">  Tercemar</th>
				<th width="40">  '.$this->M_rekap->count_jenisoperasi('T',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20" bgcolor="#666666" align="center"><strong>NO</strong></th>
				<th width="90" bgcolor="#666666" align="center"><strong>HAIs</strong></th>
				<th width="40" bgcolor="#666666" align="center"><strong>JUMLAH</strong></th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  4</th>
				<th width="90">  Kotor</th>
				<th width="40">  '.$this->M_rekap->count_jenisoperasi('K',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  19</th>
				<th width="90">  VAP</th>
				<th width="40">  '.$this->M_rekap->count_vap($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  
			  <tr bgcolor="#666666">
				<th width="20" align="center"><strong>NO</strong></th>
				<th width="90" align="center"><strong>LAMA OPERASI</strong></th>
				<th width="40" align="center"><strong>JUMLAH</strong></th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20" bgcolor="#e6e6e6">  20</th>
				<th width="90" bgcolor="#e6e6e6">  IADP</th>
				<th width="40" bgcolor="#e6e6e6">  '.$this->M_rekap->count_iadp($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  5</th>
				<th width="90">  0-60 Menit</th>
				<th width="40">  '.$this->M_rekap->count_lamaoperasi('0-60',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  21</th>
				<th width="90">  ISK</th>
				<th width="40">  '.$this->M_rekap->count_isk($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  6</th>
				<th width="90">  60-300 Menit</th>
				<th width="40">  '.$this->M_rekap->count_lamaoperasi('60-300',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  22</th>
				<th width="90">  IDO</th>
				<th width="40">  '.$this->M_rekap->count_ido($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  7</th>
				<th width="90">  Lebih Dari 300 Menit</th>
				<th width="40">  '.$this->M_rekap->count_lamaoperasi('>300',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  23</th>
				<th width="90">  HAP</th>
				<th width="40">  '.$this->M_rekap->count_hap($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  
			  <tr bgcolor="#666666">
				<th width="20" align="center"><strong>NO</strong></th>
				<th width="90" align="center"><strong>ASA SCORE</strong></th>
				<th width="40" align="center"><strong>JUMLAH</strong></th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20" align="center"><strong>NO</strong></th>
				<th width="90" align="center"><strong>INFEKSI RS LAIN</strong></th>
				<th width="40" align="center"><strong>JUMLAH</strong></th>
			 </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  8</th>
				<th width="90">  1</th>
				<th width="40">  '.$this->M_rekap->count_asascore('1',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  24</th>
				<th width="90">  PLEB</th>
				<th width="40">  '.$this->M_rekap->count_pleb($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  9</th>
				<th width="90">  2</th>
				<th width="40">  '.$this->M_rekap->count_asascore('2',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  25</th>
				<th width="90">  DEKUB</th>
				<th width="40">  '.$this->M_rekap->count_dekub($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  10</th>
				<th width="90">  3</th>
				<th width="40">  '.$this->M_rekap->count_asascore('3',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20" bgcolor="#666666" align="center"><strong>NO</strong></th>
				<th width="90" bgcolor="#666666" align="center"><strong>PEMERIKSAAN KULTUR</strong></th>
				<th width="40" bgcolor="#666666" align="center"><strong>JUMLAH</strong></th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  11</th>
				<th width="90">  4</th>
				<th width="40">  '.$this->M_rekap->count_asascore('4',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  26</th>
				<th width="90">  Darah</th>
				<th width="40">  '.$this->M_rekap->count_darah($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  12</th>
				<th width="90">  5</th>
				<th width="40">  '.$this->M_rekap->count_asascore('5',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  26</th>
				<th width="90">  Urine</th>
				<th width="40">  '.$this->M_rekap->count_urine($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  
			  <tr bgcolor="#666666">
				<th width="20" align="center"><strong>NO</strong></th>
				<th width="90" align="center"><strong>RISK SCORE</strong></th>
				<th width="40" align="center"><strong>JUMLAH</strong></th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20" bgcolor="#e6e6e6">  27</th>
				<th width="90" bgcolor="#e6e6e6">  Sputum</th>
				<th width="40" bgcolor="#e6e6e6">  '.$this->M_rekap->count_sputum($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  13</th>
				<th width="90">  0</th>
				<th width="40">  '.$this->M_rekap->count_riskscore('0',$idrg,$tglawal,$tglakhir).'</th>
				
				<th width="30" bgcolor="#ffffff" >&nbsp;</th>
				
				<th width="20">  28</th>
				<th width="90">  Swab Luka</th>
				<th width="40">  '.$this->M_rekap->count_swabluka($idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  14</th>
				<th width="90">  1</th>
				<th width="40">  '.$this->M_rekap->count_riskscore('1',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  15</th>
				<th width="90">  2</th>
				<th width="40">  '.$this->M_rekap->count_riskscore('2',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  16</th>
				<th width="90">  3</th>
				<th width="40">  '.$this->M_rekap->count_riskscore('3',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			</tbody>
		  </table>';
$pdf->writeHTML($html, true, 0, true, 0, '');	

$pdf->SetFont('times', 'B', '8');
$pdf->cell(0,0, 'Tabel Tindakan :', 0, 1);
$pdf->ln(2);
$pdf->SetFont('times', '', '7');
$html=	'<table cellspacing="1" bgcolor="#ffffff" cellpadding="1">
			<thead>
			<tr bgcolor="#666666">
				<th width="20" align="center"><strong>NO</strong></th>
				<th width="90" align="center"><strong>TINDAKAN</strong></th>
				<th width="70" align="center"><strong>JUMLAH PASIEN</strong></th>
				<th width="70" align="center"><strong>JUMLAH HARI</strong></th>
			</tr>
			</thead>
			<tbody>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  1</th>
				<th width="90">  CVC</th>
				<th width="70">  '.$this->M_rekap->count_pasienalat('CVC',$idrg,$tglawal,$tglakhir).'</th>
				<th width="70">  '.$this->M_rekap->count_haripasien('CVC',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  2</th>
				<th width="90">  IV Line</th>
				<th width="70">  '.$this->M_rekap->count_pasienalat('IV Line ',$idrg,$tglawal,$tglakhir).'</th>
				<th width="70">  '.$this->M_rekap->count_haripasien('IV Line ',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  3</th>
				<th width="90">  UC</th>
				<th width="70">  '.$this->M_rekap->count_pasienalat('UC',$idrg,$tglawal,$tglakhir).'</th>
				<th width="70">  '.$this->M_rekap->count_haripasien('UC',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  4</th>
				<th width="90">  ETT Ventilator</th>
				<th width="70">  '.$this->M_rekap->count_pasienalat('ETT Ventilator',$idrg,$tglawal,$tglakhir).'</th>
				<th width="70">  '.$this->M_rekap->count_haripasien('ETT Ventilator',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  5</th>
				<th width="90">  NGT</th>
				<th width="70">  '.$this->M_rekap->count_pasienalat('NGT',$idrg,$tglawal,$tglakhir).'</th>
				<th width="70">  '.$this->M_rekap->count_haripasien('NGT',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			  <tr bgcolor="#e6e6e6">
				<th width="20">  6</th>
				<th width="90">  Tirah Baring</th>
				<th width="70">  '.$this->M_rekap->count_pasienalat(' - (Tirah Baring)',$idrg,$tglawal,$tglakhir).'</th>
				<th width="70">  '.$this->M_rekap->count_haripasien(' - (Tirah Baring)',$idrg,$tglawal,$tglakhir).'</th>
			  </tr>
			</tbody>
		</table>';
$pdf->writeHTML($html, true, 0, true, 0, '');	

$footer='<p>&nbsp;</p>
		<p>&nbsp;</p>
		<table width="100%" border="0">
		  <tr>
			<td width="56%">&nbsp;</td>
			<td width="44%" align="center">
			 Bandung, '.date("d-m-Y").'<br />    
		     Ttd,<br />
			<p>&nbsp;</p>
			  (________________)
			  
			</td>
		  </tr>
		</table>';
$pdf->writeHTML($footer, true, 0, true, 0, '');

$pdf->Output('Data_Antibiotik.pdf', 'I');           

?>

