<?php
/**
 * @category    Zookal_TableOpt
 * @package     Model
 * @author      Cyrill Schumacher | {firstName}@{lastName}.fm | @SchumacherFM
 * @copyright   Copyright (c) Zookal Pty Ltd
 * @license     OSL - Open Software Licence 3.0 | http://opensource.org/licenses/osl-3.0.php
 */

require_once 'abstract.php';

/**
 * Magento Log Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Zookal_Table_Opt extends Mage_Shell_Abstract
{

    /**
     * Run script
     *
     */
    public function run()
    {
        if ($this->getArg('run')) {

            Mage::getModel('zookal_tableopt/optimize')->setCli(true)->run();

            echo "Tables optimized\n";
        } elseif ($this->getArg('status')) {
            echo "Status Ok\n";
        } else {
            echo $this->usageHelp();
        }
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f tableOpt.php -- [options]
        php -f tableOpt.php -- run

  run               Runs the optimization process
  status            Display statistics per table
  help              This help

USAGE;
    }
}

$shell = new Zookal_Table_Opt();
$shell->run();
