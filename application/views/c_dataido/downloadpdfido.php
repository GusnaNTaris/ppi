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



// IDENTITAS PASIEN IDO
$pdf->SetFont('times', 'B', '9');
$pdf->cell(0,0, 'Identitas Pasien IDO :', 0, 1);
$pdf->ln(2);
$pdf->SetFont('times', '', '8');
$html=	'<table cellspacing="0" bgcolor="#666666" cellpadding="0">
			<tr bgcolor="#ffffff">
				<td width="90">  NAMA</td>
				<td width="120">:  '.$data_pasien->NAMA.'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="90">  NO. REGISTER</td>
				<td width="120">:  '.$data_pasien->NO_REGISTER.'</td>
			</tr>';
/*			<tr bgcolor="#ffffff">
				<td width="80">Umur</td>';
					$tanggal = new DateTime(date('Y-m-d',strtotime($data_pasien->TGL_LAHIR))); 
                    $today = new DateTime('today');
                    echo $today->diff($tanggal)->y;
$html.=			'td width="80">  '.$today->diff($tanggal)->y.'</td>
			</tr>' */
$html.=		'<tr bgcolor="#ffffff">
				<td width="90">  JENIS KELAMIN</td>';
				if($data_pasien->SEX == 'L')
$html.=			'<td width="120">:  LAKI-LAKI</td>';
				if($data_pasien->SEX == 'P')
$html.=			'<td width="120">:  PEREMPUAN</td>';
$html.=		'</tr>
			<tr bgcolor="#ffffff">
				<td width="90">  TEMPAT LAHIR</td>
				<td width="120">:  '.$data_pasien->TMPT_LAHIR.'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td width="90">  TANGGAL LAHIR</td>
				<td width="120">:  '.$data_pasien->TGL_LAHIR.'</td>
			</tr>';
$html.=	'</table>';		
$pdf->writeHTML($html, true, 0, true, 0);									


//DATA PASIEN PPI	
$pdf->SetFont('times', 'B', '9');
$pdf->cell(0,0, 'Data Pasien PPI :', 0, 1);
$pdf->ln(2);
$pdf->SetFont('times', '', '8');										
$ido=	'<table cellspacing="1" bgcolor="#666666" cellpadding="1">
			<tr bgcolor="#ffffff">
				<td width="120">  Diagnosa Operasi</td>
				<td width="240">  '.$data_pasien->DIAGNOSA_OPERASI.'</td>
			</tr>
			<tr bgcolor="#ffffff">
                <td width="120">  Jenis Operasi</td>';
				if($data_pasien->JENIS_OPERASI == 'B')
$ido.=			'<td width="240">  Bersih</td>';
				if($data_pasien->JENIS_OPERASI == 'BT')
$ido.=			'<td width="240">  Bersih Tercampur</td>';
				if($data_pasien->JENIS_OPERASI == 'T')
$ido.=			'<td width="240">  Tercampur</td>';
				if($data_pasien->JENIS_OPERASI == 'K')
$ido.=			'<td width="240">  Kotor</td>';
$ido.=		'</tr>
			<tr bgcolor="#ffffff">
                <td width="120">  ASA Score</td>
				<td width="240">  '.$data_pasien->ASA_SCORE.'</td>
			</tr>
			<tr bgcolor="#ffffff">
                <td width="120">  Lama Operasi</td>
				<td width="240">  '.$data_pasien->LAMA_OPERASI.'&nbsp;Menit</td>
			</tr>
			<tr bgcolor="#ffffff">
                <td width="120">  Total Risk Score</td>
				<td width="240">  '.$data_pasien->TOTAL_RISK_SCORE.'</td>
            </tr>
			<tr bgcolor="#ffffff">
                <td width="120">  Tanggal IDO</td>
				<td width="240">  '.$data_pasien->TANGGAL_IDO.'</td>
            </tr>
			<tr bgcolor="#ffffff">
                <td width="120">  Sifat Operasi</td>
				<td width="240">  '.$data_pasien->SIFAT_OPERASI.'</td>
            </tr>
			<tr bgcolor="#ffffff">
                <td width="120">  Antibiotik</td>
				<td width="240">  '.$data_pasien->ANTIBIOTIK.'</td>
            </tr>
			<tr bgcolor="#ffffff">
                <td width="120">  Hasil Kultur</td>
				<td width="240">  '.$data_pasien->HASIL_KULTUR.'</td>
            </tr>';
$ido.=	'</table>';          
$pdf->writeHTML($ido, true, 0, true, 0, '');	

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

$pdf->Output('Data_Pasien_IDO_'.$data_pasien->ID_IDO.'.pdf', 'I');           

?>

