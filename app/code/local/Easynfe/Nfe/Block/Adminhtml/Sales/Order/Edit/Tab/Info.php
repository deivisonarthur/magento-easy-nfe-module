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
class Easynfe_Nfe_Block_Adminhtml_Sales_Order_Edit_Tab_Info extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('customer/tab/newsletter.phtml');
    }

    public function initForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('_newsletter');
        $customer = Mage::registry('current_customer');
        $subscriber = Mage::getModel('newsletter/subscriber')->loadByCustomer($customer);
        Mage::register('subscriber', $subscriber);

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('customer')->__('Newsletter Information')));

        $fieldset->addField('subscription', 'checkbox',
             array(
                    'label' => Mage::helper('customer')->__('Subscribed to Newsletter?'),
                    'name'  => 'subscription'
             )
        );

        if ($customer->isReadonly()) {
            $form->getElement('subscription')->setReadonly(true, true);
        }

        $form->getElement('subscription')->setIsChecked($subscriber->isSubscribed());

        if($changedDate = $this->getStatusChangedDate()) {
             $fieldset->addField('change_status_date', 'label',
                 array(
                        'label' => $subscriber->isSubscribed() ? Mage::helper('customer')->__('Last Date Subscribed') : Mage::helper('customer')->__('Last Date Unsubscribed'),
                        'value' => $changedDate,
                        'bold'  => true
                 )
            );
        }


        $this->setForm($form);
        return $this;
    }

    public function getStatusChangedDate()
    {
        $subscriber = Mage::registry('subscriber');
        if($subscriber->getChangeStatusAt()) {
            return $this->formatDate($subscriber->getChangeStatusAt(), Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM, true);
        }

        return null;
    }

    protected function _prepareLayout()
    {
        $this->setChild('grid',
            $this->getLayout()->createBlock('adminhtml/customer_edit_tab_newsletter_grid','newsletter.grid')
        );
        return parent::_prepareLayout();
    }

}
