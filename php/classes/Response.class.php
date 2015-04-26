<?php

/**
 * Description of Response
 *
 * @author adrian.luethi
 */
class Response {
  
  private $answer = array(); /*
      "log" => array(),
      "error" => array(),
      "myD" => array(),
      "lessonInstances" => array(),
      "callback" => array(),
      "callbackWithArgs" => array( array(callback, arg1, arg2), ...),
      "message" => array(),
      "alert" => array(),
      "returnvalue" => array()
  );*/
    
  public function add($type, $content) {
    if(!isset($this->answer[$type])){
      $this->answer[$type] = array();
    }
    $this->answer[$type][] = $content;
  }
  
  public function send() {
    echo json_encode($this->answer);
  }
}
