<?php

define('DBUSER', 'u259909164_looop');
define('DBNAME', 'u259909164_loodb');
define('DBPASSWORD', 'XsTVUeq36dnoNihB');

    class Database{
        
        private $link;
        
        function __construct() {
            $this->link = New mysqli("127.0.0.1", DBUSER, DBPASSWORD, DBNAME);
            /* check connection */
            if ($this->link->connect_errno) {
                printf("Keine Verbindung zu mysql: %s\n", $this->link->connect_error);
                exit();
            }
            $this->link->query("SET NAMES utf8");
            $this->link->set_charset("UTF8");
        }
        
        public function query(){
            $args = func_get_args();
            $query = $this->replaceQuery($args);
            $result = $this->link->query($query);
            //echo mysqli_errno($this->link) . ": " . mysqli_error($this->link) . "\n";
            if (mysqli_errno($this->link)) {echo mysqli_error($this->link) . "\n";}
            
            $this->affected_rows = $this->link->affected_rows;
            return $result;
        }
        
        private function replaceQuery($args){
            $query = $args[0];
            for($i=1;$i<count($args);$i++){                         
                $args[$i] = $this->link->real_escape_string($args[$i]);
                $query = str_replace(';'.($i-1), '"'.$args[$i].'"', $query);
            }
            return $query;
        }
        
        public function close() {
          $this->link->close();
        }
        
        public function affected_rows() {
          return $this->affected_rows;
        }
        
        public function num_rows() {
          return $this->link->num_rows;
        }
        
        public function prepare() {
          $args = func_get_args();
          $query = $this->replaceQuery($args);
          $stmt = $this->link->prepare($query);
          $this->stmt = &$this->link->stmt;
          return $this->stmt ;
        }
        
    }
?>