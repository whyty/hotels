<?php

class Vacation extends VanillaModel {
	var $hasOne = array('Parent' => 'Vacation');
}

