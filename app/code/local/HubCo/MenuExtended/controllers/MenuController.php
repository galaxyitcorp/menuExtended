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
 * Menu front contrller
 *
 * @category    HubCo
 * @package     HubCo_MenuExtended
 * @author      Ultimate Module Creator
 */
class HubCo_MenuExtended_MenuController extends Mage_Core_Controller_Front_Action
{

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
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('hubco_menuextended/menu')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('hubco_menuextended')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'menus',
                    array(
                        'label' => Mage::helper('hubco_menuextended')->__('Menu'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('hubco_menuextended/menu')->getMenusUrl());
        }
        if ($headBlock) {
            $headBlock->setTitle(Mage::getStoreConfig('hubco_menuextended/menu/meta_title'));
            $headBlock->setKeywords(Mage::getStoreConfig('hubco_menuextended/menu/meta_keywords'));
            $headBlock->setDescription(Mage::getStoreConfig('hubco_menuextended/menu/meta_description'));
        }
        $this->renderLayout();
    }

    /**
     * init Menu
     *
     * @access protected
     * @return HubCo_MenuExtended_Model_Menu
     * @author Ultimate Module Creator
     */
    protected function _initMenu()
    {
        $menuId   = $this->getRequest()->getParam('id', 0);
        $menu     = Mage::getModel('hubco_menuextended/menu')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($menuId);
        if (!$menu->getId()) {
            return false;
        } elseif (!$menu->getStatus()) {
            return false;
        }
        return $menu;
    }

    /**
     * view menu action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $menu = $this->_initMenu();
        if (!$menu) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_menu', $menu);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('menuextended-menu menuextended-menu' . $menu->getId());
        }
        if (Mage::helper('hubco_menuextended/menu')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('hubco_menuextended')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'menus',
                    array(
                        'label' => Mage::helper('hubco_menuextended')->__('Menu'),
                        'link'  => Mage::helper('hubco_menuextended/menu')->getMenusUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'menu',
                    array(
                        'label' => $menu->getMenuName(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $menu->getMenuUrl());
        }
        if ($headBlock) {
            if ($menu->getMetaTitle()) {
                $headBlock->setTitle($menu->getMetaTitle());
            } else {
                $headBlock->setTitle($menu->getMenuName());
            }
            $headBlock->setKeywords($menu->getMetaKeywords());
            $headBlock->setDescription($menu->getMetaDescription());
        }
        $this->renderLayout();
    }

    /**
     * menu rss list action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function rssAction()
    {
        if (Mage::helper('hubco_menuextended/menu')->isRssEnabled()) {
            $this->getResponse()->setHeader('Content-type', 'text/xml; charset=UTF-8');
            $this->loadLayout(false);
            $this->renderLayout();
        } else {
            $this->getResponse()->setHeader('HTTP/1.1', '404 Not Found');
            $this->getResponse()->setHeader('Status', '404 File not found');
            $this->_forward('nofeed', 'index', 'rss');
        }
    }

    /**
     * Submit new comment action
     * @access public
     * @author Ultimate Module Creator
     */
    public function commentpostAction()
    {
        $data   = $this->getRequest()->getPost();
        $menu = $this->_initMenu();
        $session    = Mage::getSingleton('core/session');
        if ($menu) {
            if ($menu->getAllowComments()) {
                if ((Mage::getSingleton('customer/session')->isLoggedIn() ||
                    Mage::getStoreConfigFlag('hubco_menuextended/menu/allow_guest_comment'))) {
                    $comment  = Mage::getModel('hubco_menuextended/menu_comment')->setData($data);
                    $validate = $comment->validate();
                    if ($validate === true) {
                        try {
                            $comment->setMenuId($menu->getId())
                                ->setStatus(HubCo_MenuExtended_Model_Menu_Comment::STATUS_PENDING)
                                ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                                ->setStores(array(Mage::app()->getStore()->getId()))
                                ->save();
                            $session->addSuccess($this->__('Your comment has been accepted for moderation.'));
                        } catch (Exception $e) {
                            $session->setMenuCommentData($data);
                            $session->addError($this->__('Unable to post the comment.'));
                        }
                    } else {
                        $session->setMenuCommentData($data);
                        if (is_array($validate)) {
                            foreach ($validate as $errorMessage) {
                                $session->addError($errorMessage);
                            }
                        } else {
                            $session->addError($this->__('Unable to post the comment.'));
                        }
                    }
                } else {
                    $session->addError($this->__('Guest comments are not allowed'));
                }
            } else {
                $session->addError($this->__('This menu does not allow comments'));
            }
        }
        $this->_redirectReferer();
    }
}
