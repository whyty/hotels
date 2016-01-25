<?php

class Vacation_Theme extends VanillaModel {
	var $hasOne = array('Parent' => 'Vacation_Theme');
}

