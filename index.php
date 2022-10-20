<?php

require_once 'barcode.php';
require_once 'Conexion.php';
require_once ('./fpdf184/fpdf.php');

function addTable($pdf,$data,) {
    $pdf->setTitle("Rotulos grupo exito");
    $pdf->AddPage('portrait',array(100,80));
    $pdf->SetFont('Arial','B',8);
    $pdf->SetFillColor(57,165,2134);
    $code =$data->no_guia ;
    $y = $pdf->GetY();
    $pdf->Image('fotos/text_logo.png',13,6,-2400).$pdf->cell(110,5,"",0,0,'C') .
    $pdf->SetFont('Arial','B',11) .
    $pdf->cell(70,5,"",0,0,'C');
    $pdf->Image('fotos/exito.JPG',56,5,-250).$pdf->cell(110,5,"",0,1,'C') ;
    $pdf->Ln(1);
    $pdf->write(5,"Generado por: ".utf8_decode($data->generador).$pdf->SetFont('Arial','B',8));
    $pdf->SetFont('Arial','B',3);
    // $pdf->Cell(3,5,"", 0, 1, 'C');
    $pdf->Image('fotos/borde.JPG',10,23,-250) ;
    $pdf->Ln(12);
    $pdf->Cell(60,5,utf8_decode($data->direccion_origen), 0, 1, 'C');
    $pdf->Image('fotos/SEGUNDO.JPG',10,33,-250) ;
    $pdf->Ln(4);
    $pdf->Cell(20,5,utf8_decode($data->ciudad_origen). "/" .utf8_decode($data->departamento_origen),0,0,'C');
    $pdf->Cell(22,5,utf8_decode($data->celular_origen), 0, 0, 'C');
    $pdf->Cell(10,5,utf8_decode($data->nombre_destinatario), 0, 1, 'C');
    $pdf->Ln(4);
    $pdf->Image('fotos/desti.JPG',10,41,-250) ;
    $pdf->Cell(60,5,utf8_decode($data->direccion_destino), 0, 1, 'C');
    $pdf->Image('fotos/largo.JPG',10,50,-250) ;
    $pdf->Ln(3);
    $pdf->Cell(20,5,utf8_decode($data->ciudad_destino). "/" .utf8_decode($data->departamento_destino),0,0,'C');
    $pdf->Cell(22,5,utf8_decode($data->celular_destino), 0, 0, 'C');
    $pdf->Cell(10,5,utf8_decode("Importante"), 0, 1, 'C');
    barcode('codigos/'.$code.'.png', $code, 20, 'horizontal', 'code128', true);
    $pdf->Image('codigos/'.$code.'.png',23,60,30,8,'PNG'); 
   
    $pdf->Image('fotos/fotoazul.JPG',0.1,66,-400) ;
    
    // $pdf->Cell(32.5,5,utf8_decode($data->ciudad_origen)." / ".utf8_decode($data->departamento_origen), 1, 1, 'C');
    // $pdf->Cell(32.5,5,'TELEFONO:', 1, 0, 'C');
    // $pdf->Cell(32.5,5,utf8_decode($data->celular_origen),1,1,'C');
    // $pdf->Cell(32.5,5,'PARA ',1,0,'C');
    // $pdf->Cell(32.5,5,utf8_decode($data->nombre_destinatario), 1, 1, 'C');
    // $pdf->Cell(65,5,utf8_decode('DIRECCIÓN DESTINO'), 1, 1, 'C');
    // $pdf->Cell(65,5,utf8_decode($data->direccion_destino),1,1,'C');
    // $pdf->Cell(32.5,5,'CIUDAD / DEPARTAMENTO',1 ,0, 'C');
    // $pdf->Cell(32.5,5,utf8_decode($data->ciudad_destino)." / ".utf8_decode($data->departamento_destino), 1, 1, 'C');
    // $pdf->Cell(32.5,5,'TELEFONO:', 1, 0, 'C');
    // $pdf->Cell(32.5,5,utf8_decode($data->celular_destino),1,1,'C');
    return $pdf;
}

try {
    $consecutivo = '081693274-001';
    $Conexion = new Conexion();
    $resultado = $Conexion->consultar("SELECT *FROM `TB_PAQUETEOS` WHERE `no_guia_result` = '$consecutivo'");
    $pdf = new FPDF('P','mm','A4');

    foreach ($resultado as $key => $data) {
        $pdf = addTable($pdf,$data,);

    }
}catch(Exception $e){
    echo "Error: " . $e->getMessage();
}


$pdf->Output('Grupo Exito: '.$consecutivo.'.pdf', 'I');