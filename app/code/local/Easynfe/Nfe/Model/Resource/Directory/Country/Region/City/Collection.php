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


class Easynfe_Nfe_Model_Resource_Directory_Country_Region_City_Collection extends Easynfe_Nfe_Model_Resource_Db_Collection_Abstract{
    
    /**
     * Initialize resource
     *
     */
    public function _construct(){
        $this->_init('easynfe_nfe/directory_country_region_city');
    }
    
    /**
     * Initialize select object
     *
     * @return Easynfe_Nfe_Model_Resource_Directory_Country_Region_City_Collection
     */
    public function _initSelect()
    {
        parent::_initSelect();
        /**
         * join with nf_directory_country_region
         */
        $this->getSelect()->joinLeft(
            array('rname' => 'nfe_directory_country_region'),
            'main_table.region_id = rname.id',
            array('region_id'));

        return $this;
    }
    
    /**
     * Filter by NF region
     *
     * @param string|array $nfeRegionId
     * @return Easynfe_Nfe_Model_Resource_Directory_Country_Region_City_Collection
     */
    public function addNfRegionFilter($nfeRegionId)
    {
        if (!empty($nfeRegionId)) {
            if (is_array($nfeRegionId)) {
                $this->addFieldToFilter('main_table.region_id', array('in' => $nfeRegionId));
            } else {
                $this->addFieldToFilter('main_table.region_id', $nfeRegionId);
            }
        }
        return $this;
    }
    
    /**
     * Filter by region
     *
     * @param string|array $RegionId
     * @return Easynfe_Nfe_Model_Resource_Directory_Country_Region_City_Collection
     */
    public function addRegionFilter($RegionId)
    {
        if (!empty($RegionId)) {
            if (is_array($RegionId)) {
                $this->addFieldToFilter('rname.region_id', array('in' => $RegionId));
            } else {
                $this->addFieldToFilter('rname.region_id', $RegionId);
            }
        }
        return $this;
    }
    
    /**
     * Filter by region
     *
     * @param string $attribute
     * 
     * @return Easynfe_Nfe_Model_Resource_Directory_Country_Region_City_Collection
     */
    public function orderByName()
    {
        parent::addOrder('name', 'ASC');
        return $this;
    }
    
}

