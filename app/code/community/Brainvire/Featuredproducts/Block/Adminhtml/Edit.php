<?php
/**
* @category Brainvire 
* @package Brainvire_Featuredproducts 
* @copyright Copyright (c) 2015 Brainvire Infotech Pvt Ltd
*/
class Brainvire_Featuredproducts_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Grid_Container {

    protected $_saveButtonLabel = 'Save Featured Products';

    /*
     * call featuredproducts block and controller
     * 
     */
    public function __construct() {


        $this->_blockGroup = 'featuredproducts';
        $this->_controller = 'adminhtml_edit';


        $this->_headerText = Mage::helper('adminhtml')->__('Featured products');

        parent::__construct();

        $this->_removeButton('add');

        $this->_addButton('save', array(
            'label' => $this->_saveButtonLabel,
            'onclick' => 'categorySubmit(\'' . $this->getSaveUrl() . '\')',
            'class' => 'Save',
        ));
    }

    /**
     * Save featured products 
     * @return Url
     */
    public function getSaveUrl() {
        return $this->getUrl('*/*/save', array('store' => $this->getRequest()->getParam('store')));
    }

    /*
     * Adding the html
     * 
     */
    protected function _afterToHtml($html) {
        return $this->_prependHtml() . parent::_afterToHtml($html) . $this->_appendHtml();
    }

    /**
     * Prepending the Html code
     * @return Html
     */
    private function _prependHtml() {
        $html = '
    	
    	<form id="featured_edit_form" action="' . $this->getSaveUrl() . '" method="post" enctype="multipart/form-data">
    	<input name="form_key" type="hidden" value="' . $this->getFormKey() . '" />
    		<div class="no-display">
        		<input type="hidden" name="featured_products" id="in_featured_products" value="" />
    		</div>
		</form>
    	';

        return $html;
    }

    /**
     * Appending the Html code
     * @return Html
     */
    private function _appendHtml() {
        $html =
                '
		<style type="text/css">
		<!--
		#logo_wrapp a{ 
			display:block; 
			width:75px;  
			float:right;
			padding:0px 0px 0px 0px;
			margin:5px 0px 0px 0px;
			background:url(' . $this->getSkinUrl('images/brainvire/brainvire-small-logo.png') . ') no-repeat 0px 0px;
			text-indent: -9999px;
			font-size: 0px;
			line-height: 0px;
			height:13px;	
    	}
    	#logo_wrapp a:hover {background:url(' . $this->getSkinUrl('images/brainvire/brainvire-small-logo.png') . ') no-repeat 0px -13px; }
		-->
		</style>';
        return $html;
    }

    /*
     * Getting the header html code
     * 
     */
    public function getHeaderHtml() {
        return '<h3 style="background-image: url(' . $this->getSkinUrl('images/product_rating_full_star.gif') . ');" class="' . $this->getHeaderCssClass() . '">' . $this->getHeaderText() . '</h3>';
    }

    /*
     * Preparing the layout
     * 
     */
    protected function _prepareLayout() {
        $this->setChild('store_switcher', $this->getLayout()->createBlock('adminhtml/store_switcher', 'store_switcher')->setUseConfirm(false)
        );
        return parent::_prepareLayout();
    }
    /*
     * getting the Grid Html code
     * 
     */
    public function getGridHtml() {

        return $this->getChildHtml('store_switcher') . $this->getChildHtml('grid');
    }

}