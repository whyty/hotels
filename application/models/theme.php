<?php

class Theme extends VanillaModel {
	var $hasOne = array('Parent' => 'Theme');
}

