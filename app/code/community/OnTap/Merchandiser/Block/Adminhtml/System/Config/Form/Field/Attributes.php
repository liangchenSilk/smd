<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    OnTap
 * @package     OnTap_Merchandiser
 * @copyright   Copyright (c) 2014 On Tap Networks Ltd. (http://www.ontapgroup.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class OnTap_Merchandiser_Block_Adminhtml_System_Config_Form_Field_Attributes
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * _formatted
     * 
     * (default value: array())
     * 
     * @var array
     */
    protected $_formatted = array();
    
    /**
     * _construct
     */
    public function _construct()
    {
        // Initialise layout for attribute selection block
        $adminLayout = mage::getModel('core/layout');
        
        $renderAttribute = $adminLayout->createBlock(
            'merchandiser/adminhtml_system_config_form_renderer_select',
            'smartmerch_dminhtml_system_config_form_renderer_select',
            array(
                'values'    =>  $this->populateAttributes(),
                'class' => 'vm_select attribute-select'
            ))->setWidth(100);
                
        $renderLogic = $adminLayout->createBlock(
                'merchandiser/adminhtml_system_config_form_renderer_select',
                'smartmerch_dminhtml_system_config_form_renderer_select',
                array(
                    'values' => array(
                        'OR' => 'OR',
                        'AND' => 'AND'
                    ),
                    'class' => 'vm_select logic_link'
                ))->setWidth(75);
        
        // Add main columns
        $this->addColumn('attribute', array(
            'label' => Mage::helper('merchandiser')->__('Attribute'),
            'renderer' => $renderAttribute
        ));
        
        $this->addColumn('value', array(
            'label' => Mage::helper('merchandiser')->__('Value'),
        ));

        $this->addColumn('link', array(
            'label' => Mage::helper('merchandiser')->__('Logic'),
            'renderer' => $renderLogic,
        ));
        
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('merchandiser')->__('Add Attribute');
        
        parent::_construct();
        
        $this->setTemplate('merchandiser/smartmerch/attributes.phtml');
        $this->setHtmlId('_cat_'.Mage::registry('category')->getId());
    }
    
    /**
     * populateAttributes
     * 
     * @return array
     */
    private function populateAttributes()
    {
        // Set up attribute array
        $populateOptions = array();
        $populateOptions['category_id'] = Mage::helper("merchandiser")->__("Clone category ID(s)");
        $populateOptions['created_at'] = Mage::helper("merchandiser")->__("Date Created (days ago)");
        $populateOptions['updated_at'] = Mage::helper("merchandiser")->__("Date Modified (days ago)");
        $populateOptions['new_product'] = Mage::helper("merchandiser")->__("New Product");
        
        $productAttributes = Mage::getSingleton('catalog/config')->getProductAttributes();
        $eavConfiguration = Mage::getModel('eav/config');
        
        $restrictedAttributes = array(
            'giftcard_amounts', 'allow_open_amount', 'open_amount_min', 'open_amount_max', 'shipment_type',
            'tax_class_id', 'price_view', 'price_type', 'msrp_display_actual_price_type', 'required_options',
            'links_purchased_separately', 'weight_type', 'links_exist');
        
        foreach ($productAttributes as $attCode) {
            $curAttribute = $eavConfiguration->getAttribute('catalog_product', $attCode);
            if ($curAttribute->getFrontendLabel() != '') {
                $attributeLabel = $curAttribute->getFrontendLabel();
            } else {
                $attributeLabel = $curAttribute->getAttributeCode();
            }
            if ($curAttribute->getBackendType() == 'datetime' ||
                    in_array($curAttribute->getAttributeCode(), $restrictedAttributes)) {
                continue;
            }
            $populateOptions[$curAttribute->getAttributeId()] = str_replace("'", "", $attributeLabel);
        }
        
        // Sort attribtues into alphabetical order
        asort($populateOptions);
        return $populateOptions;
    }
}