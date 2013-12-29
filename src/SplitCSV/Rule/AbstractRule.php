<?php
/**
 * Abstract for Split Rule
 * 
 * @link        https://github.com/picamator/SplitCSV
 * @license     http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace SplitCSV\Rule;

abstract class AbstractRule implements RuleInterface
{
    /**
     * Options
     * 
     * @var array 
     */
    protected $options;
    
    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->setOptions($options);
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
        // validate requred options
        $options = array_merge($this->options, $options);
        $options = array_filter($options, function($item){
           return !is_null($item); 
        });
                
        $required = array_diff_key($this->options, $options);        
        if(!empty($required)) {
            throw new Exception('Error: Incorrect options for Split Rule. Option(s) "'.implode(', ', array_keys($required)).'" did not set. Please set correct data and try again.');
        } 
          
        $this->options = $options;
        
        return $this;
    }
} 
