<?php

class Country extends VanillaModel {
	var $hasOne = array('Parent' => 'Country');
}

