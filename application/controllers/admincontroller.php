<?php

class AdminController extends VanillaController {

    protected $_error;
    protected $_username;
    protected $_hotel;
    protected $_interval;
    protected $_hotel_interval;
    protected $_airport;
    protected $_classification;

    function beforeAction() {
        session_start();
        $this->_user = new User();
        $this->_hotel = new Hotel();
        $this->_hotel_interval = new Hotel_Interval();
        $this->_interval = new Interval();
        $this->_airport = new Airport();
        $this->_classification = new Classification();
        $this->_theme = new Theme();
        $this->set('parentActive', '');
        $this->set('active', $this->_action);
        $this->set('sectionName', '');
    }

    function index($id = null) {
        $this->isLoggedIn();
        $this->set('username', $this->_username);
        $this->set('sectionName', 'Home');
    }

    function login() {
        $error = isset($_SESSION['loggedIn']['error']) ? $_SESSION['loggedIn']['error'] : '';
        $this->set('error', $error);
    }

    function settings() {
        $this->isLoggedIn();
        $this->set('username', $this->_username);
        $this->set('sectionName', 'Admin Settings');
    }

    function updateSettings() {
        $this->_user->where(array('password' => $_SESSION['loggedIn']['success']));
        $user = $this->_user->search();
        $this->_user->id = $user[0]['id'];
        if (isset($_POST['name']))
            $this->_user->name = $_POST['name'];
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $this->_user->password = md5($_POST['password']);
            $_SESSION['loggedIn']['success'] = md5($_POST['password']);
        }
        $this->_user->save();

        redirect('/admin/settings');
    }

    function signin() {
        $_SESSION['loggedIn'] = array();
        $this->_user->where(array("username" => $_POST['username'], "password" => md5($_POST['password'])));
        if ($this->_user->search()) {
            $data = $this->_user->search();
            $_SESSION['loggedIn']['success'] = $data[0]['password'];
            redirect("/admin");
        } else {
            $_SESSION['loggedIn']['error'] = 'Username / password wrong';
            redirect("/admin/login");
        }
    }

    function isLoggedIn() {
        if (isset($_SESSION['loggedIn']['success'])) {
            $this->_user->where(array('password' => $_SESSION['loggedIn']['success']));
            $data = $this->_user->search();
            if ($data) {
                $this->_username = $data[0]['name'];
            } else {
                redirect("/admin/login");
            }
        } else {
            redirect("/admin/login");
        }
    }

    function logout() {
        unset($_SESSION['loggedIn']);
        redirect("/admin/login");
    }

    function addHotel($id = null) {
        $this->isLoggedIn();
        $this->set('username', $this->_username);
        $period = array();
        if ($id) {
            $this->_hotel->where(array('id' => $id));
            $data = $this->_hotel->search();
            $hotel = $data[0];
            $this->_hotel_interval->where(array('hotel_id' => $id));
            $datesSelected = $this->_hotel_interval->search();
            foreach ($datesSelected as $date) {
                array_push($period, $date['interval_id']);
            }
            $sectionName = 'Hotel &raquo; ' . $hotel['name'];
        } else {
            $sectionName = 'Hotel add';
            $hotel = false;
        }

        $intervals = $this->_interval->search();
        $this->set('sectionName', $sectionName);
        $this->set('hotel', $hotel);
        $this->set('intervals', $intervals);
        $this->set('period', $period);
        $this->set('parentActive', 'hotels');
    }

    function insertHotel() {
        $this->isLoggedIn();
        if (isset($_POST['id']) && $_POST['id'] != '')
            $this->_hotel->id = $_POST['id'];
        if (isset($_POST['name']))
            $this->_hotel->name = $_POST['name'];
        if (isset($_POST['stars']))
            $this->_hotel->stars = $_POST['stars'];
        if (isset($_POST['meal']))
            $this->_hotel->meal = $_POST['meal'];
        $this->_hotel->save();
        $this->_hotel->orderby('id', 'DESC');
        $hotelData = $this->_hotel->search();
        $id = (count($hotelData) > 0) ? (int) $hotelData[0]['id'] : $_POST['id'];
        if (isset($_POST['intervals'])) {
            $this->_hotel_interval->where(array('hotel_id' => $id));
            $data = $this->_hotel_interval->search();
            $period = array();
            foreach ($data as $d) {
                array_push($period, $d['interval_id']);
            }
            $diff = array_diff($period, $_POST['intervals']);
            foreach ($_POST['intervals'] as $date) {
                if ($data) {
                    if (!in_array($date, $diff) && !in_array($date, $period)) {
                        $this->_hotel_interval->hotel_id = $id;
                        $this->_hotel_interval->interval_id = $date;
                        $this->_hotel_interval->save();
                    }
                } else {
                    $this->_hotel_interval->hotel_id = $id;
                    $this->_hotel_interval->interval_id = $date;
                    $this->_hotel_interval->save();
                }
            }
            if ($data) {
                foreach ($data as $d) {
                    if (in_array($d['interval_id'], $diff)) {
                        $this->_hotel_interval->id = $d['id'];
                        $this->_hotel_interval->delete();
                    }
                }
            }
        }
        redirect("/admin/hotelsList");
    }

    function hotelsList() {
        $this->isLoggedIn();
        $this->set('username', $this->_username);
        $this->set('sectionName', 'Hotels List');
        $this->set('parentActive', 'hotels');
        $hotelList = $this->_hotel->search();
        $this->set('hotels', $hotelList);
    }

    function deleteHotel($id) {
        $this->isLoggedIn();
        $this->_hotel_interval->where(array('hotel_id' => $id));
        $data = $this->_hotel_interval->search();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $this->_hotel_interval->id = $d['id'];
                $this->_hotel_interval->delete();
            }
        }
        $this->_hotel->id = $id;
        $this->_hotel->delete();
        redirect('/admin/hotelsList');
    }

    function addInterval($id = null) {
        $this->isLoggedIn();
        $this->set('username', $this->_username);
        if ($id) {
            $this->_interval->where(array('id' => $id));
            $data = $this->_interval->search();
            $interval = $data[0];
            $sectionName = 'Interval &raquo; ' . $data[0]['name'];
        } else {
            $sectionName = 'Interval add';
            $interval = false;
        }
        $this->set('sectionName', $sectionName);
        $this->set('interval', $interval);
        $this->set('parentActive', 'intervals');
    }

    function insertInterval() {
        $this->isLoggedIn();
        if (isset($_POST['id']) && $_POST['id'] != '')
            $this->_interval->id = $_POST['id'];
        if (isset($_POST['from_date']))
            $this->_interval->from_date = $_POST['from_date'];
        if (isset($_POST['to_date']))
            $this->_interval->to_date = $_POST['to_date'];
        if (isset($_POST['price_double']))
            $this->_interval->price_double = $_POST['price_double'];
        if (isset($_POST['price_triple']))
            $this->_interval->price_triple = $_POST['price_triple'];
        if (isset($_POST['price_plus_ron']))
            $this->_interval->price_plus_ron = $_POST['price_plus_ron'];
        $this->_interval->save();
        redirect("/admin/intervalsList");
    }

    function intervalsList() {
        $this->isLoggedIn();
        $this->set('username', $this->_username);
        $this->set('sectionName', 'Time Intervals List');
        $this->set('parentActive', 'intervals');
        $intervalList = $this->_interval->search();
        $this->set('intervals', $intervalList);
    }

    function deleteInterval($id) {
        $this->isLoggedIn();
        $this->_hotel_interval->where(array('interval_id' => $id));
        $data = $this->_hotel_interval->search();
        if ($data) {
            foreach ($data as $d) {
                $this->_hotel_interval->id = $d['id'];
                $this->_hotel_interval->delete();
            }
        }
        $this->_interval->id = $id;
        $this->_interval->delete();
        redirect('/admin/intervalsList');
    }

    function addAirport($id = null) {
        $this->isLoggedIn();
        if ($id) {
            $this->_airport->where(array('id' => $id));
            $data = $this->_airport->search();
            $airport = $data[0];
            $sectionName = 'Airport &raquo; ' . $data[0]['name'];
        } else {
            $sectionName = 'Airport add';
            $airport = false;
        }
        $this->set('username', $this->_username);
        $this->set('parentActive', 'airports');
        $this->set('sectionName', $sectionName);
        $this->set('airport', $airport);
    }

    function insertAirport() {
        $this->isLoggedIn();
        if (isset($_POST['id']) && $_POST['id'] != '')
            $this->_airport->id = $_POST['id'];
        if (isset($_POST['name']))
            $this->_airport->name = $_POST['name'];
        $this->_airport->save();
        redirect("/admin/airportsList");
    }

    function airportsList() {
        $this->isLoggedIn();
        $this->set('username', $this->_username);
        $this->set('sectionName', 'Airports List');
        $this->set('parentActive', 'airports');
        $airportsList = $this->_airport->search();
        $this->set('airports', $airportsList);
    }

    function deleteAirport($id) {
        $this->isLoggedIn();
        $this->_airport->where(array('id' => $id));
        $data = $this->_airport->search();
        if ($data) {
            $this->_airport->id = $id;
            $this->_airport->delete();
        }
        redirect('/admin/airportsList');
    }

    function addClassification($id = null) {
        $this->isLoggedIn();
        if ($id) {
            $this->_classification->where(array('id' => $id));
            $data = $this->_classification->search();
            $clasif = $data[0];
            $sectionName = 'Classification &raquo; ' . $data[0]['name'];
        } else {
            $sectionName = 'Classification add';
            $clasif = false;
        }
        $this->set('username', $this->_username);
        $this->set('parentActive', 'classifications');
        $this->set('sectionName', $sectionName);
        $this->set('clasif', $clasif);
    }

    function insertClassification() {
        $this->isLoggedIn();
        if (isset($_POST['id']) && $_POST['id'] != '')
            $this->_classification->id = $_POST['id'];
        if (isset($_POST['name']))
            $this->_classification->name = $_POST['name'];
        $this->_classification->save();
        redirect("/admin/classificationsList");
    }

    function classificationsList() {
        $this->isLoggedIn();
        $this->set('username', $this->_username);
        $this->set('sectionName', 'Classifications List');
        $this->set('parentActive', 'classifications');
        $classificationsList = $this->_classification->search();
        $this->set('classifications', $classificationsList);
    }

    function deleteClassification($id) {
        $this->isLoggedIn();
        $this->_classification->where(array('id' => $id));
        $data = $this->_classification->search();
        if ($data) {
            $this->_classification->id = $id;
            $this->_classification->delete();
        }
        redirect('/admin/classificationsList');
    }
    
    public function addTheme($id = null){
        $this->isLoggedIn();
        if ($id) {
            $this->_theme->where(array('id' => $id));
            $data = $this->_theme->search();
            $theme = $data[0];
            $sectionName = 'Theme &raquo; ' . $data[0]['name'];
        } else {
            $sectionName = 'Theme add';
            $theme = false;
        }
        $this->set('username', $this->_username);
        $this->set('parentActive', 'themes');
        $this->set('sectionName', $sectionName);
        $this->set('theme', $theme);
    }
    
    public function insertTheme(){
        $this->isLoggedIn();
        if (isset($_POST['id']) && $_POST['id'] != '')
            $this->_theme->id = $_POST['id'];
        if (isset($_POST['name']))
            $this->_theme->name = $_POST['name'];
        $this->_theme->save();
        redirect("/admin/themesList");
    }
    
    public function themesList(){
        $this->isLoggedIn();
        $this->set('username', $this->_username);
        $this->set('sectionName', 'Themes List');
        $this->set('parentActive', 'themes');
        $themesList = $this->_theme->search();
        $this->set('themes', $themesList); 
    }
    
    public function deleteTheme($id){
        $this->isLoggedIn();
        $this->_theme->where(array('id' => $id));
        $data = $this->_theme->search();
        if ($data) {
            $this->_theme->id = $id;
            $this->_theme->delete();
        }
        redirect('/admin/themesList');
    }

    function afterAction() {
        
    }
}
