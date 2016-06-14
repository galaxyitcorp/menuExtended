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
 * Menu admin controller
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_Adminhtml_Menuextended_MenuController extends HubCo_MenuExtended_Controller_Adminhtml_MenuExtended
{
    /**
     * init the menu
     *
     * @access protected
     * @return HubCo_MenuExtended_Model_Menu
     */
    protected function _initMenu()
    {
        $menuId  = (int) $this->getRequest()->getParam('id');
        $menu    = Mage::getModel('hubco_menuextended/menu');
        if ($menuId) {
            $menu->load($menuId);
        }
        Mage::register('current_menu', $menu);
        return $menu;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('hubco_menuextended')->__('Menu'))
             ->_title(Mage::helper('hubco_menuextended')->__('Menu'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit menu - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $menuId    = $this->getRequest()->getParam('id');
        $menu      = $this->_initMenu();
        if ($menuId && !$menu->getId()) {
            $this->_getSession()->addError(
                Mage::helper('hubco_menuextended')->__('This menu no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getMenuData(true);
        if (!empty($data)) {
            $menu->setData($data);
        }
        Mage::register('menu_data', $menu);
        $this->loadLayout();
        $this->_title(Mage::helper('hubco_menuextended')->__('Menu'))
             ->_title(Mage::helper('hubco_menuextended')->__('Menu'));
        if ($menu->getId()) {
            $this->_title($menu->getMenuName());
        } else {
            $this->_title(Mage::helper('hubco_menuextended')->__('Add menu'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new menu action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save menu - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('menu')) {
            try {
                $menu = $this->_initMenu();
                $menu->addData($data);
                $menu->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('hubco_menuextended')->__('Menu was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $menu->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setMenuData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('hubco_menuextended')->__('There was a problem saving the menu.')
                );
                Mage::getSingleton('adminhtml/session')->setMenuData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('hubco_menuextended')->__('Unable to find menu to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete menu - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $menu = Mage::getModel('hubco_menuextended/menu');
                $menu->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('hubco_menuextended')->__('Menu was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('hubco_menuextended')->__('There was an error deleting menu.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('hubco_menuextended')->__('Could not find menu to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete menu - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $menuIds = $this->getRequest()->getParam('menu');
        if (!is_array($menuIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('hubco_menuextended')->__('Please select menu to delete.')
            );
        } else {
            try {
                foreach ($menuIds as $menuId) {
                    $menu = Mage::getModel('hubco_menuextended/menu');
                    $menu->setId($menuId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('hubco_menuextended')->__('Total of %d menu were successfully deleted.', count($menuIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('hubco_menuextended')->__('There was an error deleting menu.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $menuIds = $this->getRequest()->getParam('menu');
        if (!is_array($menuIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('hubco_menuextended')->__('Please select menu.')
            );
        } else {
            try {
                foreach ($menuIds as $menuId) {
                $menu = Mage::getSingleton('hubco_menuextended/menu')->load($menuId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d menu were successfully updated.', count($menuIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('hubco_menuextended')->__('There was an error updating menu.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'menu.csv';
        $content    = $this->getLayout()->createBlock('hubco_menuextended/adminhtml_menu_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'menu.xls';
        $content    = $this->getLayout()->createBlock('hubco_menuextended/adminhtml_menu_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'menu.xml';
        $content    = $this->getLayout()->createBlock('hubco_menuextended/adminhtml_menu_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('hubco_menuextended/menu');
    }
}
