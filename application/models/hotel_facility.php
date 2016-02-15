<?php

class Hotel_Facility extends VanillaModel {
	var $hasOne = array('Parent' => 'Hotel_Facility');
}
