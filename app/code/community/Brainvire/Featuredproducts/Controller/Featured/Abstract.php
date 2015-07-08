<?php

/**
 *
 * @category    Brainvire
 * @package     Brainvire_Featuredproducts
 * @copyright   Copyright (c) 2015 Brainvire Infotech Pvt Ltd
 * 
 * */

class Brainvire_Featuredproducts_Controller_Featured_Abstract extends Mage_Adminhtml_Controller_Action {
/*
     * Initialize Product and set attribute in admin.
     */
    protected function _initProduct()
    {
        
        $product = Mage::getModel('catalog/product')
            ->setStoreId($this->getRequest()->getParam('store', 0));

        
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $product->setAttributeSetId($setId);
            }

            if ($typeId = $this->getRequest()->getParam('type')) {
                $product->setTypeId($typeId);
            }
                    
        $product->setData('_edit_mode', true);
        
        Mage::register('product', $product);
       
        return $product;
    }
    
    /*
     * Load layout and add content of featured product to admin.
     */
    public function indexAction()
    {
        $this->_initProduct();
        
        $this->loadLayout()->_setActiveMenu('catalog/featuredproduct');
            
        $this->_addContent($this->getLayout()->createBlock('featuredproducts/adminhtml_edit'));
        
        $this->renderLayout();
    
    }
    
    /*
     * create featured product grid.
     */
    public function gridAction()
    {
         
    $this->getResponse()->setBody(
            $this->getLayout()->createBlock('featuredproducts/adminhtml_edit_grid')->toHtml()
        );
    
    }
    
    /*
     * save the featured products
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost(); 
        $collection = Mage::getModel('catalog/product')->getCollection();
        $storeId        = $this->getRequest()->getParam('store', 0);
        
                 
        parse_str($data['featured_products'], $featured_products);
        
        
        $collection->addIdFilter(array_keys($featured_products));
        
         try {
            
            foreach($collection->getItems() as $product)
            {
                
                $product->setData('brainvire_featured_product',$featured_products[$product->getEntityId()]);
                $product->setStoreId($storeId);     
                $product->save();   
            }   
            
            
            $this->_getSession()->addSuccess($this->__('Featured product was successfully saved.'));
            $this->_redirect('*/*/index', array('store'=> $this->getRequest()->getParam('store'))); 
            
         }catch (Exception $e){
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*/index', array('store'=> $this->getRequest()->getParam('store')));
         }
    
    }
    
    /*
     * validate the secret key
     */
    protected function _validateSecretKey()
    {
        return true;
    }

    /*
     * Check if admin session is allow for featured product
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/catalog/featuredproduct');
    }
}
