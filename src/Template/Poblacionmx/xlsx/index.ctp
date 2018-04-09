<?php 
   
    $nombre_reporte="poblacionmx_".date('Y-m-d_H_i_s');
    $this->Excel->set_header('poblacionmx');

    $row=3;
    $col=0;

            
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('id'));
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('year'));
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('estado'));
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('poblacion'));
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('hombres'));
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('mujeres'));
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('nacimientos'));
    $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('defunciones'));

    foreach ($poblacionmx as $poblacionmx){
        $row++;
        $col=0;
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $this->Number->format($poblacionmx->id));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $this->Number->format($poblacionmx->year));
                $valor=h($poblacionmx->estado);
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$valor);

                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $this->Number->format($poblacionmx->poblacion));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $this->Number->format($poblacionmx->hombres));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $this->Number->format($poblacionmx->mujeres));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $this->Number->format($poblacionmx->nacimientos));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row, $this->Number->format($poblacionmx->defunciones));
        }

        $this->Excel->do_print($nombre_reporte.'.xlsx');
                
            exit;

?>