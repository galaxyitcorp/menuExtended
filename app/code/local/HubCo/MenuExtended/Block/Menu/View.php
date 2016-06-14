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
 * Menu view block
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Block_Menu_View extends Mage_Core_Block_Template
{
    /**
     * get the current menu
     *
     * @access public
     * @return mixed (HubCo_MenuExtended_Model_Menu|null)
     * @author Ultimate Module Creator
     */
    public function getCurrentMenu()
    {
        return Mage::registry('current_menu');
    }
}
