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

class Easynfe_Nfe_Block_Customer_Account_Dashboard_Address extends Mage_Customer_Block_Account_Dashboard_Address
{
    public function getPrimaryShippingAddressHtml()
    {
        $address = $this->getCustomer()->getPrimaryShippingAddress();
        
        if( is_object($address)  && is_numeric( $address->getCity() ) ){
            $address->setCity( Mage::getModel('easynfe_nfe/directory_country_region_city')->load($address->getCity())->getName() );
        }
        
        if( $address instanceof Varien_Object ) {
            return $address->format('html');
        } else {
            return Mage::helper('customer')->__('You have not set a default shipping address.');
        }
    }

    public function getPrimaryBillingAddressHtml()
    {
        $address = $this->getCustomer()->getPrimaryBillingAddress();
        if( is_object($address)  && is_numeric( $address->getCity() ) ){
            $address->setCity( Mage::getModel('easynfe_nfe/directory_country_region_city')->load($address->getCity())->getName() );
        }

        if( $address instanceof Varien_Object ) {
            return $address->format('html');
        } else {
            return Mage::helper('customer')->__('You have not set a default billing address.');
        }
    }
}
