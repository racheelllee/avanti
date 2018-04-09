<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

use Cake\ORM\Exception\MissingTableClassException;

/**
 * ImportExcel behavior
 */
class ImportExcelBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function prepareArrayData($file = null, array $options = [])
    {
        $result = [];

        /**  load and configure PHPExcelReader  * */
        \PHPExcel_Cell::setValueBinder(new \PHPExcel_Cell_AdvancedValueBinder());
        $fileType = \PHPExcel_IOFactory::identify($file);

        if($fileType != 'Excel5' && $fileType != 'Excel2007'){
            $result['Error'] = 'El formato del archivo no es valido.';
            return $result;
        }

        $PhpExcelReader = \PHPExcel_IOFactory::createReader($fileType);

        $PhpExcelReader->setReadDataOnly(false);

        /** identify worksheets in file * */
        $worksheets = $PhpExcelReader->listWorksheetNames($file);

        $worksheetToLoad = null;

        if(count($worksheets) === 1){
            $worksheetToLoad = $worksheets[0];  //first option: if there is only one worksheet, use it
        }elseif(isset($options['worksheetPosition']) && $options['worksheetPosition'] > -1){
            $worksheetToLoad = $worksheets[$options['worksheetPosition']]; 
        }elseif(isset($options['worksheetName']) && $options['worksheetName'] != ''){
            $worksheetToLoad = $options['worksheetName'];
        }else{
            $result['Error'] = 'Hoja no especifica.';
            return $result;
        }

        if (!in_array($worksheetToLoad, $worksheets)) {
            throw new MissingTableClassException(__('No proper named worksheet found'));
        }

        /** load the sheet and convert data to an array */
        $PhpExcelReader->setLoadSheetsOnly($worksheetToLoad);
        $PhpExcel = $PhpExcelReader->load($file);
        $data = $PhpExcel->getSheet(0)->toArray();



        for ($i=$options['startRow']; $i < count($data); $i++) { //start from row n
            
            $tmp = [];
            foreach ($options['headerCols'] as $key => $header) {

                $tmp[$header] = @$data[$i][$key];
                
            }

            
            foreach ($options['notEmpty'] as $key) { //check empty
                if(empty($tmp[$key])){
                    $tmp['result_upload'][] = __($key).' '.__('no empty'); 
                }
            }
            

            if(!empty($tmp)){
                $result[] = $tmp;    
            }

        }
        
        
        return $result;
    }


    public function parserMoneyExcel2Php( $number ){


    	$tmp = str_replace(',', '', trim( $number ) );

    	

    	return $tmp;

    }

    public function parserDateExcel2Php( $date  ){

    	$array = array();

    	list($m, $d, $a) = explode('/', $date);
        list($a, $time) = explode(' ', $a);
        $array['year'] = $a;
        $array['month'] = sprintf('%02d', $m);
        $array['day'] = sprintf('%02d', $d);

        $array['hour'] = '';
        $array['min'] = '';
        if($time){
            list($hr, $min) = explode(':', $time);
            $array['hour'] = sprintf('%02d', $hr);
            $array['min'] = sprintf('%02d', $min);
        }

        $array['original'] = $date;

        return $array['day'].'-'.$array['month'].'-'.$array['year'].' '.$array['hour'].':'.$array['min'];
    }
}
