<?php
class First_Module_Block_Adminhtml_Ticket_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        // Instantiate a new form to display our ticket for editing.
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                'first_module_admin/ticket/edit',
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
                'legend' => $this->__('Ticket Details')
            )
        );

        $ticketSingleton = Mage::getSingleton(
            'first_module/ticket'
        );

        // Add the fields that we want to be editable.
        $this->_addFieldsToFieldset($fieldset, array(
            'title' => array(
                'label' => $this->__('Title'),
                'input' => 'text',
                'required' => true,
            ),
            'url_key' => array(
                'label' => $this->__('URL Key'),
                'input' => 'text',
                'required' => true,
            ),
            'description' => array(
                'label' => $this->__('Description'),
                'input' => 'textarea',
                'required' => true,
            ),
            'visibility' => array(
                'label' => $this->__('Visibility'),
                'input' => 'select',
                'required' => true,
                'options' => $ticketSingleton->getAvailableVisibilies(),
            ),

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
     * in 'brandData' so that we can easily separate all relevant information
     * in the controller. You could of course omit this method entirely
     * and call the $fieldset->addField() method directly.
     */
    protected function _addFieldsToFieldset(
        Varien_Data_Form_Element_Fieldset $fieldset, $fields)
    {
        $requestData = new Varien_Object($this->getRequest()
            ->getPost('ticketData'));

        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                $_data['value'] = $requestValue;
            }

            // Wrap all fields with brandData group.
            $_data['name'] = "ticketData[$name]";

            // Generally, label and title are always the same.
            $_data['title'] = $_data['label'];

            // If no new value exists, use the existing brand data.
            if (!array_key_exists('value', $_data)) {
                $_data['value'] = $this->_getTicket()->getData($name);
            }

            // Finally, call vanilla functionality to add field.
            $fieldset->addField($name, $_data['input'], $_data);
        }

        return $this;
    }

    /**
     * Retrieve the existing brand for pre-populating the form fields.
     * For a new brand entry, this will return an empty brand object.
     */
    protected function _getTicket()
    {
        if (!$this->hasData('ticket')) {
            // This will have been set in the controller.
            $ticket = Mage::registry('current_ticket');

            // Just in case the controller does not register the ticket.
            if (!$ticket instanceof
                    First_Module_Model_Ticket) {
                $ticket = Mage::getModel(
                    'first_module/ticket'
                );
            }

            $this->setData('ticket', $ticket);
        }

        return $this->getData('ticket');
    }
}