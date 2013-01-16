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
class Easynfe_Nfe_Model_Source_Directory_Country_Region_City {

    /**
     * Retrieve NF-e cities
     *
     * @return array
     */
    public function toOptionArray(){
        //$mCity = Mage::getModel('easynfe_nfe/directory_country_region_city')->getCollection();
        /* @var Easynfe_Nfe_Model_Directory_Country_Region_Collection */
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
