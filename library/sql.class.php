<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pdo
 *
 * @author Lynku
 */
class Sql {

    private $_conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->_conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($this->_conn->connect_error) {
            die("Connection failed: " . $this->_conn->connect_error);
        }
    }

    public function query($sql) {
        $array = array();
        $result = $this->_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($array, $row);
            }
            return $array;
        }
    }

}
