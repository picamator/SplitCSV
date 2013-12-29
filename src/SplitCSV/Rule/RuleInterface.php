<?php
/**
 * Interface for Split Rule
 * 
 * @link        https://github.com/picamator/SplitCSV
 * @license     http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace SplitCSV\Rule;

interface RuleInterface
{
    /**
     * @param array $options
     */
    public function __construct(array $options);
    
    /**
     * Sets options
     * 
     * @param array $options
     * @return self
     * @throws Exception
     */
    public function setOptions(array $options); 
     
    /**
     * Check is file ready to be splitted
     * 
     * @param array $row
     * @return boolean
     */
    public function isSplit(array $row);
} 