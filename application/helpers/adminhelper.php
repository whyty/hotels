<?php

class AdminHelper {
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
    
    function __construct() {
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
    }
    
    public function saveData($model,$data){
	$this->addDataToModel($model, $data);
	$model->save();
    }
    
    function addDataToModel($model,$data){
	$describe = $model->getDescribe();
	foreach($describe as $field){
	    $model->{$field} = $data[$field];
	}
    }
    
    public function modelCountData($model){
	$data = $model->search();
	return $data ? count($data) : 0;
    }
    public function saveData2AdiacentTable($parentIdValue, $parentIdName, $secondaryIdName, $model, $data) {
	if (isset($data)) {
	    $model->where(array($parentIdName => $parentIdValue));
	    $modelData = $model->search();
	    if(count($modelData)){
		foreach($modelData as $item){
		    $model->id = $item['id'];
		    $model->delete();
		}
	    }
	    foreach($data as $value){
		$model->{$parentIdName} = $parentIdValue;
		$model->{$secondaryIdName} = $value;
		$model->save();
	    }
	}
    }
    public function cwUpload($field_name = '', $target_folder = '', $thumb_folder = '', $file_name, $thumb = FALSE, $thumbDimensions = array(array('width' => '', 'height' => ''))) {

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
		foreach($thumbDimensions as $dimensions){
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
		    
		    $imageX = imagesx($source);
		    $imageY = imagesy($source);
		    
		    if($imageX > $imageY){
			$thumbWidth = $dimensions['width'];
			$thumbHeight = $imageY*($dimensions['height']/$imageX);
		    }
		    if($imageX < $imageY){
			$thumbWidth = $imageX*($dimensions['width']/$imageY);
			$thumbHeight = $dimensions['height'];
		    }
		    if($imageX == $imageY){
			$thumbWidth = $dimensions['width'];
			$thumbHeight = $dimensions['height'];
		    }
		    $thumb_create = ImageCreateTrueColor($thumbWidth,$thumbHeight);
		    imagecopyresampled($thumb_create,$source,0,0,0,0,$thumbWidth,$thumbHeight,$imageX,$imageY);
		    $thumbnail = $thumb_path . 'th-' . $dimensions['width'] . 'X' . $dimensions['height'] .'-' . $fileName;
		    switch ($file_ext) {
			case 'jpg' || 'jpeg':
			    imagejpeg($thumb_create, $thumbnail, 80);
			    break;
			case 'png':
			    imagepng($thumb_create, $thumbnail, 8);
			    break;

			case 'gif':
			    imagegif($thumb_create, $thumbnail, 80);
			    break;
			default:
			    imagejpeg($thumb_create, $thumbnail, 80);
		    }
		}
	    }

	    return $fileName;
	} else {
	    return false;
	}
    }
    
    public function deletaDataFromAdiacentTable($parentIdValue, $parentIdName, $model) {
	$model->where(array($parentIdName => $parentIdValue));
	$dataToDelete = $model->search();
	if ($dataToDelete) {
	    foreach ($dataToDelete as $d) {
		$model->id = $d['id'];
		$model->delete();
	    }
	}
    }
    
    
    public function exportData($data = '') {
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
				$photosXml->appendChild($domtree->createElement('poza', BASE_PATH . "/img/uploads/" . $photo['file']));
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
    
    public function xml_to_array($xml, $main_heading = '') {
	$deXml = simplexml_load_string($xml);
	$deJson = json_encode($deXml);
	$xml_array = json_decode($deJson, TRUE);
	if (!empty($main_heading)) {
	    $returned = $xml_array[$main_heading];
	    return $returned;
	} else {
	    return $xml_array;
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
	} else {
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
	} else {
	    $this->_photo->file = $data;
	    $this->_photo->vacation_id = $vacationId;
	    $this->_photo->save();
	}
    }

    public function pagination($data){
	$response = array();
	if(isset($data) && $data['model']){
	    $model = $this->{$data['model']};
	    $model->setPage($data['page']);
	    $model->setLimit((int)$data['perPage']);
	    $dataTable = $model->search();
	    $numPage = ceil($this->modelCountData($model) / $data['perPage']);
	    $collection = '';
	    
	    foreach($dataTable as $d){
		$collection.= '<tr>';
		switch($data['model']){
		    case "_hotel":
			$collection.= '<td>'.$d['name'].'</td>';
			if($d['stars'] > 0){
			    $collection .= '<td>';
			    for ($i = 0; $i < $d['stars']; $i++){
				$collection.='<i class="fa fa-star star-colored"></i>';
			    }
			    $collection.='</td>';
			}
			$collection.='<td>'.$d['meal'].'</td>';
			$collection.='<td>'
				.'<a href="/admin/addHotel/'.$d['id'].'" class="action" title="Edit hotel"><i class="fa fa-pencil"></i></a>'
				.'<a href="/admin/hotelIntervals/'.$d['id'].'" class="action" title="Hotel intervals"><i class="fa fa-clock-o"></i></a>'
				.'<a href="/admin/hotelFacilities/'.$d['id'].'" class="action" title="Hotel facilities"><i class="fa fa-archive"></i></a>'
				.'<a href="/admin/deleteHotel/'.$d['id'].'" onclick="Travel.confirmDelete(event)" class="action" title="Delete hotel"><i class="fa fa-trash-o"></i></a>'
				.'</td>';
			break;
		    case '_airport':
			$collection.= '<td>'.$d['name'].'</td>';
			$collection.='<td>'.$d['country'].'</td>';
			$collection.='<td>'
				.'<a href="/admin/addAirport/'.$d['id'].'" class="action" title="Edit airport"><i class="fa fa-pencil"></i></a>'
				.'<a href="/admin/deleteAirport/'.$d['id'].'" onclick="Travel.confirmDelete(event)" class="action" title="Delete airport"><i class="fa fa-trash-o"></i></a>'
				.'</td>';
			break;
		    case '_classification':
			$collection.='<td>'.$d['name'].'</td>';
			$collection.='<td>'
				.'<a href="/admin/addClassification/'.$d['id'].'" class="action" title="Edit classification"><i class="fa fa-pencil"></i></a>'
				.'<a href="/admin/deleteClassification/'.$d['id'].'" onclick="Travel.confirmDelete(event)" class="action" title="Delete classification"><i class="fa fa-trash-o"></i></a>'
				.'</td>';
			break;
		    case '_theme':
			$collection.='<td>'.$d['name'].'</td>';
			$collection.='<td>'
				.'<a href="/admin/addTheme/'.$d['id'].'" class="action" title="Edit theme"><i class="fa fa-pencil"></i></a>'
				.'<a href="/admin/deleteTheme/'.$d['id'].'" onclick="Travel.confirmDelete(event)" class="action" title="Delete theme"><i class="fa fa-trash-o"></i></a>'
				.'</td>';
			break;
		    case '_vacation':
			$collection.='<td><input type="checkbox" name="vacationSelected[]" value="'.$d['id'].'"></td>';
			$collection.='<td>'.$d['title'].'</td>';
			$collection.='<td>'.$d['country'].'</td>';
			$collection.='<td>'.$d['city'].'</td>';
			$collection.='<td>'.$d['currency'].'</td>';
			$collection.='<td>'
				.'<a href="/admin/addVacation/'.$d['id'].'" class="action" title="Edit vacation"><i class="fa fa-pencil"></i></a>'
				.'<a href="/admin/vacationPhotos/'.$d['id'].'" class="action" title="Vacation photos"><i class="fa fa-picture-o"></i></a>'
				.'<a href="/admin/deleteVacation/'.$d['id'].'" onclick="Travel.confirmDelete(event)" class="action" title="Delete vacation"><i class="fa fa-trash-o"></i></a>'
				.'</td>';
			
			break;
		}
		$collection.='</tr>';
	    }
	    $response = array('numPage' => $numPage, 'itemsList' => $collection, 'model' => $data['model']);
	}
	
	return $response;
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
    
    public function array2Db($data) {
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
				if ($w != 'id') {
				    if ($w == 'country' || $w == 'city') {
					$this->{$classObject}->{$w} = $value[$exportMapping[$w]['tag']]['nume'];
				    } else {
					$this->{$classObject}->{$w} = $value[$exportMapping[$w]['tag']];
				    }
				}
			    }
			    $this->{$classObject}->save();
			}
			foreach ($value as $k => $j) {
			    if (is_array($j) && $k != "tara" && $k != "oras") {
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
}

