<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\shoot\components;

/**
 * Description of GroupGridViewDataColumn
 *
 * @author Administrator
 */
class GroupGridViewDataColumn extends \yii\grid\DataColumn {
    //put your code here
    public function renderDataCell($model, $key, $index) {
        //$this->contentOptions["rowspan"] = 2;
        if(isset($this->contentOptions["rowspan"]))
        {
            $rowspan = $this->contentOptions["rowspan"];
            if($index%$rowspan == 0)
                return parent::renderDataCell($model, $key, $index);
            else
                return $this->grid->emptyCell;
        }else
            return parent::renderDataCell($model, $key, $index);
    }
}
