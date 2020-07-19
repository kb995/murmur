<?php

class PostValidation {

    private $data;
    private $error_msgs = array();

    public function setData($data) {
        $this->data = $data;
    }
    public function getData() {
        return $this->data;
    }
    public function getErrorMsgs() {
        return $this->error_msgs;
    }

    public function checkPost() {
        $text = $this->data['text'];

        if(empty($text)) {
            $this->error_msgs['text'] = 'テキストが未入力です';
        }
        if(count($this->error_msgs) > 0) {
            return false;
        }
        return true;
    }
}