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

class Indexa_Nfe_Model_Source_Directory_Country
{
    /**
     * Retrieve NF-e coutries
     *
     * @return array
     */
    public function toOptionArray(){
        $mCountry = Mage::getModel('indexa_nfe/directory_country')->getCollection();
        /* @var Indexa_Nfe_Model_Directory_Country_Collection */

        if (count($mCountry) > 0) {
            foreach ($mCountry as $key => $countries) {

                $aResult[$key]['value'] = $countries->getId();
                $aResult[$key]['label'] = Mage::app()->getLocale()->getCountryTranslation($countries->getCountryId());
            }
        }

        return $aResult;
    }
}
