<?php
/**
 * Abstract for core SplitCSV
 * 
 * @link        https://github.com/picamator/SplitCSV
 * @license     http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace SplitCSV;

abstract class AbstractFile implements FileInterface
{
    /**
     * CSV delimiter
     * 
     * @var string 
     */
    protected $delimiter = ';';
    
    /**
     * CSV enclosure
     * 
     * @var string 
     */
    protected $enclosure = '"';
    
    /**
     * Prefix of name for part files
     * 
     * @var string
     */
    protected $prefix = '-part-';
    
    /**
     * Number of rows from original file that
     * was copied for every parts
     * 
     * @var string 
     */
    protected $header = 1;
    
    /**
     * Path to source CSV file
     *  
     * @var string 
     */
    protected $source_path;
    
    /**
     * Derstination path with rw permission
     * 
     * @var string 
     */
    protected $destination_path;
    
    /**
     * Source file
     *  
     * @var source
     */
    protected $file;
    
    /**
     * @param string $source_path
     * @param string $destination_path
     */
    public function __construct($source_path, $destination_path)
    {
        $this->setSourcePath($source_path);
        $this->setDestinationPath($destination_path);
        
        $this->setFile($source_path);
    }
    
    /**
     * Sets CSV dilimiter
     * 
     * @param string $delimiter
     * @return self
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        
        return $this;
    }
    
    /**
     * Sets CSV enclosere
     * 
     * @param string $enclosure
     * @return self
     */
    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;
        
        return $this;
    }
    
    /**
     * Sets file parts name prefix
     * 
     * @param string $prefix
     * @return self
     * @throws Exception
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        
        return $this;
    }
    
    /**
     * Sets number of row for header
     * such rows were copyed for each part file
     * 
     * @param integer $header
     * @return self
     */
    public function setHeader($header)
    {
        $header = intval($header);
        if($header !== 0) {
            $this->header = $header;
        }
        
        return $this;
    }
    
    /**
     * Split file by the rule
     * Original file is not changed
     * 
     * @param \SplitCSV\Rule\RuleInterface $rule
     * @return integer - number of parts
     */
    public function splitBy(Rule\RuleInterface $rule)
    {
        // get number of rows and header
        $row_number  = 0;
        $header      = array();
        while (($row = fgetcsv($this->file, null, $this->delimiter, $this->enclosure)) !== FALSE) {
            $row_number++;
            
            // get headers row
            if ($row_number <= $this->header) {
                $header[] = $row;
            }
        }  
        
        // run
        $i          = 0;
        $result     = 1;
        $file_part  = $this->getFilePart($result);
        $this->addFilePartHeader($file_part, $header); 
        
        rewind($this->file);
        while (($row = fgetcsv($this->file, null, $this->delimiter, $this->enclosure)) !== FALSE) {
            $i++;
            
            // skip headers row
            if ($i <= $this->header) {
                continue;
            }
            
            // write data to part file
            $this->fputCsv($file_part, $row);
            
            // check for split and privent create empty file for last row
            if ($i != $row_number && $rule->isSplit($row)) { 
                $result++; 
                fclose($file_part);
              
                $file_part = $this->getFilePart($result);
                $this->addFilePartHeader($file_part, $header); // add header
            }
        }
        
        // close last file part
        fclose($file_part);
        
        return $result;
    }
    
    /**
     * Put data to CSV file
     * 
     * @param source $file
     * @param array $data
     * @return void
     */
    protected function fputCsv($file, array $data)
    {
        fputcsv($file, $data, $this->delimiter, $this->enclosure);
    }
    
    /**
     * Add header to the file part
     * 
     * @param type      $file
     * @param array     $header
     * @return void
     */
    protected function addFilePartHeader($file, array $header)
    {
        foreach($header as $item) {
            $this->fputCsv($file, $item);
        }
    }
    
    /**
     * Gets File Part
     * 
     * @param integer $part_number
     * @return source
     */
    protected function getFilePart($part_number)
    {
        $file_path = $this->destination_path.DIRECTORY_SEPARATOR.
                basename($this->source_path, '.csv').
                $this->prefix.$part_number.'.csv';
        
        return fopen($file_path , 'w+');
    }
    
    /**
     * Sets Source Path
     * 
     * @param string $source_path
     * @return void
     * @throws Exception
     */
    protected function setSourcePath($source_path)
    {
        if(!file_exists($source_path)) {
            throw new Exception('Error: CSV file as not found in destination "'.$source_path.'". Please correct path and try again.');
        }
        
        $this->source_path = $source_path;
    }
    
    /**
     * Sets Destination Path
     * 
     * @param string $destination_path
     * @return void
     * @throws Exception
     */
    protected function setDestinationPath($destination_path)
    {
         if(!file_exists($destination_path) || !is_writable($destination_path)) {
            throw new Exception('Error: Wrong or not writable permission for destination path "'.$destination_path.'". Please correct path and try again.');
         }
         
         $this->destination_path = $destination_path;
    }
    
    /**
     * Sets file
     * 
     * @param string $source_path
     * @return self
     */
    protected function setFile($source_path)
    {     
        $this->file = fopen($source_path, 'r');
    }
}
