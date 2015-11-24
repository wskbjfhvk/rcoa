<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\modules\shoot\components;
/**
 * Description of ShootBookdetailListTd
 *
 * @author Administrator
 */
class ShootBookdetailListTd extends \yii\grid\DataColumn{
    public function renderDataCell($model, $key, $index) {
        if($index%6 <3)
            $this->contentOptions['class'] = 'bgcolor-zebra';
        else
            $this->contentOptions['class'] = '';
        return parent::renderDataCell($model, $key, $index);
    }
}
