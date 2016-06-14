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
 * Menu customer comments list
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Block_Menu_Customer_Comment_View extends Mage_Customer_Block_Account_Dashboard
{
    /**
     * get current comment
     *
     * @access public
     * @return HubCo_MenuExtended_Model_Menu_Comment
     * @author Ultimate Module Creator
     */
    public function getComment()
    {
        return Mage::registry('current_comment');
    }

    /**
     * get current menu
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
