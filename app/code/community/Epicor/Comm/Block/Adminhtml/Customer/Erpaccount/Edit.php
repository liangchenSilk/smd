<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Edit
 *
 * @author David.Wylie
 */
class Epicor_Comm_Block_Adminhtml_Customer_Erpaccount_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_customer_erpaccount';
        $this->_blockGroup = 'epicor_comm';
        $this->_mode = 'edit';
 
        $this->_addButton('save_and_continue', array(
                  'label' => Mage::helper('epicor_comm')->__('Save And Continue Edit'),
                  'onclick' => 'saveAndContinueEdit()',
                  'class' => 'save',
        ), -100);
        $this->_updateButton('save', 'label', Mage::helper('epicor_comm')->__('Save'));
 
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }
 
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * 
     * @return Epicor_Comm_Model_Customer_Erpaccount
     */
     public function getErpCustomer() {
        if (!$this->_erp_customer) {
            $this->_erp_customer = Mage::registry('customer_erp_account');
        }
        return $this->_erp_customer;
    }
    
    public function getHeaderText()
    {
        $customer = $this->getErpCustomer();
        $name =$customer->getName();
        $code = $customer->getErpCode();
        return Mage::helper('epicor_comm')->__('ERP Customer: '.$name.' ('.$code.')');      
    }
}


