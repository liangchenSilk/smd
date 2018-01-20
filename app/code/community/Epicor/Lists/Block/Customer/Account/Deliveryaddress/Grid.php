<?php

/**
 * Customer delivery address Grid
 * 
 * @category   Epicor
 * @package    Epicor_Lists
 * @author     Epicor Websales Team
 */
class Epicor_Lists_Block_Customer_Account_Deliveryaddress_Grid extends Epicor_Common_Block_Generic_List_Grid
{

    public function __construct()
    {
        parent::__construct();

        $this->setId('selectgrid');
        $this->setDefaultSort('type');
        $this->setDefaultDir('DESC');

        $this->setSaveParametersInSession(false);

        $this->setCustomColumns($this->_getColumns());
        $this->setExportTypeCsv(false);
        $this->setExportTypeXml(false);

        $this->setMessageBase('epicor_common');
        $this->setIdColumn('id');

        $this->setFilterVisibility(true);
        $this->setPagerVisibility(true);
        $this->setCacheDisabled(true);
        $this->setUseAjax(true);
        $this->setSkipGenerateContent(true);

        $this->setCustomData($this->_getCustomData());
    }

    protected function _getColumns()
    {
        
    }

    protected function _getCustomData()
    {
        $addresses = $this->getAddresses();

        $helper = Mage::helper('epicor_lists/frontend_restricted');
        /* @var $helper Epicor_Lists_Helper_Frontend_Restricted */

        $address = $helper->getRestrictionAddress();
        // if the address that is selected is a branch - do not show in choose address page. 
        $branchLocationCode = $helper->getBranchPickupAddress();
        $branchValid = true;
        if(($branchLocationCode) && ($branchLocationCode == $address->getErpAddressCode())) {
          $branchValid  = false;
        }        
        if (
            $address instanceof Mage_Sales_Model_Quote_Address &&
            ($address->getCustomerAddressId() == false && $address->getErpAddressCode() == false && $branchValid)
        ) {
            $addresses[] = $address;
        }

        return $addresses;
    }

    public function getAddresses()
    {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        /* @var $customer Epicor_Comm_Model_Customer */
        $transportObject = new Varien_Object;
        $transportObject->setAddresses(array());
        $transportObject->setLoadAddresses(true);
        $dispatchParams = array(
            'quote' => Mage::getSingleton('checkout/session')->getQuote(), 
            'type' => 'delivery', 
            'restrict_by_type' => $this->restrictAddressTypes(), 
            'addresses' => $transportObject
        );
        Mage::dispatchEvent('epicor_comm_onepage_get_checkout_addresses', $dispatchParams);
        $addresses = $transportObject->getAddresses();
        $loadAddresses = $transportObject->getLoadAddresses();

        if ($loadAddresses) {
            $addresses = ($this->restrictAddressTypes()) ? $customer->getAddressesByType('delivery') : $customer->getAddresses();
        }
        
        return $addresses;
    }

    /**
     * Checks whether addresses should be restricted
     * 
     * @return boolean
     */
    public function restrictAddressTypes()
    {
        $helper = Mage::helper('epicor_common');
        /* @var $helper Epicor_Common_Helper_Data */

        return $helper->restrictAddressTypes();
    }

    /**
     * Configuration of grid
     * @return Mage_Adminhtml_Block_Widget_Grid
     * Build columns for List Addresses
     */
    protected function _prepareColumns()
    {
        $this->addColumn('firstname', array(
            'header' => $this->__('Firstname'),
            'width' => '150',
            'index' => 'firstname',
        ));
        
        $this->addColumn('street', array(
            'header' => $this->__('Address'),
            'index' => 'street',
            'type' => 'text',
            'renderer' => new Epicor_Comm_Block_Customer_Address_Renderer_Street()
        ));
        
        $this->addColumn('city', array(
            'header' => $this->__('City'),
            'index' => 'city',
            'type' => 'text'
        ));
        
        $this->addColumn('region', array(
            'header' => $this->__('Region'),
            'index' => 'region',
            'type' => 'text'
        ));
        
        $this->addColumn('country_id', array(
            'header' => $this->__('Country'),
            'index' => 'country_id',
            'type' => 'text'
        ));
        $this->addColumn('postcode', array(
            'header' => $this->__('Postcode'),
            'index' => 'postcode',
            'type' => 'text'
        ));

        $this->addColumn('select', array(
            'header' => $this->__('Select'),
            'width' => '280',
            'index' => 'entity_id',
            // 'type'=>'text',
            'renderer' => 'epicor_lists/customer_account_deliveryaddress_grid_renderer_select',
            'links' => 'true',
            // 'getter' => 'getId',
            'filter' => false,
            'sortable' => false,
            'is_system' => true,
            'actions' => array(
                array(
                    'caption' => $this->__('Select'),
                    'url' => '',
                    'id' => 'link',
                    'onclick' => 'changeShippingAdresss(this); return false;'
                )
            )
        ));

        return parent::_prepareColumns();
    }

    /**
     * Gets grid url for ajax reloading
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/deliveryaddressgrid', array(
                '_current' => true
        ));
    }

    public function getRowUrl($item)
    {
        return false;
    }

}
