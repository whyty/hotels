<?php 

class Airport extends VanillaModel {
	var $hasOne = array('Parent' => 'Airport');
}

