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
 * Menu list block
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author Ultimate Module Creator
 */
class HubCo_MenuExtended_Block_Menu_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $menus = Mage::getResourceModel('hubco_menuextended/menu_collection')
                         ->addStoreFilter(Mage::app()->getStore())
                         ->addFieldToFilter('status', 1);
        $menus->setOrder('menu_name', 'asc');
        $this->setMenus($menus);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return HubCo_MenuExtended_Block_Menu_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'hubco_menuextended.menu.html.pager'
        )
        ->setCollection($this->getMenus());
        $this->setChild('pager', $pager);
        $this->getMenus()->load();
        return $this;
    }

    /**
     * get the pager html
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
