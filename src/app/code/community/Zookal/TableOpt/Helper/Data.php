<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this Module to
 * newer versions in the future.
 *
 * @category    Zookal_TableOpt
 * @package     Model
 * @author      Cyrill Schumacher | {firstName}@{lastName}.fm | @SchumacherFM
 * @copyright   Copyright (c) Zookal Pty Ltd
 * @license     OSL - Open Software Licence 3.0 | http://opensource.org/licenses/osl-3.0.php
 */
class Zookal_TableOpt_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @var Magento_Db_Adapter_Pdo_Mysql
     */
    protected $_connection = null;

    /**
     * @var Mage_Core_Model_Store
     */
    protected $_store = null;

    /**
     * @param Mage_Core_Model_Store        $store
     * @param Magento_Db_Adapter_Pdo_Mysql $connection
     */
    public function __construct(Mage_Core_Model_Store $store = null, Magento_Db_Adapter_Pdo_Mysql $connection = null)
    {
        // sometimes those args are either null or '' :-(
        // With GoLang and static typing this would not happen :-)
        if (false === empty($store)) {
            $this->_store = $store;
        }
        if (false === empty($connection)) {
            $this->_connection = $connection;
        }
    }

    /**
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        if (null === $this->_store) {
            // @codeCoverageIgnoreStart
            $this->_store = Mage::app()->getStore();
        }
        // @codeCoverageIgnoreEnd
        return $this->_store;
    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function _getConfigArray($path)
    {
        $value = trim($this->getStore()->getConfig($path));
        if (true === empty($value)) {
            return array();
        }
        return explode(',', $value);
    }

    /**
     * @return array
     */
    public function getIncludedTables()
    {
        return $this->_getConfigArray('system/zookaltableopt/tables_include');
    }

    /**
     * @return array
     */
    public function getExcludedTables()
    {
        return $this->_getConfigArray('system/zookaltableopt/tables_exclude');
    }

    /**
     * @return bool
     */
    public function isSkipEmptyTables()
    {
        return (int)$this->getStore()->getConfig('system/zookaltableopt/skip_empty_tables') === 1;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return (int)$this->getStore()->getConfig('system/zookaltableopt/is_active') === 1;
    }

    /**
     * @return Magento_Db_Adapter_Pdo_Mysql
     */
    public function getConnection()
    {
        if (null === $this->_connection) {
            $this->_connection = Mage::getSingleton('core/resource')
                ->getConnection(Mage_Core_Model_Resource::DEFAULT_SETUP_RESOURCE);
        }
        return $this->_connection;
    }
}