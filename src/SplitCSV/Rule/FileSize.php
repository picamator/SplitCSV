<?php
/**
 * File Size Split Rule
 * 
 * @link        https://github.com/picamator/SplitCSV
 * @license     http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace SplitCSV\Rule;

class FileSize extends AbstractRule
{   
    /**
     * File Size
     * 
     * @var integer
     */
    protected $file_size = 0;  
    
    /**
     * Options
     * 
     * @var array
     */
    protected $options = array('size' => null);
    
    /**
     * Check is file ready to be splitted
     * 
     * @param array $row
     * @return boolean
     */
    public function isSplit(array $row)
    {
        $this->file_size += $this->getRowSize($row);
        
        $result = false;
        if($this->file_size > $this->options['size']) {
            $result = true;
            // reset file_size
            $this->file_size = 0;
        }
        
        return $result;
    }
    
    /**
     * Sets options
     * 
     * @param array $options
     * @return self
     * @throws Exception
     */
    public function setOptions(array $options)
    {
        parent::setOptions($options);
        
        $this->options['size'] = $this->convertToBytes($this->options['size']);
        
        return  $this;
    }
    
    /**
     * Gets row size
     * 
     * @param array $row
     * @return integer
     */
    protected function getRowSize(array $row) 
    {
        $result = 0;
        foreach($row as $item) {
            $result += strlen($item);
        }
        
        return $result;
    }
    
    /**
     * Convert Size to bytes
     * e.g: 2kb = 2048
     * 
     * @param string $from
     * @return integer
     */
    protected function convertToBytes($from)
    {
        $number = substr($from, 0, -2);
        switch(strtoupper(substr($from,-2))) {
            case 'KB':
                $result = $number*1024;
                break;
            
            case 'MB':
                $result = $number*pow(1024,2);
                break;
            
            case 'GB':
                $result = $number*pow(1024,3);
                break;
            
            case 'TB':
                $result = $number*pow(1024,4);
                break;
            
            case 'PB':
                $result = $number*pow(1024,5);
                break;
            
             default:
                $result = $from;
                break; 
        }
        
        return $result;
    }
}