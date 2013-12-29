<?php
/**
 * Number Row Split Rule
 * 
 * @link        https://github.com/picamator/SplitCSV
 * @license     http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace SplitCSV\Rule;

class NumberRow extends AbstractRule
{   
    /**
     * Number of rows
     * 
     * @var integer
     */
    protected $number_row = 0;  
    
    /**
     * Options
     * 
     * @var array
     */
    protected $options = array('number_row' => null);
    
    /**
     * Check is file ready to be splitted
     * 
     * @param array $row
     * @return boolean
     */
    public function isSplit(array $row)
    {
        $this->number_row++;
        
        $result = false;
        if($this->number_row >= $this->options['number_row']) {
            $result = true;
            // reset file_size
            $this->number_row = 0;
        }
        
        return $result;
    }
}
