<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentController
 *
 * @author kserwin
 */
class First_Module_Adminhtml_CommentController extends Mage_Adminhtml_Controller_Action {
     /**
     * Instantiate our grid container block and add to the page content.
     * When accessing this admin index page, we will see a grid of all
     * comments currently available in our Magento instance, along with
     * a button to add a new one if we wish.
     */
    public function indexAction()
    {
        
        // instantiate the grid container
        $commentBlock = $this->getLayout()
            ->createBlock('first_module/adminhtml_comment');

        // Add the grid container as the only item on this page
        $this->loadLayout()
            ->_addContent($commentBlock)
            ->renderLayout();
      
    }

    /**
     * This action handles both viewing and editing existing comments.
     */
    public function editAction()
    {
        /**
         * Retrieve existing comment data if an ID was specified.
         * If not, we will have an empty comment entity ready to be populated.
         */
        $comment = Mage::getModel('first_module/comment');
        if ($commentId = $this->getRequest()->getParam('id', false)) {
            $comment->load($commentId);

            if (!$comment->getId()) {
                    $this->_getSession()->addError(
                    $this->__('This comment no longer exists.')
                );
                return $this->_redirect(
                    'first_module_admin/comment/index'
                );
            }
        }

        // process $_POST data if the form was submitted
        if ($postData = $this->getRequest()->getPost('commentData')) {
            try {
                $comment->addData($postData);
                $comment->save();

                $this->_getSession()->addSuccess(
                    $this->__('The comment has been saved.')
                );

                // redirect to remove $_POST data from the request
                return $this->_redirect(
                    'first_module_admin/comment/edit',
                    array('id' => $comment->getId())
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

        // Make the current comment object available to blocks.
        Mage::register('current_comment', $comment);

        // Instantiate the form container.
        $commentEditBlock = $this->getLayout()->createBlock(
            'first_module/adminhtml_comment_edit'
        );

        // Add the form container as the only item on this page.
        $this->loadLayout()
            ->_addContent($commentEditBlock)
            ->renderLayout();
    }

    public function deleteAction()
    {
        $comment = Mage::getModel('first_module/comment');

        if ($commentId = $this->getRequest()->getParam('id', false)) {
            $comment->load($commentId);
        }

        if (!$comment->getId()) {
            $this->_getSession()->addError(
                $this->__('This comment no longer exists.')
            );
            return $this->_redirect(
                'first_module_admin/comment/index'
            );
        }

        try {
            $comment->delete();

            $this->_getSession()->addSuccess(
                $this->__('The comment has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'first_module_admin/comment/index'
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
         * - - - - - - - comment
         *
         * eg. you could add more rules inside comment for edit and delete.
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
                    ->isAllowed('first_module/comment');
                break;
        }

        return $isAllowed;
    }
}
