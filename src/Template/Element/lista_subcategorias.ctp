<?php


$bandera = TRUE;
if( count($padres > 0 )){

  echo '<ul>';
foreach ($padres as  $child) {

  if($child->id == $categoria->categoria_id){

    $bandera = FALSE;
      echo '<li> <a class=" active todas" href="/sc/'.$child->url.'#listado">'. $child->nombre .' </a>';

      echo '<ul>';

      print $this->element('categorias_hermanos',[ 'categoria'=>$categoria,'categoria_sub'=>$categoria_sub, 'hermanos' => $hermanos]);

      echo '</ul></li>';


  }else
      echo '<li> <a  href="/sc/'.$child->url.'#listado">'. $child->nombre .' </a></li>';
}
echo '</ul>';


} 

if ($bandera){  


  echo '<ul>';

  print $this->element('categorias_hermanos',[ 'categoria'=>$categoria, 'categoria_sub'=> $categoria_sub, "hermanos" => $hermanos]);

  echo '</ul>';

}



?>