<?php

class Classification extends VanillaModel {
	var $hasOne = array('Parent' => 'Classification');
}

