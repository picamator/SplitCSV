<?php
/**
 * Rule Test
 * 
 * @link        https://github.com/picamator/SplitCSV
 * @license     http://opensource.org/licenses/BSD-3-Clause New BSD License
 */

namespace SplitCSV\Rule;

class RuleTest extends SplitCSV\BaseTest
{
    /**
     * @dataProvider providerFileSize
     * @param array     $options
     * @param string    $source_path
     * @param integer   $expected_parts
     */
    public function testFileSize(array $options, $source_path, $exptected_parts)
    {
        $file = fopen($this->getDataPath($source_path), 'r');
        
        // create and decorate rule
        $rule = new FileSize($options);
        $rule->setFile($file);
        
        // run and let check where it should be split
        $actual_parts = $this->splitBy($rule, $file);
        
        // asserts
        $this->assertEquals($exptected_parts, $actual_parts);
    }
    
    /**
     * Split By Rule
     * 
     * @param   SplitCSV\Rule\RuleInterface $rule
     * @param   source $file
     * @return integer - number of files that is going to br created
     */
    protected function splitBy(SplitCSV\Rule\RuleInterface $rule, $file)
    {
        // run and let check where it should be split
        $result = 0;
        while (($row = fgetcsv(file, null, ';', '"')) !== FALSE) {
            if (!$rule->isSplit($row)) {
                // new split file should be created
                $result++;
            }
        }
        
        return $result;
    }
    
    public function providerFileSize()
    {
        return array(
            array(array('size' => '100kb'), 'test-10000-rows-357kb.csv', 4),
            array(array('size' => '150Kb'), 'test-10000-rows-357kb.csv', 3),
            array(array('size' => '300kB'), 'test-10000-rows-357kb.csv', 2),
            array(array('size' => '1Mb'),   'test-10000-rows-357kb.csv', 0)
       );
    } 
}