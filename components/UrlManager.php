<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 17.03.17
 * Time: 21:03
 */

namespace app\components;

use dench\language\LangUrlManager;

class UrlManager extends LangUrlManager
{
    public function init()
    {
        parent::init();

        $rules = [];

        $this->addRules($rules);
    }
}