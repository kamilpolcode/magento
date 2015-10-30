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
class First_Module_Block_Adminhtml_Comment extends Mage_Adminhtml_Block_Widget_Grid_Container {
    protected function _construct()
    {

        /**
         * The $_blockGroup property tells Magento which alias to use to
         * locate the blocks to be displayed in this grid container.
         * In our example, this corresponds to Firt/Module.
         */
        $this->_blockGroup = 'first_module';

        /**
         * $_controller is a slightly confusing name for this property.
         * This value, in fact, refers to the folder containing our
         * Grid.php and Edit.php - in our example,
         * BrandDirectory/Block/Adminhtml/Brand. So, we'll use 'brand'.
         */
        $this->_controller = 'adminhtml_comment';

        /**
         * The title of the page in the admin panel.
         */
        $this->_headerText = Mage::helper('first_module')
            ->__('Comments Directory');
        
        parent::_construct();
    }

    public function getCreateUrl()
    {
        /**
         * When the "Add" button is clicked, this is where the user should
         * be redirected to - in our example, the method editAction of
         * BrandController.php in BrandDirectory module.
         */
        return $this->getUrl(
            'first_module_admin/comment/edit'
        );
    }
}
