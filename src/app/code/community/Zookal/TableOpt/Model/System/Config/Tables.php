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
class Zookal_TableOpt_Model_System_Config_Tables
{
    protected $_tables = null;

    /**
     * @var Magento_Db_Adapter_Pdo_Mysql
     */
    protected $_connection = null;

    /**
     * @param Magento_Db_Adapter_Pdo_Mysql $connection
     */
    public function __construct($connection = null)
    {
        if ($connection) {
            $this->_connection = $connection;
        }
    }

    /**
     * @return Magento_Db_Adapter_Pdo_Mysql
     */
    public function getConnection()
    {
        if (null === $this->_connection) {
            // @codeCoverageIgnoreStart
            $this->_connection = Mage::getSingleton('core/resource')
                ->getConnection(Mage_Core_Model_Resource::DEFAULT_SETUP_RESOURCE);
        }
        // @codeCoverageIgnoreEnd
        return $this->_connection;
    }

    /**
     * @return array
     */
    public function getTables()
    {
        if (null === $this->_tables) {
            $this->_tables = $this->getConnection()->listTables();
        }
        return $this->_tables;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $return   = array();
        $return[] = array('value' => '', 'label' => '');
        foreach ($this->getTables() as $table) {
            $return[] = array('value' => $table, 'label' => $table);
        }
        return $return;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toOptionHash()
    {
        $options = array();
        foreach ($this->toOptionArray() as $option) {
            $key           = $option['value'];
            $options[$key] = $option['label'];
        }
        return $options;
    }
}
