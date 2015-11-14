<?php

class User extends VanillaModel {
	var $hasOne = array('Parent' => 'User');
}

