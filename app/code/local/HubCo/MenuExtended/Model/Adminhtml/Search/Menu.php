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
 * Admin search model
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Model_Adminhtml_Search_Menu extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return HubCo_MenuExtended_Model_Adminhtml_Search_Menu
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('hubco_menuextended/menu_collection')
            ->addFieldToFilter('menu_name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $menu) {
            $arr[] = array(
                'id'          => 'menu/1/'.$menu->getId(),
                'type'        => Mage::helper('hubco_menuextended')->__('Menu'),
                'name'        => $menu->getMenuName(),
                'description' => $menu->getMenuName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/menuextended_menu/edit',
                    array('id'=>$menu->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
