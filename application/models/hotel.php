<?php

class Hotel extends VanillaModel {
	var $hasOne = array('Parent' => 'Hotel');
}

