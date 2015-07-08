<?php

/**
 *
 * @category    Brainvire
 * @package     Brainvire_Featuredproducts
 * @copyright   Copyright (c) 2015 Brainvire Infotech Pvt Ltd
 * 
 * */

class Brainvire_Featuredproducts_Controller_Index_Abstract extends Mage_Core_Controller_Front_Action {
    /*
     * Check settings set in System->Configuration and apply them to page for featured-products
     * */
    public function indexAction()
    {
        $template = Mage::getConfig()->getNode('global/page/layouts/'.Mage::getStoreConfig("featuredproducts/general/layout").'/template');
        
        $this->loadLayout();

        $this->getLayout()->getBlock('root')->setTemplate($template);
        $this->getLayout()->getBlock('head')->setTitle($this->__(Mage::getStoreConfig("featuredproducts/general/meta_title")));
        $this->getLayout()->getBlock('head')->setDescription($this->__(Mage::getStoreConfig("featuredproducts/general/meta_description")));
        $this->getLayout()->getBlock('head')->setKeywords($this->__(Mage::getStoreConfig("featuredproducts/general/meta_keywords")));
        
                $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
                $breadcrumbsBlock->addCrumb('featured_products', array(
                    'label'=>Mage::helper('featuredproducts')->__(Mage::helper('featuredproducts')->getPageLabel()),
                    'title'=>Mage::helper('featuredproducts')->__(Mage::helper('featuredproducts')->getPageLabel()),
                ));
                
        $this->renderLayout();
    }
}
