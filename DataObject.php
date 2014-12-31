<?php

    class DataObject {
        
        private $_data = array();

        public function loadData(array $data) {
            $this->_data = $data;
        }
        
        public function appendData(array $data) {
            $this->_data = array_merge($this->_data, $data);
        }

        public function getData() {
            return $this->_data;
        }

        public function getDataWithoutKeys(array $keys) {
            return array_diff_key($this->_data, array_fill_keys($keys, null));
        }

        public function __call($method, array $arguments)
        {
            $ret = null;
            $prefix = $this->_getPrefix($method);
            if (!in_array($prefix, array('get', 'set', 'uns'))) {
                throw $this->getMethodNotFoundException();
            } else {
                $var = $this->_getVarName($method);
                $ret = $this->{'_'.$prefix}($var, $arguments);
            }
            return $ret;        
        }
        
        private function _getPrefix($name) { 
            return substr($name, 0, 3); 
        }
                
        protected function getMethodNotFoundException() {
            return new Exception('Method not found');    
        }

        private function _getVarName($name) {
            $varName = substr($name, 3);
            $varName = preg_replace('~([a-z0-9])([A-Z])~', '$1_$2', $varName);
            $varName = strtolower($varName);
            return $varName; 
        }
        
        private function _get($var, array $arguments) {
            
            return isset($this->_data[$var])
                   ? $this->_data[$var]
                   : ( isset($arguments[0]) ? $arguments[0] : null );        
        }

        private function _set($var, array $arguments) {
            $this->_data[$var] = isset($arguments[0])
                                    ? $arguments[0]
                                    : null
            ;
        }
        
        private function _uns($var) {
            if (isset($this->_data[$var])) unset($this->_data[$var]);
        }
        
    }