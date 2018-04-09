<?php




foreach ($hermanos as  $child) {

  if($child->id == $categoria->id){
      echo '<li> <a class=" active todas" href="/sc/'.$child->url.'#listado">'. $child->nombre .' </a><ul>';


        echo $this->element('categoria_sub',['categoria_sub'=> $categoria_sub]);

        echo '</ul></li>';
    }
  else
      echo '<li> <a  href="/sc/'.$child->url.'#listado">'. $child->nombre .' </a></li>';
}

?>