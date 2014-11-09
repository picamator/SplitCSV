<?php
/**
 * Interface for core SplitCSV
 * 
 * @link        https://github.com/picamator/SplitCSV
 * @license     http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace SplitCSV;

interface FileInterface
{   
    /**
     * @param string $source_path
     * @param string $destination_path
     */
    public function __construct($source_path, $destination_path);
    
    /**
     * Sets CSV dilimiter
     * 
     * @param string $delimiter
     * @return self
     */
    public function setDelimiter($delimiter);
    
    /**
     * Sets CSV enclosere
     * 
     * @param string $enclosure
     * @return self
     */
    public function setEnclosure($enclosure);
    
    /**
     * Sets file parts name prefix
     * 
     * @param string $prefix
     * @return self
     */
    public function setPrefix($prefix);
    
    /**
     * Sets number of row for header
     * such rows were copyed for each part file
     * 
     * @param integer $row_number
     * @return self
     */
    public function setHeader($row_number);
    
    /**
     * Split file by the rule
     * Original file is not changed
     * 
     * @param \SplitCSV\Rule\RuleInterface $rule
     * @return integer - number of parts
     */
    public function splitBy(Rule\RuleInterface $rule);
}
