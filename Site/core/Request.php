<?php
class Request{

	public $url; //url appeler par l'utilisateur

	function __construct(){
		$this->url = $_SERVER['PATH_INFO'];
	}
}