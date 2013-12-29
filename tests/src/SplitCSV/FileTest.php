<?php
/**
 * File Test
 * 
 * @link        https://github.com/picamator/SplitCSV
 * @license     http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace SplitCSV;

class FileTest extends BaseTest
{
    /**
     * @dataProvider    providerSplitBy
     * @param string    $source_path
     * @param string    $destination_path
     * @param \SplitCSV\Rule\RuleInterface  $rule
     * @param integer   $exptected_parts
     */
    public function testSplitBy($source_path, $destination_path, \SplitCSV\Rule\RuleInterface $rule, $exptected_parts)
    {
        // get full path
        $source_path        = $this->getDataPath($source_path);
        $destination_path   = $this->getDataPath($destination_path); 
          
        // create file obj and decorate them
        $split          = new File($source_path, $destination_path);
        
        $actual_parts   = $split->splitBy($rule);
        
        // asserts
        $this->assertEquals($exptected_parts, $actual_parts);
        
        // assert real number of created files
        $iterator   = new \DirectoryIterator($destination_path);
        $i          = 0;
        foreach ($iterator as $item) {
            if(!$item->isDot()) {
                unlink($item->getPathname());// remove files
                $i++;
            }
        }   
        
        $this->assertEquals($exptected_parts, $i);
    }
    
    public function providerSplitBy()
    {
        return array(
            array(
                'test-10000-rows-357kb.csv', 'parts', new \SplitCSV\Rule\FileSize(array('size' => '100kb')), 4
            ),
            
           array(
                'test-10000-rows-357kb.csv', 'parts', new \SplitCSV\Rule\NumberRow(array('number_row' => 10)), 1000
           ),
        );
    }
}
