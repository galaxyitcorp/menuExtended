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
 * Menu widget block
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Block_Menu_Widget_View extends Mage_Core_Block_Template implements
    Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'hubco_menuextended/menu/widget/view.phtml';

    /**
     * Prepare a for widget
     *
     * @access protected
     * @return HubCo_MenuExtended_Block_Menu_Widget_View
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $menuId = $this->getData('menu_id');
        if ($menuId) {
            $menu = Mage::getModel('hubco_menuextended/menu')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($menuId);
            if ($menu->getStatus()) {
                $this->setCurrentMenu($menu);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }
}
