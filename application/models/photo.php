<?php

class Photo extends VanillaModel {
	var $hasOne = array('Parent' => 'Photo');
}

