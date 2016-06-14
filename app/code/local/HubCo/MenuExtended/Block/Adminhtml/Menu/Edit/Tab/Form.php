<?php
/**
 * HubCo_MenuExtended extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       HubCo
 * @package        HubCo_MenuExtended
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Menu edit form tab
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Block_Adminhtml_Menu_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return HubCo_MenuExtended_Block_Adminhtml_Menu_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('menu_');
        $form->setFieldNameSuffix('menu');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'menu_form',
            array('legend' => Mage::helper('hubco_menuextended')->__('Menu'))
        );

        $fieldset->addField(
            'menu_name',
            'text',
            array(
                'label' => Mage::helper('hubco_menuextended')->__('Menu Name'),
                'name'  => 'menu_name',
                'required'  => true,
                'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('hubco_menuextended')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('hubco_menuextended')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('hubco_menuextended')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('hubco_menuextended')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('hubco_menuextended')->__('Disabled'),
                    ),
                ),
            )
        );
        $fieldset->addField(
            'in_rss',
            'select',
            array(
                'label'  => Mage::helper('hubco_menuextended')->__('Show in rss'),
                'name'   => 'in_rss',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('hubco_menuextended')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('hubco_menuextended')->__('No'),
                    ),
                ),
            )
        );
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_menu')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $fieldset->addField(
            'allow_comment',
            'select',
            array(
                'label' => Mage::helper('hubco_menuextended')->__('Allow Comments'),
                'name'  => 'allow_comment',
                'values'=> Mage::getModel('hubco_menuextended/adminhtml_source_yesnodefault')->toOptionArray()
            )
        );
        $formValues = Mage::registry('current_menu')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getMenuData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getMenuData());
            Mage::getSingleton('adminhtml/session')->setMenuData(null);
        } elseif (Mage::registry('current_menu')) {
            $formValues = array_merge($formValues, Mage::registry('current_menu')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
