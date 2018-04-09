<?php 
   
	$nombre_reporte="Reporte_demo_".date('Y-m-d_H_i_s');
   	$this->Excel->set_header('Índices de población de México');

            $row=3;
            $col=0;

            

            $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('Id')); 
            $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('Año'));
            $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('Estado'));
            $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('Población'));
            $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('Hombres'));
            $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('Mujeres'));
            $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('Nacimientos'));
            $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,__('Defunciones'));


            $total_horas = 0;
            foreach ($registros as $registro){
                $row++;
                $col=0;

                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$this->Number->format($registro->id));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$this->Number->format($registro->year));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,h($registro->estado));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$this->Number->format($registro->poblacion));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$this->Number->format($registro->hombres));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$this->Number->format($registro->mujeres));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$this->Number->format($registro->nacimientos));
                $this->Excel->objWorksheet->setCellValueByColumnAndRow($col++, $row,$this->Number->format($registro->defunciones));
                             
            }


            $this->Excel->do_print($nombre_reporte.'.xlsx');
                
            exit;
?>

    