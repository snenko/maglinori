<?php
/**
* @category Brainvire 
* @package Brainvire_Featuredproducts 
* @copyright Copyright (c) 2015 Brainvire Infotech Pvt Ltd
*/
class Brainvire_Featuredproducts_Model_System_Config_Source_Sort
{
	/**
	 * Prepare data for System->Configuration dropdown
	 * @return array
	 */
	public function toOptionArray()
	{
		return array(
			0 => Mage::helper('adminhtml')->__('Random'),
			1 => Mage::helper('adminhtml')->__('Last Added')
		);
	}
}
