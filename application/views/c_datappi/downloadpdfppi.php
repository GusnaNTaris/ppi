<?php
$this->load->library('Pdf');
$pdf = new Pdf('P', 'inch', 'A4', true, 'UTF-8', false);

$pdf->SetHeaderMargin(40);
$pdf->SetTopMargin(40);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetAuthor(' AUTHOR ');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);
$pdf->AddPage('P', array(145.7 , 235.3));
$pdf->SetTitle('Data HAIs');
            $i=0;


// IDENTITAS PASIEN HAIs
$pdf->SetFont('times', 'B', '9');
$pdf->cell(0,0, 'Identitas Pasien HAIs :', 0, 1);
$pdf->ln(2);
$pdf->SetFont('times', '', '8');
$html=	'<table cellspacing="0" bgcolor="#666666" cellpadding="0">
			<tr bgcolor="#ffffff">
				<td width="90">  NAMA</td>
				<td width="120">:&nbsp;'.$identitas_pasien->NAMA.'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="90">  NO. RM</td>
				<td width="120">:&nbsp;'.$identitas_pasien->NO_MEDREC.'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="90">  TTL</td>
				<td width="230">:&nbsp;'.$identitas_pasien->TMPT_LAHIR.' / '.$identitas_pasien->TGL_LAHIR.'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="90">  DIAGNOSA</td>
				<td width="120">: '.$identitas_pasien->DIAGNOSA.'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="90">  RUANG / TGL MASUK</td>
				<td width="230">: '.$identitas_pasien->NMRUANG.' / '.$identitas_pasien->TGLMASUKRG.'</td>
			</tr>';
$html.=		'<tr bgcolor="#ffffff">
				<td width="90">  JENIS KELAMIN</td>';
				if($identitas_pasien->SEX == 'L')
$html.=			'<td width="120">:&nbsp;LAKI-LAKI</td>';
				if($identitas_pasien->SEX == 'P')
$html.=			'<td width="120">:&nbsp;PEREMPUAN</td>';
$html.=	'	</tr>
		</table>';		
$pdf->writeHTML($html, true, 0, true, 0);									


//DATA PASIEN PPI	
$pdf->SetFont('times', 'B', '9');
$pdf->cell(0,0, 'Data Sensus Harian Pasien HAIs', 0, 1);
$pdf->ln(2);
$pdf->SetFont('times', '', '8');	
foreach($data as $data_pasien){
	
$html=	'<table cellspacing="1" bgcolor="#ffffff" cellpadding="1">	
			<tr bgcolor="#ffffff">
				<td width="90"><strong>  Tanggal Sensus</strong></td>
				<td width="140">:  '.date('j F Y',strtotime($data_pasien->TGL_SENSUS)).'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="90"><strong>  Kegiatan Sensus / Alat</strong></td>
				<td width="140">:  '.$data_pasien->KEG_SENSUS.' / '.$data_pasien->ALAT.'</td>
			</tr>
		 </table>';
$pdf->writeHTML($html, true, 0, true, 0);	

$html=	'<table cellspacing="1" bgcolor="#666666" cellpadding="1">
			<tr bgcolor="#ffffff">
				<th align="center" width="60"><strong>Antibiotik</strong></th>
				<th align="center" width="50"><strong>Jenis Kultur HAIs</strong></th>
				<th align="center" width="60"><strong>Jenis Kuman / Tanggal</strong></th>
				<th align="center" width="60"><strong>Infeksi RS / Tanggal</strong></th>
				<th align="center" width="60"><strong>Transmisi</strong></th>
				<th align="center" width="60"><strong>Hasil Rontgen / Tanggal</strong></th>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="60">'.$data_pasien->ANTIBIOTIK.'</td>
				<td width="50">';
				if (($data_pasien->DARAH) == '1'){ 
$html.=				'<p>Darah</p>';
				}
				if (($data_pasien->SPUTUM) == '1'){
$html.=				'<p>Sputum</p>';
				}
				if (($data_pasien->SWAB_LUKA) == '1'){
$html.=				'<p>Swab Luka</p>';
				}
				if (($data_pasien->URINE) == '1'){
$html.=				'<p>Urine</p>';
				}
$html.=			'</td>
				<td width="60">'.$data_pasien->JENIS_KUMAN.' / '.date('j F Y',strtotime($data_pasien->TGL_KUMAN)).'</td>
				<td width="60">';
				if (($data_pasien->VAP) == '1'){
$html.=				'<p>VAP / '.date('j F Y',strtotime($data_pasien->TGL_VAP)).'</p>';
				}if (($data_pasien->HAP) == '1'){
$html.=				'<p>HAP / '.date('j F Y',strtotime($data_pasien->TGL_HAP)).'</p>';
				}if (($data_pasien->IDO) == '1'){
$html.=				'<p>IDO / '.date('j F Y',strtotime($data_pasien->TGL_IDO)).'</p>';
				}if (($data_pasien->ISK) == '1'){
$html.=				'<p>ISK / '.date('j F Y',strtotime($data_pasien->TGL_ISK)).'</p>';
				}if (($data_pasien->IADP) == '1'){
$html.=				'<p>IADP / '.date('j F Y',strtotime($data_pasien->TGL_IADP)).'</p>';
				}if (($data_pasien->DEKUB) == '1'){ 
$html.=				'<p>DEKUB / '.date('j F Y',strtotime($data_pasien->TGL_DEKUB)).'</p>';
				}if (($data_pasien->PLEB) == '1'){
$html.=				'<p>PLEB / '.date('j F Y',strtotime($data_pasien->TGL_PLEB)).'</p>';
				}
$html.=			'</td>
				<td width="60">'.$data_pasien->TRANSMISI.'</td>
				<td width="60">'.$data_pasien->HASIL_RONTGEN.' / '.date('j F Y',strtotime($data_pasien->TGL_RONTGEN)).'</td>
			</tr>
		</table>';
$pdf->writeHTML($html, true, 0, true, 0);
};	 


$footer='<p>&nbsp;</p>
		<p>&nbsp;</p>
		<table width="100%" border="0">
		  <tr>
			<td width="56%">&nbsp;</td>
			<td width="44%" align="center">
			 Bandung, '.date("d F Y").'<br />    
		     Ttd,<br />
			<p>&nbsp;</p>
			  (________________)
			  
			</td>
		  </tr>
		</table>';
$pdf->writeHTML($footer, true, 0, true, 0, '');
	
$pdf->Output('Data_Pasien_HAIs_'.$data_pasien->NO_REGISTER.'.pdf', 'I');           

?>

