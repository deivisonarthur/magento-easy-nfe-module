<?php
/**
 * Indexa - NF-e. 
 *
 * @title      Magento Indexa NF-e
 * @category   General
 * @package    Indexa_Nfe
 * @author     Indexa Development Team <desenvolvimento@indexainternet.com.br>
 * @copyright  Copyright (c) 2011 Indexa - http://www.indexainternet.com.br
 */

class Indexa_Nfe_Block_Adminhtml_Sales_Order_Nfe extends Mage_Adminhtml_Block_Template
{
    
    public function __construct() {
        /**
         * check if NF-e module is enabled
         */
        parent::__construct();
        
        if ( !Mage::getStoreConfig('indexa_nfe/geral/status') ){
            return ;
        }
        
        /**
         * set NF-e template
         */
        $this->setTemplate('indexa_nfe/sales/order/nfe.phtml');
    }    
    
    public function getOrderId(){
        if(Mage::registry('current_order'))
            return Mage::registry('current_order')->getId();
    }
    
    public function getNf(){
        /**
         * nf collection
         */
        if($this->getOrderId())
            return Mage::getModel('indexa_nfe/sales_order')->getCollection()->addOrderFilter( $this->getOrderId() );
        else
            return false;
    }
    
    public function getNfCollection( $id ){
        /**
         * nf collection
         */
        return Mage::getModel('indexa_nfe/sales_order_nf')->getCollection()->addNfFilter( $id );
    }
    
    public function getRequestCollection( $id ){
        /**
         * nf collection
         */
        return Mage::getModel('indexa_nfe/sales_order_request')->getCollection()->addNfFilter( $id );
    }
    
    public function getLastErrorId( $id ){
        return Mage::getModel('indexa_nfe/sales_order_request')->getCollection()->addNfFilter( $id )
                    ->addStatusFilter( Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_ERROR )->getLastItem()->getId();
    }
    
    public function getLastFinishedId( $id ){
        return Mage::getModel('indexa_nfe/sales_order_request')->getCollection()->addNfFilter( $id )
                    ->addStatusFilter( array( Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_FINISHED,Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_PROCESSING) )->getLastItem()->getId();
    }
    
    
}
