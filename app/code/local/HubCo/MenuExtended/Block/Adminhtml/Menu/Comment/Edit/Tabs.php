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
 * Menu comment admin edit tabs
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Block_Adminhtml_Menu_Comment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('menu_comment_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('hubco_menuextended')->__('Menu Comment'));
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
            'form_menu_comment',
            array(
                'label'   => Mage::helper('hubco_menuextended')->__('Menu comment'),
                'title'   => Mage::helper('hubco_menuextended')->__('Menu comment'),
                'content' => $this->getLayout()->createBlock(
                    'hubco_menuextended/adminhtml_menu_comment_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_menu_comment',
                array(
                    'label'   => Mage::helper('hubco_menuextended')->__('Store views'),
                    'title'   => Mage::helper('hubco_menuextended')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'hubco_menuextended/adminhtml_menu_comment_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve comment
     *
     * @access public
     * @return HubCo_MenuExtended_Model_Menu_Comment
     * @author Ultimate Module Creator
     */
    public function getComment()
    {
        return Mage::registry('current_comment');
    }
}
