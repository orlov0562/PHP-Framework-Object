<?php

    include 'Object.php';
    
    // Tests
    
    class MethodNotFoundException extends Exception {}
    
    class Test extends Object {
        public function __toString() {
            return print_r($this->data, TRUE);
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
    $test->loadData(array('A'=>'A', 'B'=>'B')); //rewrites data
    $test->setC('C');
    $test->appendData(array('D'=>'D')); // appends data
    
    echo '$data = '.$test.'<hr />';
    
    echo 'getA: '.$test->getA().'<br />';               // is "A", set with "loadData"
    echo 'getB: '.$test->getB().'<br />';               // is "B" set with "loadData"
    echo 'getC: '.$test->getC().'<br />';               // is "C" set with "setC"
    echo 'getD: '.$test->getD().'<br />';               // is "Test::getD" set in method "Test::getD"
    echo 'getE: '.$test->getE().'<br />';               // is "", undefined value but by default class return NULL
    echo 'getF: '.$test->getF('default').'<br />';      // is "default", undefined value but default value set to "default"
    echo 'getZ: '.$test->getZ().'<br />';               // is "", Value rewrited with "loadData" so it's undefined      

    echo '<hr />';
    
    echo 'undefinedMethod: <pre>';                      
    echo $test->undefinedMethod();                      // throw exception if prefix not in [set,get,uns]* 