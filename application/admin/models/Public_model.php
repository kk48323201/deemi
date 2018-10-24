<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Public_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function cap(){
		$rand = rand(1000,9999);
		$_SESSION['Captcha'] = $rand;
		$vals = array(
			'word' => $rand,
			'img_path' => 'upload/captcha/',
			'img_url' => base_url('upload/captcha/'),
			'img_width' => 130,
			'img_height' => 38,
			'expiration' => 10,
		);
		$cap = create_captcha($vals);
		return $cap['image'];
	}
}