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
 * Menu comment edit form tab
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Block_Adminhtml_Menu_Comment_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return MenuExtended_Menu_Block_Adminhtml_Menu_Comment_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $menu = Mage::registry('current_menu');
        $comment    = Mage::registry('current_comment');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('comment_');
        $form->setFieldNameSuffix('comment');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'comment_form',
            array('legend'=>Mage::helper('hubco_menuextended')->__('Comment'))
        );
        $fieldset->addField(
            'menu_id',
            'hidden',
            array(
                'name'  => 'menu_id',
                'after_element_html' => '<a href="'.
                    Mage::helper('adminhtml')->getUrl(
                        'adminhtml/menuextended_menu/edit',
                        array(
                            'id'=>$menu->getId()
                        )
                    ).
                    '" target="_blank">'.
                    Mage::helper('hubco_menuextended')->__('Menu').
                    ' : '.$menu->getMenuName().'</a>'
            )
        );
        $fieldset->addField(
            'title',
            'text',
            array(
                'label'    => Mage::helper('hubco_menuextended')->__('Title'),
                'name'     => 'title',
                'required' => true,
                'class'    => 'required-entry',
            )
        );
        $fieldset->addField(
            'comment',
            'textarea',
            array(
                'label'    => Mage::helper('hubco_menuextended')->__('Comment'),
                'name'     => 'comment',
                'required' => true,
                'class'    => 'required-entry',
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'    => Mage::helper('hubco_menuextended')->__('Status'),
                'name'     => 'status',
                'required' => true,
                'class'    => 'required-entry',
                'values'   => array(
                    array(
                        'value' => HubCo_MenuExtended_Model_Menu_Comment::STATUS_PENDING,
                        'label' => Mage::helper('hubco_menuextended')->__('Pending'),
                    ),
                    array(
                        'value' => HubCo_MenuExtended_Model_Menu_Comment::STATUS_APPROVED,
                        'label' => Mage::helper('hubco_menuextended')->__('Approved'),
                    ),
                    array(
                        'value' => HubCo_MenuExtended_Model_Menu_Comment::STATUS_REJECTED,
                        'label' => Mage::helper('hubco_menuextended')->__('Rejected'),
                    ),
                ),
            )
        );
        $configuration = array(
             'label' => Mage::helper('hubco_menuextended')->__('Poster name'),
             'name'  => 'name',
             'required'  => true,
             'class' => 'required-entry',
        );
        if ($comment->getCustomerId()) {
            $configuration['after_element_html'] = '<a href="'.
                Mage::helper('adminhtml')->getUrl(
                    'adminhtml/customer/edit',
                    array(
                        'id'=>$comment->getCustomerId()
                    )
                ).
                '" target="_blank">'.
                Mage::helper('hubco_menuextended')->__('Customer profile').'</a>';
        }
        $fieldset->addField('name', 'text', $configuration);
        $fieldset->addField(
            'email',
            'text',
            array(
                'label' => Mage::helper('hubco_menuextended')->__('Poster e-mail'),
                'name'  => 'email',
                'required'  => true,
                'class' => 'required-entry',
            )
        );
        $fieldset->addField(
            'customer_id',
            'hidden',
            array(
                'name'  => 'customer_id',
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
            Mage::registry('current_comment')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $form->addValues($this->getComment()->getData());
        return parent::_prepareForm();
    }

    /**
     * get the current comment
     *
     * @access public
     * @return HubCo_MenuExtended_Model_Menu_Comment
     */
    public function getComment()
    {
        return Mage::registry('current_comment');
    }
}
