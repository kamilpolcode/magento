<?php
class First_Module_Block_Adminhtml_Comment_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        // Instantiate a new form to display our comment for editing.
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                'first_module_admin/comment/edit',
                array(
                    '_current' => true,
                    'continue' => 0,
                )
            ),
            'method' => 'post',
        ));
        $form->setUseContainer(true);
        $this->setForm($form);

        // Define a new fieldset. We need only one for our simple entity.
        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('Comment Details')
            )
        );

        $commentSingleton = Mage::getSingleton(
            'first_module/comment'
        );

        // Add the fields that we want to be editable.
        $this->_addFieldsToFieldset($fieldset, array(
            'comment' => array(
                'label' => $this->__('Comment'),
                'input' => 'text',
                'required' => true,
            ),
            /*
            'visibility' => array(
                'label' => $this->__('Visibility'),
                'input' => 'select',
                'required' => true,
                'options' => $commentSingleton->getAvailableVisibilies(),
            ),
*/
            /**
             * Note: we have not included created_at or updated_at.
             * We will handle those fields ourself in the model
       * before saving.
             */
        ));

        return $this;
    }

    /**
     * This method makes life a little easier for us by pre-populating
     * fields with $_POST data where applicable and wrapping our post data
     * in 'commentData' so that we can easily separate all relevant information
     * in the controller. You could of course omit this method entirely
     * and call the $fieldset->addField() method directly.
     */
    protected function _addFieldsToFieldset(
        Varien_Data_Form_Element_Fieldset $fieldset, $fields)
    {
        $requestData = new Varien_Object($this->getRequest()
            ->getPost('commentData'));

        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                $_data['value'] = $requestValue;
            }

            // Wrap all fields with commentData group.
            $_data['name'] = "commentData[$name]";

            // Generally, label and title are always the same.
            $_data['title'] = $_data['label'];

            // If no new value exists, use the existing comment data.
            if (!array_key_exists('value', $_data)) {
                $_data['value'] = $this->_getComment()->getData($name);
            }

            // Finally, call vanilla functionality to add field.
            $fieldset->addField($name, $_data['input'], $_data);
        }

        return $this;
    }

    /**
     * Retrieve the existing comment for pre-populating the form fields.
     * For a new comment entry, this will return an empty comment object.
     */
    protected function _getComment()
    {
        if (!$this->hasData('comment')) {
            // This will have been set in the controller.
            $comment = Mage::registry('current_comment');

            // Just in case the controller does not register the comment.
            if (!$comment instanceof
                    First_Module_Model_Comment) {
                $comment = Mage::getModel(
                    'first_module/comment'
                );
            }

            $this->setData('comment', $comment);
        }

        return $this->getData('comment');
    }
}