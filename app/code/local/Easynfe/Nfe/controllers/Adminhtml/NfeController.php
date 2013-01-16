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

class Easynfe_Nfe_Adminhtml_NfeController extends Mage_Adminhtml_Controller_Action
{
    protected function _initRequest()
    {
        $id = $this->getRequest()->getParam('id');
        $mRequest = Mage::getModel('easynfe_nfe/sales_order_request');
        
        if ($id) {
            $mRequest->load($id);
        }

        Mage::register('nfe_data', $mRequest);
        return $this;
    }
    
    public function getNfeRequest(){
        if( Mage::registry('nfe_data') ){
            return Mage::registry('nfe_data');
        }
        return false;
    }
    
    public function saveAction(){
        $this->_initRequest();
        $nfId = Mage::getModel('easynfe_nfe/sales_order_request')->load( Mage::registry('nfe_data')->getId() )->getNfeNfId();
        $orderId = Mage::getModel('easynfe_nfe/sales_order')->load( Mage::getModel('easynfe_nfe/sales_order_nf')->load( $nfId )->getNfOrderId() )->getOrderId();
       
        $mRequest = Mage::getModel('easynfe_nfe/sales_order_request');
        $aParams = Zend_Json::decode( Mage::registry('nfe_data')->getRequest() );
        
        $newRequest['nfe.NFe'] = $this->getRequest()->getParam('nfe_NFe');
        
        $aParams['nfe.NFe']['nfe.infNFe'] = array_merge( $aParams['nfe.NFe']['nfe.infNFe'], $newRequest['nfe.NFe']['nfe.infNFe']);
        
        
        $mRequest->setData('request', Zend_Json::encode($aParams));
        $mRequest->setData('nfe_nf_id', $nfId );
        $mRequest->setData('status', Easynfe_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_CREATED);
        $mRequest->setData('created_at', date('Y-m-d H:i:s'));
        
        $mRequest->save();
        
        
       if( Mage::getStoreConfig('easynfe_nfe/config/tpamb') == '1' ){
            $url = Easynfe_Nfe_Model_Nfe::NFE_REQUEST_PUT_URL;
        }else{
            $url = Easynfe_Nfe_Model_Nfe::NFE_TEST_REQUEST_PUT_URL;
        }

        /**
         * prepare curl request
         */
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_TIMEOUT => 120,
	    CURLOPT_USERPWD => Mage::getStoreConfig('easynfe_nfe/acesso/chave') . ":" . Mage::getStoreConfig('easynfe_nfe/acesso/pass'),
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_POSTFIELDS => Zend_Json::encode($aParams),
            //CURLOPT_POST=> true,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_RETURNTRANSFER => true
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, ($defaults));
        $result = curl_exec($ch);

        if (!$result) {
            $message = curl_error($ch);
            $mRequest->setData('status', Easynfe_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_ERROR);
        } else {
            $message = $result;
            $mRequest->setData('status', Easynfe_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_PROCESSING);
        }

        curl_close($ch);

        $mRequest->setData('messages', $message);

        $mRequest->setData('executed_at', date('Y-m-d H:i:s'));
        $mRequest->save();
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('catalog')->__('Reenvio de NFe gerado com sucesso.'));
        $this->_redirectUrl(  Mage::getUrl('adminhtml/sales_order/view', array('order_id'=>$orderId)) );
    }
    
    
    public function editAction(){
        $this->_initRequest();
        $id = $this->getRequest()->getParam('id');
       
        
        
        $this->loadLayout();
        $this->_initLayoutMessages('adminhtml/session');

        $this->renderLayout();
    }
    
    public function indexAction()
    {
        $this->_forward('edit');
    }
    /**
     * download and save xml file
     */
    public function xmlAction(){
        $key = $this->getRequest()->getParam('id');
        
        $file_name = Mage::getBaseDir('media') . '/nf/xml/'.$key.'.xml';
         
        header('Content-Description: File Transfer');
        header('Content-Type: text/xml');
        header('Content-Disposition: attachment; filename='.basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        $this->getResponse()->setBody( file_get_contents( $file_name ) );
        
    }
    
    /**
     * download and save pdf file
     */
    public function pdfAction(){

        $key = $this->getRequest()->getParam('id');
         
        $file_name = Mage::getBaseDir('media') . '/nf/pdf/'.$key.'.pdf';
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename='.basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        $this->getResponse()->setBody( file_get_contents( $file_name ) );
        
    }
}
