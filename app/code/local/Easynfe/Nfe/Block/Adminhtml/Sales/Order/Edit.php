<?php
/**
 * Easynfe - NF-e. 
 *
 * @title      Magento Easynfe NF-e
 * @category   General
 * @package    Easynfe_Nfe
 * @author     Indexa Development Team <desenvolvimento@indexainternet.com.br>
 * @copyright  Copyright (c) 2011 Indexa - http://www.indexainternet.com.br
 */

class Easynfe_Nfe_Block_Adminhtml_Sales_Order_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'nfe';
        $this->_controller = 'adminhtml_nfe';
  
        $this->_updateButton('save', 'label', Mage::helper('nfe')->__('Save'));
        $this->_removeButton('back');
        $this->_removeButton('reset');
        $this->_removeButton('delete');
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('nfe_data') && Mage::registry('nfe_data')->getId() ) {
            return Mage::helper('nfe')->__("Create NFe Request ");
        } else {
            return Mage::helper('nfe')->__('Add Request');
        }
    }
}
/*
class Easynfe_Nfe_Block_Adminhtml_Sales_Order_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'nfe';

        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('customer')->__('Save Customer'));
    }

    public function getRequestId()
    {
        return Mage::registry('current_nfe_request')->getId();
    }

    public function getHeaderText()
    {
        if (Mage::registry('current_nfe_request')->getId()) {
            return $this->htmlEscape(Mage::registry('current_nfe_request')->getName());
        }
    }

    
    public function getFormHtml()
    {
        $html = parent::getFormHtml();
        $html .= $this->getLayout()->createBlock('easynfe_nfe/adminhtml_sales_order_edit_form')->toHtml();
        return $html;
    }


    
    protected function _prepareLayout()
    {
       return parent::_prepareLayout();
    }
 
}*/
