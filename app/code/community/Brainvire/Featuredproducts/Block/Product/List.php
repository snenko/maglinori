<?php
/**
* @category Brainvire 
* @package Brainvire_Featuredproducts 
* @copyright Copyright (c) 2015 Brainvire Infotech Pvt Ltd
*/
class Brainvire_Featuredproducts_Block_Product_List extends Mage_Catalog_Block_Product_List
{
	protected $_productCollection;
	protected $_sort_by;

    /*
	 * Prepare layout
	 * 
	 */    
    protected function _prepareLayout()
    {
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb('home', array(
                'label'=>Mage::helper('catalog')->__('Home'),
                'title'=>Mage::helper('catalog')->__('Go to Home Page'),
                'link'=>Mage::getBaseUrl()
            ));
        }    
                        
        parent::_prepareLayout();
    }
        
	/*
	 * Remove "Position" option from Sort By dropdown
	 * 
	 */
	protected function _beforeToHtml()
	{
		parent::_beforeToHtml();
		$toolbar = $this->getToolbarBlock();
		$toolbar->removeOrderFromAvailableOrders('position');
		return $this;
	}


	/*
	 * Load featured products collection
	 * 
	 */
	protected function _getProductCollection()
	{
		if (is_null($this->_productCollection)) {
                    $collection = Mage::getModel('catalog/product')->getCollection();

			$attributes = Mage::getSingleton('catalog/config')
				->getProductAttributes();
      
			$collection->addAttributeToSelect($attributes)
				->addMinimalPrice()
				->addFinalPrice()
				->addTaxPercents()
				->addAttributeToFilter('brainvire_featured_product', 1, 'left')
				->addStoreFilter();

			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
			Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
			$this->_productCollection = $collection;
		}
		return $this->_productCollection;
}

    /**
     * Retrieve loaded featured products collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getFeaturedProductCollection()
    {
        return $this->_getProductCollection();
    }
    
    public function getMode()
    {
        return Mage::getStoreConfig("featuredproducts/general/product_view_by");
    }



   /**
     * Get HTML if there's anything to show
     */
	protected function _toHtml()
	{
		if ($this->_getProductCollection()->count()){
			return parent::_toHtml();
		}
		return '';
	}

}