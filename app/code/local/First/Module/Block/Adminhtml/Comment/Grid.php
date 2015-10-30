<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grid
 *
 * @author kserwin
 */
class First_Module_Block_Adminhtml_Comment_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    protected function _prepareCollection()
    {
        /**
         * Tell Magento which collection to use to display in the grid.
         */
        $collection = Mage::getResourceModel(
            'first_module/comment_collection'
        );
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function getRowUrl($row)
    {
        /**
         * When a grid row is clicked, this is where the user should
         * be redirected to - in our example, the method editAction of
         * BrandController.php in BrandDirectory module.
         */
        return $this->getUrl(
            'first_module_admin/comment/edit',
            array(
                'id' => $row->getId()
            )
        );
    }

    protected function _prepareColumns()
    {
        /**
         * Here, we'll define which columns to display in the grid.
         */
        $this->addColumn('comment_id', array(
            'header' => $this->_getHelper()->__('ID'),
            'type' => 'number',
            'index' => 'comment_id',
        ));

        $this->addColumn('created_at', array(
            'header' => $this->_getHelper()->__('Created'),
            'type' => 'datetime',
            'index' => 'created_at',
        ));
/*
        $this->addColumn('updated_at', array(
            'header' => $this->_getHelper()->__('Updated'),
            'type' => 'datetime',
            'index' => 'updated_at',
        ));
*/
        $this->addColumn('comment', array(
            'header' => $this->_getHelper()->__('Comment'),
            'type' => 'text',
            'index' => 'comment',
        ));

        $this->addColumn('description', array(
            'header' => $this->_getHelper()->__('Description'),
            'type' => 'text',
            'index' => 'description',
        ));

        $commentSingleton = Mage::getSingleton(
            'first_module/comment'
        );
        
        $this->addColumn('visibility', array(
            'header' => $this->_getHelper()->__('Visibility'),
            'type' => 'options',
            'index' => 'visibility',
            'options' => $commentSingleton->getAvailableVisibilies()
        ));

        /**
         * Finally, we'll add an action column with an edit link.
         */
        $this->addColumn('action', array(
            'header' => $this->_getHelper()->__('Action'),
            'width' => '50px',
            'type' => 'action',
            'actions' => array(
                array(
                    'caption' => $this->_getHelper()->__('Edit'),
                    'url' => array(
                        'base' => 'first_module_admin'
                                  . '/comment/edit',
                    ),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'comment_id',
        ));
        
        /**
         * Finally, we'll add an action column with delete link.
         */
        $this->addColumn('Delete', array(
            'header' => $this->_getHelper()->__('Delete'),
            'width' => '50px',
            'type' => 'action',
            'actions' => array(
                array(
                    'caption' => $this->_getHelper()->__('Delete'),
                    'url' => array(
                        'base' => 'first_module_admin'
                                  . '/comment/delete',
                    ),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'comment_id',
        ));

        return parent::_prepareColumns();
    }

    protected function _getHelper()
    {
        return Mage::helper('first_module');
    }
}
