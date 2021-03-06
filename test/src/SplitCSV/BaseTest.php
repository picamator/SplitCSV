<?php
/**
 * Base SplitCSV UnitTest
 * 
 * @link        https://github.com/picamator/SplitCSV
 * @license     http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

abstract class BaseTest extends PHPUnit_Framework_TestCase 
{
    /**
     * Path to the data folder
     * 
     * @var string 
     */
    protected $data_path = './test/data/';
    
    /**
     * Template methods runs once for each test method
     * of the test case class 
     */
    protected function setUp()
    {
        
    }
    
    /**
     * Gets full path to data
     * 
     * @param string $path
     * @retutn string
     */
    protected function getDataPath($path)
    {        
        return realpath($this->data_path . $path);
    }
}