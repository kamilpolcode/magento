<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author kserwin
 */
class First_Module_Model_Comment extends Mage_Core_Model_Abstract {
    protected function _construct()
    {
        $this->_init('first_module/comment');
    }
}
