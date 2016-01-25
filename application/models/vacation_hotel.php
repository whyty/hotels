<?php

class Vacation_Hotel extends VanillaModel {
	var $hasOne = array('Parent' => 'Vacation_Hotel');
}

