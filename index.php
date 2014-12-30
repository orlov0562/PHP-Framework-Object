<?php

    include 'DataObject.php';
    
    // Tests
    
    class MethodNotFoundException extends Exception {}
    
    class Test extends DataObject {
        public function __toString() {
            return print_r($this->getData(), TRUE);
        }
        
        public function getD() {
            return __METHOD__;
        }
        
        protected function getMethodNotFoundException() {
            return new MethodNotFoundException();    
        }
    }
    
    $test = new Test;
    
    $test->setZ('Z');
    $test->loadData(array('a'=>'A', 'b_and_b'=>'B')); //rewrites data, keys should be stored in lower case
    $test->setC('C');
    $test->appendData(array('d'=>'D')); // appends data, keys should be stored in lower case
    
    echo '$data = '.$test.'<hr />';
    
    echo 'getA: '.$test->getA().'<br />';               // is "A", set with "loadData"
    echo 'getB: '.$test->getBAndB().'<br />';           // is "B" set with "loadData", pay attention that camel case 'BAndB' transforms to "b_and_b" 
    echo 'getC: '.$test->getC().'<br />';               // is "C" set with "setC"
    echo 'getD: '.$test->getD().'<br />';               // is "Test::getD" set in method "Test::getD" and redefine 'D' that set through "appendData"
    echo 'getE: '.$test->getE().'<br />';               // is "", undefined value but by default class return NULL
    echo 'getF: '.$test->getF('default').'<br />';      // is "default", undefined value but default value set to "default"
    echo 'getZ: '.$test->getZ().'<br />';               // is "", Value rewrited with "loadData" so it's undefined      

    echo '<hr />';
    
    echo 'undefinedMethod: <pre>';                      
    echo $test->undefinedMethod();                      // throw exception if prefix not in [set,get,uns]* 