<?php

class Hotel_Interval extends VanillaModel {
	var $hasOne = array('Parent' => 'Hotel_Interval');
}

