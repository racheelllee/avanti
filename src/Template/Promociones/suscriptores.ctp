<?php 
   
    $nombre_reporte="suscriptores_".date('Y-m-d_H_i_s');
    $this->Excel->set_header('suscriptores');

    $row=1;
    $col=0;

            
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('EMAIL'));
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('FECHA DE SUSCRIPCION'));

    $this->Excel->objWorksheet->getColumnDimension('A')->setWidth(50);
    $this->Excel->objWorksheet->getColumnDimension('B')->setWidth(25);

    foreach ($suscriptores as $suscriptor){
        $row++;
        $col=0;

        $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $suscriptor->email);

        $v = (!empty($suscriptor->created))? $suscriptor->created->format('d/m/Y') : '';
        $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $v);
    }

    $this->Excel->do_print($nombre_reporte.'.xlsx');
                
    exit;
?>
