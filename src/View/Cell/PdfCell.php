<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Pdf cell
 */
class PdfCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */

    public function pdf_cell($opcional)
    {
        $this->set('opcional', $opcional);
    }

    public function graficas_img()
    {
    }
    
}
