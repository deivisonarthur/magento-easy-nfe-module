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

class Indexa_Nfe_Model_Source_Directory_Country_Region
{
    /**
     * Retrieve NF-e regions
     *
     * @return array
     */
    public function toOptionArray(){
        
        $mRegion = Mage::getModel('indexa_nfe/directory_country_region')->getCollection();
        /* @var Indexa_Nfe_Model_Directory_Country_Region_Collection */

        if (count($mRegion) > 0) {
            foreach ($mRegion as $key => $regions) {

                $aResult[$key]['value'] = $regions->getId();
                $aResult[$key]['label'] = Mage::getModel('directory/region')->load( $regions->getRegionId() )->getDefaultName();
            }
        }

        return $aResult;
    }
}
