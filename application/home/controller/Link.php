<?php

namespace app\home\controller;

class Link extends BaseMall
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function search()
    {
        return $this->fetch($this->template_dir.'search');
    }
}