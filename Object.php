<?php

    class Object {

        protected $data = array();

        public function __call($name, array $arguments)
        {
            return property_exists(__CLASS__, $name)
                   ? $this->$name($arguments)
                   : $this->_call($name, $arguments)
            ;
        }
        
        private function _call($name, array $arguments) {
            $ret = null;
            switch( $this->_getPrefix($name) ) {
                default:
                    throw $this->getMethodNotFoundException();        
                break;
                case 'get':
                    $ret = $this->_get($name, $arguments);
                break;
                case 'set':
                    $this->_set($name, $arguments);
                break;
                case 'uns':
                    $this->_uns($name);
                break;                
            }
            return $ret;        
        }
        
        protected function getMethodNotFoundException() {
            return new Exception('Method not found');    
        }

        private function _getPrefix($name) { 
            return substr($name, 0, 3); 
        }
        
        private function _getVarName($name) { 
            return substr($name, 3); 
        }
        
        private function _get($name, array $arguments) {
            $varName = $this->_getVarName($name);
            return isset($this->data[$varName])
                   ? $this->data[$varName]
                   : ( isset($arguments[0]) ? $arguments[0] : null );        
        }

        private function _set($name, array $arguments) {
            $varName = $this->_getVarName($name);
            $this->data[$varName] = isset($arguments[0])
                                    ? $arguments[0]
                                    : null
            ;
        }
        
        private function _uns($name) {
            $varName = $this->_getVarName($name);
            if (isset($this->data[$varName])) unset($this->data[$varName]);
        }
        
        public function loadData(array $data) {
            $this->data = $data;
        }
        
        public function appendData(array $data) {
            $this->data = array_merge($this->data, $data);
        }
        
    }