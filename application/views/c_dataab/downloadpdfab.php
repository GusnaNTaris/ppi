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



// DATA ANTIBIOTIK
$pdf->SetFont('times', 'B', '9');
$pdf->cell(0,0, 'REKAP DATA ANTIBIOTIK', 0, 1);
$pdf->ln(2);
$pdf->SetFont('times', 'B', '8');
$pdf->cell(0,0, 'Rentang Tanggal '.$tglawal.' s/d '.$tglakhir, 0, 1);
$pdf->ln(2);
$pdf->SetFont('helvetica', '', '8');
$html=	'<table cellspacing="1" bgcolor="#666666" cellpadding="1">
			<thead>
				<tr bgcolor="#ffffff">
					<th width="50">ID</th>
					<th width="120">NAMA ANTIBIOTIK</th>
					<th width="50">JUMLAH</th>
				</tr>
			</thead>
			<tbody>';
				$sum = 0;
				foreach($data as $value)
				  {
					if (($value->IS_ACTIVE) == '1') {
$html.=			'<tr bgcolor="#ffffff">
					<td width="50">'.$value->ID_ANT.'</td>
					<td width="120">'.$value->NAMA_ANT.'</td>';
					//definisi count antibiotik dimasukkan dalam variabel.
					$coab = $this->M_dataab->count_antibiotik($value->ID_ANT,$tglawal,$tglakhir);
					$sum = $sum + $coab;
					
$html.=				'<td width="50">'.$coab.'</td>
				</tr>';
					}
				  }	
$html.=			'<tr bgcolor="#e6e6e6">
					<th width="50"> </th>
					<th width="120"><strong>TOTAL</strong></th>
					<th width="50"><strong>'.$sum.'</strong></th>
				</tr>
			</tbody>	
		</table>';		
$pdf->writeHTML($html, true, 0, true, 0);									

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

