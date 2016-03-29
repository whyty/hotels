<?php

class AdminController extends VanillaController {

    protected $_username;
    protected $_hotel;
    protected $_interval;
    protected $_airport;
    protected $_classification;
    protected $_theme;
    protected $_country;
    protected $_vacation;
    protected $_vacation_theme;
    protected $_vacation_classification;
    protected $_vacation_hotel;
    protected $_vacation_airport;
    protected $_photo;
    protected $_hotel_facility;
    private $_thumbsDimensions = array(
	array(
	    'width' => 730,
	    'height' => 410,
	),
	array(
	    'width' => 155,
	    'height' => 115,
	),
	array(
	    'width' => 100,
	    'height' => 60,
	),
    );
    
    private $_imagesPath = 'img/uploads/';

    function beforeAction() {
	session_start();
	$this->_user = new User();
	$this->_hotel = new Hotel();
	$this->_interval = new Interval();
	$this->_airport = new Airport();
	$this->_classification = new Classification();
	$this->_theme = new Theme();
	$this->_country = new Country();
	$this->_vacation = new Vacation();
	$this->_vacation_theme = new Vacation_Theme();
	$this->_vacation_classification = new Vacation_Classification();
	$this->_vacation_hotel = new Vacation_Hotel();
	$this->_vacation_airport = new Vacation_Airport();
	$this->_photo = new Photo();
	$this->_hotel_facility = new Hotel_Facility();
	$this->_helper = new AdminHelper();
	$this->set('parentActive', '');
	$this->set('active', $this->_action);
	$this->set('sectionName', '');
    }

    function index($id = null) {
	$this->isLoggedIn();
	$hotels= $this->_helper->modelCountData($this->_hotel);
	$airports = $this->_helper->modelCountData($this->_airport);
	$vacations = $this->_helper->modelCountData($this->_vacation);
	$this->set('username', $this->_username);
	$this->set('hotels', $hotels);
	$this->set('airports', $airports);
	$this->set('vacations', $vacations);
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
	$countries = $this->_country->search();
	$period = array();
	if ($id) {
	    $this->_hotel->where(array('id' => $id));
	    $data = $this->_hotel->search();
	    $hotel = $data[0];
	    $sectionName = 'Hotel &raquo; ' . $hotel['name'];
	} else {
	    $sectionName = 'Hotel add';
	    $hotel = false;
	}

	$this->set('sectionName', $sectionName);
	$this->set('hotel', $hotel);
	$this->set('parentActive', 'hotels');
	$this->set('countries', $countries);
    }

    function insertHotel() {
	$this->isLoggedIn();
	$this->_helper->saveData($this->_hotel,$_POST);
	redirect("/admin/hotelsList");
    }

    function hotelsList() {
	$this->isLoggedIn();
	$this->set('username', $this->_username);
	$this->set('sectionName', 'Hotels List');
	$this->set('parentActive', 'hotels');
	$this->set('model', '_hotel');
    }

    function deleteHotel($id) {
	$this->isLoggedIn();
	$this->_helper->deletaDataFromAdiacentTable($id, 'hotel_id', $this->_interval);
	$this->_helper->deletaDataFromAdiacentTable($id, 'hotel_id', $this->_vacation_hotel);
	$this->_hotel->id = $id;
	$this->_hotel->delete();
	redirect('/admin/hotelsList');
    }

    function hotelIntervals($hotelId) {
	$this->isLoggedIn();
	$data = $this->_hotel->search(array('id' => $hotelId));
	$this->set('username', $this->_username);
	$intervals = $this->_interval->search();
	$sectionName = $data[0]['name'] . ' &raquo; Intervals';
	$this->set('sectionName', $sectionName);
	$this->set('hotelId', $hotelId);
	$this->set('intervals', $intervals);
	$this->set('parentActive', 'hotels');
    }

    function insertInterval() {
	$this->isLoggedIn();
	$this->_helper->saveData($this->_interval,$_POST);
	redirect("/admin/hotelIntervals/" . $_POST['hotel_id']);
    }

    function intervalsList() {
	$this->isLoggedIn();
	$this->set('username', $this->_username);
	$this->set('sectionName', 'Time Intervals List');
	$this->set('parentActive', 'intervals');
    }

    function deleteInterval($id) {
	$this->isLoggedIn();
	$this->_interval->where(array('id' => $id));
	$data = $this->_interval->search();
	$hotelId = $data[0]['hotel_id'];
	$this->_interval->id = $id;
	$this->_interval->delete();
	redirect('/admin/hotelIntervals/' . $hotelId);
    }

    function addAirport($id = null) {
	$this->isLoggedIn();
	$countries = $this->_country->search();
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
	$this->set('countries', $countries);
    }

    function insertAirport() {
	$this->isLoggedIn();
	$this->_helper->saveData($this->_airport,$_POST);
	redirect("/admin/airportsList");
    }

    function airportsList() {
	$this->isLoggedIn();
	$this->set('username', $this->_username);
	$this->set('sectionName', 'Airports List');
	$this->set('parentActive', 'airports');
	$airportsList = $this->_airport->search();
	$this->set('airports', $airportsList);
	$this->set('model', '_airport');
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
	$this->_helper->saveData($this->_classification, $_POST);
	redirect("/admin/classificationsList");
    }

    function classificationsList() {
	$this->isLoggedIn();
	$this->set('username', $this->_username);
	$this->set('sectionName', 'Classifications List');
	$this->set('parentActive', 'classifications');
	$classificationsList = $this->_classification->search();
	$this->set('classifications', $classificationsList);
	$this->set('model', '_classification');
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

    public function addTheme($id = null) {
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

    public function insertTheme() {
	$this->isLoggedIn();
	$this->_helper->saveData($this->_theme, $_POST);
	redirect("/admin/themesList");
    }

    public function themesList() {
	$this->isLoggedIn();
	$this->set('username', $this->_username);
	$this->set('sectionName', 'Themes List');
	$this->set('parentActive', 'themes');
	$themesList = $this->_theme->search();
	$this->set('themes', $themesList);
	$this->set('model', '_theme');
    }

    public function deleteTheme($id) {
	$this->isLoggedIn();
	$this->_theme->where(array('id' => $id));
	$data = $this->_theme->search();
	if ($data) {
	    $this->_theme->id = $id;
	    $this->_theme->delete();
	}
	redirect('/admin/themesList');
    }

    public function addVacation($id = null) {
	$this->isLoggedIn();
	$countries = $this->_country->search();
	$airports = $this->_airport->search();
	$themes = $this->_theme->search();
	$classifications = $this->_classification->search();
	$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : false;


	if ($id) {
	    $this->_vacation->where(array('id' => $id));
	    $data = $this->_vacation->search();
	    $vacation = $data[0];
	    $this->_hotel->where(array('country' => $vacation['country']));
	    $hotels = $this->_hotel->search();
	    $sectionName = 'Vacation &raquo; ' . $vacation['title'];
	    $this->_vacation_airport->where(array('vacation_id' => $id));
	    $this->_vacation_theme->where(array('vacation_id' => $id));
	    $this->_vacation_hotel->where(array('vacation_id' => $id));
	    $this->_vacation_classification->where(array('vacation_id' => $id));

	    $selectedAirports = $this->getIds($this->_vacation_airport->search(), 'airport_id');
	    $selectedThemes = $this->getIds($this->_vacation_theme->search(), 'theme_id');
	    $selectedHotels = $this->getIds($this->_vacation_hotel->search(), 'hotel_id');
	    $selectedClassifications = $this->getIds($this->_vacation_classification->search(), 'classification_id');
	} else {
	    $hotels = $this->_hotel->search();
	    $sectionName = 'Vacation add';
	    $vacation = $selectedAirports = $selectedThemes = $selectedHotels = $selectedClassifications = false;
	}
	$this->set('username', $this->_username);
	$this->set('parentActive', 'vacations');
	$this->set('sectionName', $sectionName);
	$this->set('vacation', $vacation);
	$this->set('airports', $airports);
	$this->set('selectedAirports', $selectedAirports);
	$this->set('themes', $themes);
	$this->set('selectedThemes', $selectedThemes);
	$this->set('hotels', $hotels);
	$this->set('selectedHotels', $selectedHotels);
	$this->set('classifications', $classifications);
	$this->set('selectedClassifications', $selectedClassifications);
	$this->set('countries', $countries);
	$this->set('errors', $errors);
    }

    public function getIds($data, $columnName) {
	$result = array();
	foreach ($data as $item) {
	    array_push($result, $item[$columnName]);
	}
	return $result;
    }

    public function insertVacation() {
	$this->isLoggedIn();
	$this->_helper->saveData($this->_vacation, $_POST);
	$this->_vacation->orderby('id', 'DESC');
	$vacationData = $this->_vacation->search();
	$vacationId = isset($_POST['id']) ? $_POST['id'] : (int) $vacationData[0]['id'] ;
	if($vacationId){
	    $this->_helper->saveData2AdiacentTable($vacationId, 'vacation_id', 'theme_id', $this->_vacation_theme, $_POST['themes']);
	    $this->_helper->saveData2AdiacentTable($vacationId, 'vacation_id', 'hotel_id', $this->_vacation_hotel, $_POST['hotels']);
	    $this->_helper->saveData2AdiacentTable($vacationId, 'vacation_id', 'airport_id', $this->_vacation_airport, $_POST['airports']);
	    $this->_helper->saveData2AdiacentTable($vacationId, 'vacation_id', 'classification_id', $this->_vacation_classification, $_POST['classifications']);
	}
	redirect("/admin/vacationsList");
    }

    public function vacationsList() {
	$this->isLoggedIn();
	$this->set('username', $this->_username);
	$this->set('sectionName', 'Vacations List');
	$this->set('parentActive', 'vacations');
	$this->set("exported", 0);
	$vacationsList = $this->_vacation->search();
	$this->set('vacations', $vacationsList);
	$this->set('model', '_vacation');
    }
    public function exportData(){
	$this->_helper->exportData($_POST['data']);
    }
    public function deleteVacation($id) {
	$this->isLoggedIn();
	$this->_vacation->where(array('id' => $id));
	$data = $this->_vacation->search();
	if ($data) {
	    $this->_vacation->id = $id;
	    $this->_helper->deletaDataFromAdiacentTable($id, 'vacation_id', $this->_vacation_airport);
	    $this->_helper->deletaDataFromAdiacentTable($id, 'vacation_id', $this->_vacation_classification);
	    $this->_helper->deletaDataFromAdiacentTable($id, 'vacation_id', $this->_vacation_hotel);
	    $this->_helper->deletaDataFromAdiacentTable($id, 'vacation_id', $this->_vacation_theme);
	    $this->deleteAllVacationPhotos($id);
	    $this->_vacation->delete();
	}
	redirect('/admin/vacationsList');
    }
    
    function deleteAllVacationPhotos($vacationId){
	$this->_photo->where(array("vacation_id" => $vacationId));
	$photos = $this->_photo->search();
	if($photos){
	    foreach($photos as $photo){
		unlink($this->_imagesPath . $photo['file']);
		foreach($this->_thumbsDimensions as $dimension){
		    unlink($this->_imagesPath . 'th-' . $dimension['width'] . 'X' . $dimension['height']. '-' . $photo['file']);
		}
		$this->_photo->id = $photo['id'];
		$this->_photo->delete();
	    }
	}
    }

    public function vacationPhotos($id) {
	$this->isLoggedIn();
	$this->_photo->where(array('vacation_id' => $id));
	$photos = $this->_photo->search();
	$this->set('username', $this->_username);
	$this->set('photos', $photos);
	$this->set('vacation_id', $id);
	$this->set('sectionName', 'Vacations photos');
	$this->set('parentActive', 'vacations');
	$this->set('imagesPath', $this->_imagesPath);
    }

    function savePhoto() {
	$pathArray = explode('/', $this->_imagesPath, -1);
	$imgPath = '';
	foreach($pathArray as $path){
	    $imgPath .= $path . '/';
	    if(!is_dir($imgPath) ) mkdir($imgPath, 0775);
	}
	$vacation_id = $_POST['vacation_id'];
	$image = explode(".", $_FILES['photo']['name']);
	$filename = rand(1, 999) . '-' . $image[0];
	if (isset($_POST["submit"])) {
	    if (!empty($_FILES['photo']['name'])) {
		$upload_img = $this->_helper->cwUpload('photo', $this->_imagesPath, $this->_imagesPath, $filename, TRUE, $this->_thumbsDimensions);
		if ($upload_img) {
		    $this->_photo->vacation_id = $vacation_id;
		    $this->_photo->thumb = $upload_img;
		    $this->_photo->file = $upload_img;
		    $this->_photo->save();
		}
	    }
	}
	redirect('/admin/vacationPhotos/' . $vacation_id);
    }

    public function deletePhoto($id) {
	$this->isLoggedIn();
	$this->_photo->where(array('id' => $id));
	$data = $this->_photo->search();

	if ($data) {
	    unlink($this->_imagesPath . $data[0]['file']);
	    foreach($this->_thumbsDimensions as $dimension){
		unlink($this->_imagesPath . 'th-' . $dimension['width'] . 'X' . $dimension['height']. '-' . $data[0]['file']);
	    }
	    $this->_photo->id = $data[0]['id'];
	    $this->_photo->delete();
	    redirect('/admin/vacationPhotos/' . $data[0]['vacation_id']);
	}
    }


    public function importData() {
	if (!is_dir("uploads/xml/"))
	    mkdir("uploads/xml/", 0777);
	$_SESSION['errors'] = '';
	if (isset($_POST['submit'])) {
	    if (!empty($_FILES['file']['name'])) {
		$file_arr = explode(".", $_FILES['file']['name']);
		$file_ext = $file_arr[count($file_arr) - 1];
		$file_path = "uploads/xml/" . basename($_FILES['file']['name']);
		if ($file_ext == 'xml') {
		    move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
		    $xml = file_get_contents($file_path);
		    $array = $this->_helper->xml_to_array($xml);
		    $this->_helper->array2Db($array);
		} else {
		    $_SESSION['errors'] = "Please upload an XML file";
		}
	    }
	}
	redirect("/admin/addVacation");
    }

    public function hotelFacilities($hotelId) {
	$this->isLoggedIn();
	$data = $this->_hotel->search(array('id' => $hotelId));
	$this->set('username', $this->_username);
	$facilities = $this->_hotel_facility->search();
	$sectionName = $data[0]['name'] . ' &raquo; Facilities';
	$this->set('sectionName', $sectionName);
	$this->set('hotelId', $hotelId);
	$this->set('facilities', $facilities);
	$this->set('parentActive', 'hotels');
    }

    public function insertFacility() {
	$this->isLoggedIn();
	$this->_helper->saveData($this->_hotel_facility, $_POST);
	redirect("/admin/hotelFacilities/" . $_POST['hotel_id']);
    }

    public 
	    function deleteFacility($id) {
	$this->isLoggedIn();
	$this->_hotel_facility->where(array('id' => $id));
	$data = $this->_hotel_facility->search();
	$hotelId = $data[0]['hotel_id'];
	$this->_hotel_facility->id = $id;
	$this->_hotel_facility->delete();
	redirect('/admin/hotelFacilities/' . $hotelId);
    }
    
    public function searchCountry(){
	$country = $_POST['country'];
	$this->_hotel->where(array('country' => $country));
	$hotels = $this->_hotel->search();
	if($hotels){
	    $response = json_encode(array('status' => '1', 'hotels' => $hotels));
	}else{
	    $response = json_encode(array('status' => '0', 'hotels' => ''));
	}
	header('Content-Type: application/json');
	echo $response;
    }
    
    public function paginate($data = ''){
	$collection = array();
	$data  = $_POST ? $_POST : '';
	if($data) $collection = $this->_helper->pagination($data);
	$collection = json_encode($collection);
	header('Content-Type: application/json');
	echo $collection;
    }
    
    function afterAction() {
	
    }

}
