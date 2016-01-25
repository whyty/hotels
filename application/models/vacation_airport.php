<?php

class Vacation_Airport extends VanillaModel {
	var $hasOne = array('Parent' => 'Vacation_Airport');
}

