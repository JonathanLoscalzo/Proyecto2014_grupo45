<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OAuthModel
 *
 * @author dante
 */

include_once("Model.php");

class OAuthModel extends Model {
    //put your code here
    
    protected $api_key;
    protected $api_secret;
    protected $token_id;
    protected $token_secret;
    
    public function __construct($api_key, $api_secret, $token_id, $token_secret) {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->token_id = $token_id;
        $this->token_secret = $token_secret;
        return $this;
    }
    
    public function getApi_key() {
        return $this->api_key;
    }
    
    public function getApi_secret() {
        return $this->api_secret;
    }
    
    public function getToken_id() {
        return $this->token_id;
    }
    
    public function getToken_secret() {
        return $this->token_secret;
    }
    
    
}
