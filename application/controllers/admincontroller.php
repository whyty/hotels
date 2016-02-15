<?php

class AdminController extends VanillaController {

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
	if (isset($_POST['id']) && $_POST['id'] != '')
	    $this->_hotel->id = $_POST['id'];
	if (isset($_POST['name']))
	    $this->_hotel->name = $_POST['name'];
	if (isset($_POST['stars']))
	    $this->_hotel->stars = $_POST['stars'];
	if (isset($_POST['meal']))
	    $this->_hotel->meal = $_POST['meal'];
	if (isset($_POST['latitude']))
	    $this->_hotel->latitude = $_POST['latitude'];
	if (isset($_POST['longitude']))
	    $this->_hotel->longitude = $_POST['longitude'];
	if (isset($_POST['location']))
	    $this->_hotel->location = $_POST['location'];
	if (isset($_POST['phone']))
	    $this->_hotel->phone = $_POST['phone'];
	if (isset($_POST['email']))
	    $this->_hotel->email = $_POST['email'];
	if (isset($_POST['web']))
	    $this->_hotel->web = $_POST['web'];
	if (isset($_POST['gplus']))
	    $this->_hotel->gplus = $_POST['gplus'];
	if (isset($_POST['facebook']))
	    $this->_hotel->facebook = $_POST['facebook'];
	if (isset($_POST['twitter']))
	    $this->_hotel->twitter = $_POST['twitter'];
	if (isset($_POST['country']))
	    $this->_hotel->country = $_POST['country'];
	if (isset($_POST['city']))
	    $this->_hotel->city = $_POST['city'];
	$this->_hotel->save();

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
	$this->_interval->where(array('hotel_id' => $id));
	$data = $this->_interval->search();
	if (count($data) > 0) {
	    foreach ($data as $d) {
		$this->_interval->id = $d['id'];
		$this->_interval->delete();
	    }
	}
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
	if (isset($_POST['id']) && $_POST['id'] != '')
	    $this->_interval->id = $_POST['id'];
	if (isset($_POST['hotel_id']) && $_POST['hotel_id'] != '')
	    $this->_interval->hotel_id = $_POST['hotel_id'];
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
	if (isset($_POST['id']) && $_POST['id'] != '')
	    $this->_theme->id = $_POST['id'];
	if (isset($_POST['name']))
	    $this->_theme->name = $_POST['name'];
	$this->_theme->save();
	redirect("/admin/themesList");
    }

    public function themesList() {
	$this->isLoggedIn();
	$this->set('username', $this->_username);
	$this->set('sectionName', 'Themes List');
	$this->set('parentActive', 'themes');
	$themesList = $this->_theme->search();
	$this->set('themes', $themesList);
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
	$hotels = $this->_hotel->search();
	$classifications = $this->_classification->search();
	$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : false;


	if ($id) {
	    $this->_vacation->where(array('id' => $id));
	    $data = $this->_vacation->search();
	    $vacation = $data[0];
	    $sectionName = 'Vacation &raquo; ' . $data[0]['title'];
	    $this->_vacation_airport->where(array('vacation_id' => $id));
	    $this->_vacation_theme->where(array('vacation_id' => $id));
	    $this->_vacation_hotel->where(array('vacation_id' => $id));
	    $this->_vacation_classification->where(array('vacation_id' => $id));

	    $selectedAirports = $this->getIds($this->_vacation_airport->search(), 'airport_id');
	    $selectedThemes = $this->getIds($this->_vacation_theme->search(), 'theme_id');
	    $selectedHotels = $this->getIds($this->_vacation_hotel->search(), 'hotel_id');
	    $selectedClassifications = $this->getIds($this->_vacation_classification->search(), 'classification_id');
	} else {
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
	if (isset($_POST['id']) && $_POST['id'] != '')
	    $this->_vacation->id = $_POST['id'];
	if (isset($_POST['live']))
	    $this->_vacation->live = $_POST['live'];
	if (isset($_POST['title']))
	    $this->_vacation->title = $_POST['title'];
	if (isset($_POST['nights']))
	    $this->_vacation->nights = $_POST['nights'];
	if (isset($_POST['country']))
	    $this->_vacation->country = $_POST['country'];
	if (isset($_POST['city']))
	    $this->_vacation->city = $_POST['city'];
	if (isset($_POST['description']))
	    $this->_vacation->description = $_POST['description'];
	if (isset($_POST['transportation']))
	    $this->_vacation->transportation = $_POST['transportation'];
	if (isset($_POST['departure']))
	    $this->_vacation->departure = $_POST['departure'];
	if (isset($_POST['included_services']))
	    $this->_vacation->included_services = $_POST['included_services'];
	if (isset($_POST['additional_services']))
	    $this->_vacation->additional_services = $_POST['additional_services'];
	if (isset($_POST['currency']))
	    $this->_vacation->currency = $_POST['currency'];
	if (isset($_POST['all_taxes']))
	    $this->_vacation->all_taxes = $_POST['all_taxes'];
	if (isset($_POST['availability']))
	    $this->_vacation->availability = $_POST['availability'];
	$this->_vacation->save();

	$this->_vacation->orderby('id', 'DESC');
	$vacationData = $this->_vacation->search();
	$vacationId = (count($vacationData) > 0) ? (int) $vacationData[0]['id'] : $_POST['id'];
	$this->saveData2AdiacentTable($vacationId, 'vacation_id', 'theme_id', '_vacation_theme', $_POST['themes']);
	$this->saveData2AdiacentTable($vacationId, 'vacation_id', 'hotel_id', '_vacation_hotel', $_POST['hotels']);
	$this->saveData2AdiacentTable($vacationId, 'vacation_id', 'airport_id', '_vacation_airport', $_POST['airports']);
	$this->saveData2AdiacentTable($vacationId, 'vacation_id', 'classification_id', '_vacation_classification', $_POST['classifications']);


	redirect("/admin/vacationsList");
    }

    public function saveData2AdiacentTable($parentIdValue, $parentIdName, $secondaryIdName, $currentTable, $data) {
	if (isset($data)) {
	    $this->{$currentTable}->where(array($parentIdName => $parentIdValue));
	    $temp = $this->{$currentTable}->search();
	    $arr = array();
	    foreach ($temp as $item) {
		array_push($arr, $item[$secondaryIdName]);
	    }
	    $diff = array_diff($arr, $data);
	    foreach ($data as $value) {
		if ($temp) {
		    if (!in_array($value, $diff) && !in_array($value, $arr)) {
			$this->{$currentTable}->{$parentIdName} = $parentIdValue;
			$this->{$currentTable}->{$secondaryIdName} = $value;
			$this->{$currentTable}->save();
		    }
		} else {
		    $this->{$currentTable}->{$parentIdName} = $parentIdValue;
		    $this->{$currentTable}->{$secondaryIdName} = $value;
		    $this->{$currentTable}->save();
		}
	    }
	    if ($temp) {
		foreach ($temp as $d) {
		    if (in_array($d[$secondaryIdName], $diff)) {
			$this->{$currentTable}->id = $d['id'];
			$this->{$currentTable}->delete();
		    }
		}
	    }
	}
    }

    public function vacationsList() {
	$this->isLoggedIn();
	$this->set('username', $this->_username);
	$this->set('sectionName', 'Vacations List');
	$this->set('parentActive', 'vacations');
	$this->set("exported", 0);
	$vacationsList = $this->_vacation->search();
	$this->set('vacations', $vacationsList);
	if (isset($_POST['data'])) {
	    $this->set("exported", 1);
	    $this->exportData($_POST['data']);
	}
    }

    public function deleteVacation($id) {
	$this->isLoggedIn();
	$this->_vacation->where(array('id' => $id));
	$data = $this->_vacation->search();
	if ($data) {
	    $this->_vacation->id = $id;
	    $this->deletaDataFromAdiacentTable($id, 'vacation_id', '_vacation_airport');
	    $this->deletaDataFromAdiacentTable($id, 'vacation_id', '_vacation_classification');
	    $this->deletaDataFromAdiacentTable($id, 'vacation_id', '_vacation_hotel');
	    $this->deletaDataFromAdiacentTable($id, 'vacation_id', '_vacation_theme');
	    $this->_vacation->delete();
	}
	redirect('/admin/vacationsList');
    }

    function deletaDataFromAdiacentTable($parentIdValue, $parentIdName, $currentTable) {
	$this->{$currentTable}->where(array($parentIdName => $parentIdValue));
	$dataToDelete = $this->{$currentTable}->search();
	if ($dataToDelete) {
	    foreach ($dataToDelete as $d) {
		$this->{$currentTable}->id = $d['id'];
		$this->{$currentTable}->delete();
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
    }

    function cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = '') {

	//folder path setup
	$target_path = $target_folder;
	$thumb_path = $thumb_folder;

	//file name setup
	$filename_err = explode(".", $_FILES[$field_name]['name']);
	$filename_err_count = count($filename_err);
	$file_ext = $filename_err[$filename_err_count - 1];
	if ($file_name != '') {
	    $fileName = $file_name . '.' . $file_ext;
	} else {
	    $fileName = $_FILES[$field_name]['name'];
	}

	//upload image path
	$upload_image = $target_path . basename($fileName);

	//upload image
	if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $upload_image)) {
	    //thumbnail creation
	    if ($thumb == TRUE) {
		$thumbnail = $thumb_path . $fileName;
		list($width, $height) = getimagesize($upload_image);
		$thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
		switch ($file_ext) {
		    case 'jpg':
			$source = imagecreatefromjpeg($upload_image);
			break;
		    case 'jpeg':
			$source = imagecreatefromjpeg($upload_image);
			break;

		    case 'png':
			$source = imagecreatefrompng($upload_image);
			break;
		    case 'gif':
			$source = imagecreatefromgif($upload_image);
			break;
		    default:
			$source = imagecreatefromjpeg($upload_image);
		}

		imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
		switch ($file_ext) {
		    case 'jpg' || 'jpeg':
			imagejpeg($thumb_create, $thumbnail, 100);
			break;
		    case 'png':
			imagepng($thumb_create, $thumbnail, 100);
			break;

		    case 'gif':
			imagegif($thumb_create, $thumbnail, 100);
			break;
		    default:
			imagejpeg($thumb_create, $thumbnail, 100);
		}
	    }

	    return $fileName;
	} else {
	    return false;
	}
    }

    function savePhoto() {
	if (!is_dir("uploads/"))
	    mkdir("uploads/", 0777);
	if (!is_dir("uploads/thumbs/"))
	    mkdir("uploads/thumbs/", 0777);
	$vacation_id = $_POST['vacation_id'];
	$image = explode(".", $_FILES['photo']['name']);
	$filename = rand(1, 999) . '-' . $image[0];
	if (isset($_POST["submit"])) {
	    if (!empty($_FILES['photo']['name'])) {
		$upload_img = $this->cwUpload('photo', 'uploads/', $filename, TRUE, 'uploads/thumbs/', '400', '300');
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
	    unlink('uploads/' . $data[0]['file']);
	    unlink('uploads/thumbs/' . $data[0]['file']);
	    $this->_photo->id = $data[0]['id'];
	    $this->_photo->delete();
	    redirect('/admin/vacationPhotos/' . $data[0]['vacation_id']);
	}
    }

    function exportData() {
	$data = isset($_POST['data']) ? $_POST['data'] : '';
	if (!is_dir("downloads/"))
	    mkdir("downloads/", 0777);
	if ($data) {
	    $domtree = new DOMDocument('1.0', 'ISO-8859-1');
	    $domtree->preserveWhiteSpace = false;
	    $domtree->formatOutput = true;
	    $xml = $domtree->createElement("xml");
	    $xml = $domtree->appendChild($xml);
	    $vacationsXml = $domtree->createElement('sejururi');
	    $vacationsXml = $xml->appendChild($vacationsXml);

	    foreach ($data as $item) {
		$this->_vacation->where(array('id' => $item));
		$vacations = $this->_vacation->search();
		if ($vacations) {
		    foreach ($vacations as $vacation) {
			$vacationXml = $domtree->createElement('sejur');
			$vacationXml = $vacationsXml->appendChild($vacationXml);
			foreach ($vacation as $key => $value) {
			    if (isset(Mapping::$vacation_tags[$key])) {
				switch ($key) {
				    case 'country':
					$country = $domtree->createElement(Mapping::$vacation_tags[$key]['tag']);
					$country = $vacationXml->appendChild($country);
					$country->appendChild($domtree->createElement('nume', $value));
					break;
				    case 'city':
					$city = $domtree->createElement(Mapping::$vacation_tags[$key]['tag']);
					$city = $vacationXml->appendChild($city);
					$city->appendChild($domtree->createElement('nume', $value));
					$city->appendChild($domtree->createElement('alias', $value));
					break;
				    default:
					$vacationXml->appendChild($domtree->createElement(Mapping::$vacation_tags[$key]['tag'], $value));
					break;
				}
			    }
			}
			//airports
			$this->_vacation_airport->where(array('vacation_id' => $vacation['id']));
			$vAirports = $this->_vacation_airport->search();
			if ($vAirports) {
			    $airportsXml = $domtree->createElement('aeroporturi');
			    $airportsXml = $vacationXml->appendChild($airportsXml);
			    foreach ($vAirports as $va) {
				$this->_airport->where(array('id' => $va['airport_id']));
				$airports = $this->_airport->search();
				if ($airports) {
				    foreach ($airports as $airport) {
					$airportsXml->appendChild($domtree->createElement('aeroport', $airport['name']));
				    }
				}
			    }
			}
			//classifications
			$this->_vacation_classification->where(array('vacation_id' => $vacation['id']));
			$vClassifs = $this->_vacation_classification->search();
			if ($vClassifs) {
			    $classifsXml = $domtree->createElement('clasificari');
			    $classifsXml = $vacationXml->appendChild($classifsXml);
			    foreach ($vClassifs as $vCls) {
				$this->_classification->where(array('id' => $vCls['classification_id']));
				$classifs = $this->_classification->search();
				if ($classifs) {
				    foreach ($classifs as $classif) {
					$classifsXml->appendChild($domtree->createElement('clasificare', $classif['name']));
				    }
				}
			    }
			}
			//themes
			$this->_vacation_theme->where(array('vacation_id' => $vacation['id']));
			$vThemes = $this->_vacation_theme->search();
			if ($vThemes) {
			    $themesXml = $domtree->createElement('teme');
			    $themesXml = $vacationXml->appendChild($themesXml);
			    foreach ($vThemes as $vTheme) {
				$this->_theme->where(array('id' => $vTheme['theme_id']));
				$themes = $this->_theme->search();
				if ($themes) {
				    foreach ($themes as $theme) {
					$themesXml->appendChild($domtree->createElement('tema', $theme['name']));
				    }
				}
			    }
			}
			//photos
			$this->_photo->where(array('vacation_id' => $vacation['id']));
			$photos = $this->_photo->search();
			if ($photos) {
			    $photosXml = $domtree->createElement('poze');
			    $photosXml = $vacationXml->appendChild($photosXml);
			    foreach ($photos as $photo) {
				$photosXml->appendChild($domtree->createElement('poza', BASE_PATH . "/uploads/" . $photo['file']));
			    }
			}
			//hotels
			$this->_vacation_hotel->where(array('vacation_id' => $vacation['id']));
			$vHotels = $this->_vacation_hotel->search();
			if ($vHotels) {
			    $hotelsXml = $domtree->createElement('hoteluri');
			    $hotelsXml = $vacationXml->appendChild($hotelsXml);
			    foreach ($vHotels as $vHotel) {
				$this->_hotel->where(array('id' => $vHotel['hotel_id']));
				$hotels = $this->_hotel->search();
				if ($hotels) {
				    foreach ($hotels as $hotel) {
					$hotelXml = $domtree->createElement('hotel');
					$hotelXml = $hotelsXml->appendChild($hotelXml);
					foreach ($hotel as $key => $value) {
					    if (isset(Mapping::$vacation_tags[$key]) && $key != 'id') {
						$hotelXml->appendChild($domtree->createElement(Mapping::$vacation_tags[$key]['tag'], $value));
					    }
					}
					//periods
					$this->_interval->where(array('hotel_id' => $hotel['id']));
					$intervals = $this->_interval->search();
					if ($intervals) {
					    $intervalsXml = $domtree->createElement('perioade');
					    $intervalsXml = $hotelXml->appendChild($intervalsXml);
					    foreach ($intervals as $interval) {
						$intervalXml = $domtree->createElement('perioada');
						$intervalXml = $intervalsXml->appendChild($intervalXml);
						foreach ($interval as $key => $value) {
						    if (isset(Mapping::$vacation_tags[$key]) && $key != 'id') {
							$intervalXml->appendChild($domtree->createElement(Mapping::$vacation_tags[$key]['tag'], $value));
						    }
						}
					    }
					}
				    }
				}
			    }
			}
		    }
		}
	    }
	    $extra = date('d-m-Y_h:i:s');
	    $domtree->save("downloads/sejur-" . $extra . ".xml");
	    return true;
	}
	return false;
    }

    function importData() {
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
		    $array = $this->xml_to_array($xml);
		    $this->array2Db($array);
		} else {
		    $_SESSION['errors'] = "Please upload an XML file";
		}
	    }
	}
	redirect("/admin/addVacation");
    }

    function xml_to_array($xml,$main_heading = '') {
	$deXml = simplexml_load_string($xml);
	$deJson = json_encode($deXml);
	$xml_array = json_decode($deJson,TRUE);
	if (! empty($main_heading)) {
	    $returned = $xml_array[$main_heading];
	    return $returned;
	} else {
	    return $xml_array;
	}
    }
    
    
    function array2Db($data) {
	$importMapping = Mapping::reverseMapping();
	$exportMapping = Mapping::$vacation_tags;
	if (count($data) > 0) {
	    foreach ($data as $key => $value) {
		$className = '';
		if (isset($importMapping[$key]) && !is_numeric($key) && in_array($importMapping[$key], Mapping::$mapping_nodes)) {
		    $className = ucfirst($importMapping[$key]);
		}
		if ($className) {
		    if (is_array($value)) {
			$classObject = "_" . strtolower($className);
			if ($className == 'Vacation') {
			    foreach ($this->{$classObject}->getDescribe() as $w) {
				if ($w != 'id'){
				    if($w == 'country' || $w == 'city'){
				       $this->{$classObject}->{$w} = $value[$exportMapping[$w]['tag']]['nume']; 
				    }else{
					$this->{$classObject}->{$w} = $value[$exportMapping[$w]['tag']];
				    }
				}
			    }
			    $this->{$classObject}->save();
			}
			foreach ($value as $k => $j) {
			    if(is_array($j) && $k != "tara" && $k != "oras"){
				$this->_vacation->orderBy('id', 'DESC');
				$vacation = $this->_vacation->search();
				foreach ($j as $item => $worth) {
				    if (is_array($worth)) {
					foreach ($worth as $nKey => $nVal) {
					    switch ($importMapping[$item]) {
						case 'airport':
						    $this->saveIntoTable('airport', $nVal, $vacation[0]['id']);
						    break;
						case 'classification':
						    $this->saveIntoTable('classification', $nVal, $vacation[0]['id']);
						    break;
						case 'theme':
						    $this->saveIntoTable('theme', $nVal, $vacation[0]['id']);
						    break;
						case 'photo':
						    $this->addPhotoFromXML($nVal, $vacation[0]['id']);
						    break;
						case 'hotel':
						    $this->addHotelFromXML($nVal, $vacation[0]['id']);
						default :
						    continue;
					    }
					    
					}
				    }
				}
			    }
			}
		    }
		} else if (is_array($value)) {
		    $this->array2Db($value);
		}
	    }
	}
    }

    function saveIntoTable($table, $searchValue, $parentValue) {
	$tableName = '_' . $table;
	$tableNameColumn = $table . '_id';
	$addiacentTableName = '_vacation_' . $table;
	$this->{$tableName}->where(array('name' => $searchValue));
	$result = $this->{$tableName}->search();
	if ($result) {
	    foreach ($result as $rez) {
		$this->{$addiacentTableName}->{$tableNameColumn} = $rez['id'];
		$this->{$addiacentTableName}->vacation_id = $parentValue;
		$this->{$addiacentTableName}->save();
	    }
	}else{
	    $this->{$tableName}->name = $searchValue;
	    $this->{$tableName}->save();
	    $this->{$tableName}->orderBy('id', 'DESC');
	    $data = $this->{$tableName}->search();
	    $this->{$addiacentTableName}->{$tableNameColumn} = $data[0]['id'];
	    $this->{$addiacentTableName}->vacation_id = $parentValue;
	    $this->{$addiacentTableName}->save();
	}
    }

    function addPhotoFromXML($data, $vacationId) {
	if (is_array($data)) {
	    foreach ($array as $data) {
		$this->_photo->file = $data;
		$this->_photo->vacation_id = $vacationId;
		$this->_photo->save();
	    }
	}else{
	    $this->_photo->file = $data;
	    $this->_photo->vacation_id = $vacationId;
	    $this->_photo->save();
	}
    }

    function addHotelFromXML($array, $parentId) {
	$exportMapping = Mapping::$vacation_tags;
	$importMapping = Mapping::reverseMapping();
	foreach ($this->_hotel->getDescribe() as $w) {
	    if ($w != 'id' && isset($exportMapping[$w]))
		$this->_hotel->{$w} = $array[$exportMapping[$w]['tag']];
	}
	$this->_hotel->save();
	$this->_hotel->orderBy('id', 'DESC');
	$lastHotel = $this->_hotel->search();
	$this->_vacation_hotel->hotel_id = $lastHotel[0]['id'];
	$this->_vacation_hotel->vacation_id = $parentId;
	$this->_vacation_hotel->save();
	
	foreach ($array as $k => $val) {
	    if (is_array($val)) {
		foreach ($val as $exK => $exVal) {
		    if (is_array($exVal)) {
			foreach ($exVal as $pK => $pV) {
			    if (is_numeric($pK) && is_array($pV)) {
				$this->_interval->hotel_id = $lastHotel[0]['id'];
				foreach ($pV as $m => $l) {
				    $this->_interval->{$importMapping[$m]} = $l;
				}
				$this->_interval->save();
			    }
			}
		    }
		}
	    }
	}
    }
    
    function hotelFacilities($hotelId){
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
    
    function insertFacility(){
	$this->isLoggedIn();
	if (isset($_POST['id']) && $_POST['id'] != '')
	    $this->_hotel_facility->id = $_POST['id'];
	if (isset($_POST['hotel_id']) && $_POST['hotel_id'] != '')
	    $this->_hotel_facility->hotel_id = $_POST['hotel_id'];
	if (isset($_POST['name']))
	    $this->_hotel_facility->name = $_POST['name'];
	if (isset($_POST['option']))
	    $this->_hotel_facility->option = $_POST['option'];
	$this->_hotel_facility->save();
	redirect("/admin/hotelFacilities/" . $_POST['hotel_id']);
    }
    
    function deleteFacility($id){
	$this->isLoggedIn();
	$this->_hotel_facility->where(array('id' => $id));
	$data = $this->_hotel_facility->search();
	$hotelId = $data[0]['hotel_id'];
	$this->_hotel_facility->id = $id;
	$this->_hotel_facility->delete();
	redirect('/admin/hotelFacilities/' . $hotelId);
    }

    function afterAction() {
	
    }

}
