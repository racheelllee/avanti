<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
/**
 * Producto Entity.
 */
class Producto extends Entity
{   

    private $_checkGroup = TRUE;
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'usuario_id' => true,
        'proveedor_id' => true,
        'sku' => true,
        'codigo_fabricante' => true,
        'nombre' => true,
        'arugemnto_de_venta' => true,
        'garantia' => true,
        'tiempo_de_entrega' => true,
        'descripcion' => true,
        'ficha_tecnica' => true,
        'marca_id' => true,
        'modelo' => true,
        'estatus_id' => true,
        'fecha_publicacion' => true,
        'url' => true,
        'meta_titulo' => true,
        'meta_descripcion' => true,
        'meta_keywords' => true,
        'largo' => true,
        'ancho' => true,
        'alto' => true,
        'peso' => true,
        'peso_volumetrico' => true,
        'usuario' => true,
        'proveedores' => true,
        'marca' => true,
        'atributos' => true,
        'imagenes' => true,
        'preciocomeptencias' => true,
        'precios' => true,
        'categorias' => true,
        'promociones' => true,
        'padre_id' => true,
        'descripcion_corta' => true,
        'descripcion_larga' => true,

        'precio' => true,
        'ver_precio' => true,
        'precio_promocion' => true,
        'ver_precio_promocion' => true,
        'precio_meses_sin_intereses' => true,
        'ver_meses_sin_intereses' => true,
        'meses_sin_intereses' => true,
        'porcentaje_descuento_promocion' => true,
        'ver_porcentaje_descuento_promocion' => true,
    ];



    protected function _getIsProductGroup(){

        if(  ( $this->nombre_grupo != "" ) && ( strlen( $this->nombre_grupo) > 0 ) ){

            
                return TRUE;

        }
        return FALSE;

    }
    protected function _getChildCount(){

        $childCount = Cache::read('childs-'.$this->id);


        if ($childCount !== false) {
            
            // Tenemos valor
            return $childCount;
        }else{

            //lo calculamos
            $productos = TableRegistry::get('Productos');
            //$productos->recover();

            $node = $productos->get($this->id);
            $childCount= $productos->childCount($node);

            Cache::write('childs-'.$this->id, $childCount);
        }

        return $childCount;



    }


    protected function _getCheckgroup( $val ){


        return $val;
    }

    protected function _setCheckgroup($val){

        $this->_checkGroup = $val;
        

        return $val;

    }



    protected function _getNombre( $nombre )
    {   


        if($this->_checkGroup){ 
            //$childCount = $this->childCount;
            

            if(  ( $this->nombre_grupo != "" ) && ( strlen( $this->nombre_grupo) > 0 ) ){

            
                return $this->nombre_grupo;

            }
        }


        return $nombre ;
    }
}
