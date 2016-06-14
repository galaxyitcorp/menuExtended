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
 * Menu admin edit form
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Block_Adminhtml_Menu_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'hubco_menuextended';
        $this->_controller = 'adminhtml_menu';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('hubco_menuextended')->__('Save Menu')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('hubco_menuextended')->__('Delete Menu')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('hubco_menuextended')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_menu') && Mage::registry('current_menu')->getId()) {
            return Mage::helper('hubco_menuextended')->__(
                "Edit Menu '%s'",
                $this->escapeHtml(Mage::registry('current_menu')->getMenuName())
            );
        } else {
            return Mage::helper('hubco_menuextended')->__('Add Menu');
        }
    }
}
