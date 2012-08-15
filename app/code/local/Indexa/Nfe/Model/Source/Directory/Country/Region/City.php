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
class Indexa_Nfe_Model_Source_Directory_Country_Region_City {

    /**
     * Retrieve NF-e cities
     *
     * @return array
     */
    public function toOptionArray(){
        //$mCity = Mage::getModel('indexa_nfe/directory_country_region_city')->getCollection();
        /* @var Indexa_Nfe_Model_Directory_Country_Region_Collection */
        /*
        if (count($mCity) > 0) {
            foreach ($mCity as $key => $cities) {

                $aResult[$key]['value'] = $cities->getId();
                $aResult[$key]['label'] = $cities->getName();
            }
        }
        return $aResult;
        */
        
        /**
         * result is loaded from ajax request filtered by region
         */
        return array();
      
    }

}
