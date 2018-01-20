<?php
/**
 * Blackbird ContentManager Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@bird.eu so we can send you a copy immediately.
 *
 * @category	Blackbird
 * @package		Blackbird_ContentManager
 * @copyright	Copyright (c) 2014 Blackbird Content Manager (http://black.bird.eu)
 * @author		Blackbird Team
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version		
 */

class Blackbird_ContentManager_Block_View_Group_Footer extends Mage_Catalog_Block_Product_Abstract
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $content = $this->getContent();
        $cct = Mage::registry('current_ct');
        
        //test applying contenttype/view/option/"option type"-ID.phtml
        $this->setTemplate('contenttype/view/group/footer-'.$content->getId().'.phtml');
        if(!file_exists(Mage::getBaseDir('app') . DS . 'design' . DS . $this->getTemplateFile()))
        {
            //test applying contenttype/view/option/"option type"-"content type".phtml
            $this->setTemplate('contenttype/view/group/footer-'.$cct->getIdentifier().'.phtml');
            if(!file_exists(Mage::getBaseDir('app') . DS . 'design' . DS . $this->getTemplateFile()))
            {
                //applying default view.phtml
                $this->setTemplate('contenttype/view/group/footer.phtml');
            }
        }
    }
    
}