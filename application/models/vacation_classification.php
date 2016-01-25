<?php

class Vacation_Classification extends VanillaModel {
	var $hasOne = array('Parent' => 'Vacation_Classification');
}

