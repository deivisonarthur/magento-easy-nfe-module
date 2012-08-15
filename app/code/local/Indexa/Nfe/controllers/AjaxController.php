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

class Indexa_Nfe_AjaxController extends Mage_Core_Controller_Front_Action
{
    public function  loadAction(){
        
        $uf = $this->getRequest()->getParam('uf');
        $filter = $this->getRequest()->getParam('filter');
        
        if( $uf ){
            if( 'region' == $filter )
                $mCity = Mage::getModel('indexa_nfe/directory_country_region_city')->getCollection()->orderByName()->addRegionFilter( $uf );
            else
                $mCity = Mage::getModel('indexa_nfe/directory_country_region_city')->getCollection()->orderByName()->addNfRegionFilter( $uf );    
            if (count($mCity) > 0) {
                $key = 0;
                foreach ($mCity as $cities) {
                    $aResult[$key]['value'] = $cities->getId();
                    $aResult[$key]['label'] = $cities->getName();
                    
                    if( $filter && Mage::getStoreConfig('indexa_nfe/'.str_replace( '-', '/', $filter ) ) == $cities->getId()  )
                        $aResult[$key]['selected'] = true;
                    $key++;
                }
            }
        }
        
        //$this->getResponse()
        //->clearHeaders()->setHeader('Content-Type', 'text/html; charset=utf-8');

    //    $this->getResponse()->setBody( Zend_Json::encode(array ('items' => 'aaa') ) );
        $this->getResponse()->setBody( Zend_Json::encode(  $aResult ) );
    }
}