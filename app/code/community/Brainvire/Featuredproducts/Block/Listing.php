<?php
/**
* @category Brainvire 
* @package Brainvire_Featuredproducts 
* @copyright Copyright (c) 2015 Brainvire Infotech Pvt Ltd
*/

class Brainvire_Featuredproducts_Block_Listing extends Mage_Catalog_Block_Product_Abstract
{  
	/* Limit and sort option is set in System->Configurationa to set template to block
	 * use {{block type="featuredproducts/listing"}} code in CMS pages
	 */
	public function __construct()
	{  
		$this->setTemplate('brainvire/featuredproducts/block_featured_products.phtml');
    
		$this->setLimit((int)Mage::getStoreConfig("featuredproducts/general/number_of_items"));
		$sort_by = Mage::getStoreConfig("featuredproducts/general/product_sort_by");
		$this->setItemsPerRow((int)Mage::getStoreConfig("featuredproducts/general/number_of_items_per_row"));

		switch ($sort_by) {
			case 0:
				$this->setSortBy("rand()");
			break;
			case 1:
				$this->setSortBy("created_at desc");
			break;
			default:
				$this->setSortBy("rand()");
		}
	}

	/*
	 * Load featured products collection
	 * 
	 */
	protected function _beforeToHtml()
	{
		$collection = Mage::getResourceModel('catalog/product_collection');

			$attributes = Mage::getSingleton('catalog/config')
				->getProductAttributes();

			$collection->addAttributeToSelect($attributes)
				->addMinimalPrice()
				->addFinalPrice()
				->addTaxPercents()
				->addAttributeToFilter('brainvire_featured_product', 1, 'left')
				->addStoreFilter()
				->getSelect()->order($this->getSortBy())->limit($this->getLimit());

			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
			Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
		
			$this->_productCollection = $collection;

		$this->setProductCollection($collection);
		return parent::_beforeToHtml();
	}

	/*
	 * Return label for CMS block output
	 * 
	 */
	protected function getBlockLabel()
	{
		return $this->helper('featuredproducts')->getCmsBlockLabel();
	}

}