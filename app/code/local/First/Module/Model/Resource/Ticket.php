<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ticket
 *
 * @author kserwin
 */
class First_Module_Model_Resource_Ticket extends Mage_Core_Model_Resource_Db_Abstract {
    protected function _construct()
    {
        $this->_init('first_module/ticket', 'ticket_id');
    }
}
