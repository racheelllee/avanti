<?php 

$this->setFilename("reporte".time());
?>
<page>

    <table>
        <tr>
        <th> Id </th>
        <th>  Year </th>
        <th> Poblacion </th>
        <th> hombre </th>
        <th> mujeres </th>
        <th> Nacimientos </th>
        <th> defuciones </th>
        </tr>

    <?php  

    foreach ($registros as $registro){
                
            ?>    
            <tr>
                
                <td> <?= $this->Number->format($registro->id); ?> </td>

                <td> <?= $this->Number->format($registro->year); ?> </td>


                <td> <?= h($registro->estado); ?> </td>
                <td> <?= $this->Number->format($registro->poblacion); ?> </td>
                <td> <?= $this->Number->format($registro->hombres); ?> </td>
                <td> <?= $this->Number->format($registro->mujeres); ?> </td>
                <td> <?= $this->Number->format($registro->nacimientos); ?> </td>
                <td> <?= $this->Number->format($registro->defunciones); ?> </td>
                      
            </tr>       
           <?php  }


    ?>

    </table>
</page>