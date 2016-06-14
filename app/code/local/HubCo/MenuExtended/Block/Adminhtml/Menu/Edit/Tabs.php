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
 * Menu admin edit tabs
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Block_Adminhtml_Menu_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('menu_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('hubco_menuextended')->__('Menu'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return HubCo_MenuExtended_Block_Adminhtml_Menu_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_menu',
            array(
                'label'   => Mage::helper('hubco_menuextended')->__('Menu'),
                'title'   => Mage::helper('hubco_menuextended')->__('Menu'),
                'content' => $this->getLayout()->createBlock(
                    'hubco_menuextended/adminhtml_menu_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'form_meta_menu',
            array(
                'label'   => Mage::helper('hubco_menuextended')->__('Meta'),
                'title'   => Mage::helper('hubco_menuextended')->__('Meta'),
                'content' => $this->getLayout()->createBlock(
                    'hubco_menuextended/adminhtml_menu_edit_tab_meta'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_menu',
                array(
                    'label'   => Mage::helper('hubco_menuextended')->__('Store views'),
                    'title'   => Mage::helper('hubco_menuextended')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'hubco_menuextended/adminhtml_menu_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve menu entity
     *
     * @access public
     * @return HubCo_MenuExtended_Model_Menu
     * @author Ultimate Module Creator
     */
    public function getMenu()
    {
        return Mage::registry('current_menu');
    }
}
