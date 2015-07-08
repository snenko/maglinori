<?php
/**
* @category Brainvire 
* @package Brainvire_Featuredproducts 
* @copyright Copyright (c) 2015 Brainvire Infotech Pvt Ltd
*/
class Brainvire_Featuredproducts_Model_System_Config_Source_View
{
	/**
	 * Prepare data for System->Configuration dropdown
	 * @return array 
	 */
	public function toOptionArray()
	{
		return array(
			'grid' => Mage::helper('adminhtml')->__('Grid'),
			'slider' => Mage::helper('adminhtml')->__('Slider')
		);
	}
}
