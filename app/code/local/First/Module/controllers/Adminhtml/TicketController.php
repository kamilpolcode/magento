<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TicketController
 *
 * @author kserwin
 */
class First_Module_Adminhtml_TicketController extends Mage_Adminhtml_Controller_Action {
     /**
     * Instantiate our grid container block and add to the page content.
     * When accessing this admin index page, we will see a grid of all
     * tickets currently available in our Magento instance, along with
     * a button to add a new one if we wish.
     */
    public function indexAction()
    {
        
        // instantiate the grid container
        $ticketBlock = $this->getLayout()
            ->createBlock('first_module/adminhtml_ticket');

        // Add the grid container as the only item on this page
        $this->loadLayout()
            ->_addContent($ticketBlock)
            ->renderLayout();
      
    }

    /**
     * This action handles both viewing and editing existing tickets.
     */
    public function editAction()
    {
        /**
         * Retrieve existing ticket data if an ID was specified.
         * If not, we will have an empty ticket entity ready to be populated.
         */
        $ticket = Mage::getModel('first_module/ticket');
        if ($ticketId = $this->getRequest()->getParam('id', false)) {
            $ticket->load($ticketId);

            if (!$ticket->getId()) {
                    $this->_getSession()->addError(
                    $this->__('This ticket no longer exists.')
                );
                return $this->_redirect(
                    'first_module_admin/ticket/index'
                );
            }
        }

        // process $_POST data if the form was submitted
        if ($postData = $this->getRequest()->getPost('ticketData')) {
            try {
                $ticket->addData($postData);
                $ticket->save();

                $this->_getSession()->addSuccess(
                    $this->__('The ticket has been saved.')
                );

                // redirect to remove $_POST data from the request
                return $this->_redirect(
                    'first_module_admin/ticket/edit',
                    array('id' => $ticket->getId())
                );
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }

            /**
             * If we get to here, then something went wrong. Continue to
             * render the page as before, the difference this time being
             * that the submitted $_POST data is available.
             */
        }

        // Make the current ticket object available to blocks.
        Mage::register('current_ticket', $ticket);

        // Instantiate the form container.
        $ticketEditBlock = $this->getLayout()->createBlock(
            'first_module/adminhtml_ticket_edit'
        );

        // Add the form container as the only item on this page.
        $this->loadLayout()
            ->_addContent($ticketEditBlock)
            ->renderLayout();
    }

    public function deleteAction()
    {
        $ticket = Mage::getModel('first_module/ticket');

        if ($ticketId = $this->getRequest()->getParam('id', false)) {
            $ticket->load($ticketId);
        }

        if (!$ticket->getId()) {
            $this->_getSession()->addError(
                $this->__('This ticket no longer exists.')
            );
            return $this->_redirect(
                'first_module_admin/ticket/index'
            );
        }

        try {
            $ticket->delete();

            $this->_getSession()->addSuccess(
                $this->__('The ticket has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'first_module_admin/ticket/index'
        );
    }

    /**
     * Thanks to Ben for pointing out this method was missing. Without
     * this method the ACL rules configured in adminhtml.xml are ignored.
     */
    protected function _isAllowed()
    {
        /**
         * we include this switch to demonstrate that you can add action
         * level restrictions in your ACL rules. The isAllowed() method will
         * use the ACL rule we have configured in our adminhtml.xml file:
         * - acl
         * - - resources
         * - - - admin
         * - - - - children
         * - - - - - first_module
         * - - - - - - children
         * - - - - - - - ticket
         *
         * eg. you could add more rules inside ticket for edit and delete.
         */
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'edit':
            case 'delete':
                // intentionally no break
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('first_module/ticket');
                break;
        }

        return $isAllowed;
    }
}
