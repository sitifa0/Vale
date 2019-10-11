<?php
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
date_default_timezone_set('Asia/Jakarta'); //setting waktu timezone ke indonesia
defined('BASEPATH') OR exit('No direct script access allowed');

class WebService extends CI_Controller {
	function __construct(){
		parent::__construct();		
		$uploadconfig["upload_path"] = "./assets/foto_operator/";
		$uploadconfig["allowed_types"] = "gif|jpg|png|zip|jpeg";	
		$uploadconfig["max_size"] = 10240;	
		$this->load->library("upload", $uploadconfig);
	}

	public function get_value() {
		$data = $this->db->query("select id, selisih as jarak, jarak as jrk from tbljarak order by id desc limit 1")->result_array();
		echo json_encode($data);
	}

	public function getSum_value() {
		$data = $this->db->query("select (select id from tbljarak order by id desc limit 1) as id,sum(selisih) as jarak from tbljarak order by id desc limit 1")->result_array();
		echo json_encode($data);
	}

	public function get_cek_username($username, $password) {
		$username = str_replace("%20", " ", $username);
		$password = str_replace("%20", " ", $password);
		$data = $this->mydb->GetCountUser($username, $password);
		echo json_encode($data);
	}

	public function CekUser($username, $password) {
		$username = str_replace("%20", " ", $username);
		$password = str_replace("%20", " ", $password);
		$data = $this->mydb->CekUser($username, $password);
		echo json_encode($data);
	}

	public function GetUsernamebyName($username) {
		$username = str_replace("%20", " ", $username);
		$data = $this->mydb->GetUserbyUsername($username);
		echo json_encode($data);
	}

	public function ManipulationUser($name, $sn, $username, $password, $level, $kode, $id)
	{
		$name = str_replace("%20", " ", $name);
		$username = str_replace("%20", " ", $username);
		$password = str_replace("%20", " ", $password);
		$level = str_replace("%20", " ", $level);

		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tblusername", array(
				"name"=>$name,
				"sn"=>$sn,
				"username"=>$username,
				"password"=>md5($password),
				"level"=>$level
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tblusername", array(
				"name"=>$name,
				"sn"=>$sn,
				"username"=>$username,
				"password"=>md5($password),
				"level"=>$level
			), array("id"=>$id));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tblusername", array("sn"=>$sn));
			if ($res >= 1) {
				redirect("Welcome/input_user");
			}
		}
	}

	public function GetCountTruck($vehicle_id) {
		$vehicle_id = str_replace("%20", " ", $vehicle_id);
		$data = $this->mydb->GetCountTruck($vehicle_id);
		echo json_encode($data);
	}

	public function CekTruckbyName($vehicle_id) {
		$vehicle_id = str_replace("%20", " ", $vehicle_id);
		$data = $this->mydb->GetInputTruckbyName($vehicle_id);
		echo json_encode($data);
	}

	public function ManipulationTruck($unit_model, $vehicle_id, $brand, $ip_address, $ip_display, $cappacity, $kode, $id)
	{
		$unit_model = str_replace("%20", " ", $unit_model);
		$brand = str_replace("%20", " ", $brand);
		$ip_address = str_replace("%20", " ", $ip_address);

		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tbltruck", array(
				"unit_model"=>$unit_model,
				"vehicle_id"=>$vehicle_id,
				"brand"=>$brand,
				"ip_address"=>$ip_address,
				"cappacity"=>$cappacity,
				"ip_display"=>$ip_display
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tbltruck", array(
				"unit_model"=>$unit_model,
				"vehicle_id"=>$vehicle_id,
				"brand"=>$brand,
				"ip_address"=>$ip_address,
				"cappacity"=>$cappacity,
				"ip_display"=>$ip_display
			), array("id"=>$id));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tbltruck", array("vehicle_id"=>$vehicle_id));
			if ($res >= 1) {
				redirect("Welcome/input_truck");
			}
		}
	}

	//Loader
	public function GetCountLoader($vehicle_id) {
		$vehicle_id = str_replace("%20", " ", $vehicle_id);
		$data = $this->mydb->GetCountLoader($vehicle_id);
		echo json_encode($data);
	}

	public function CekLoaderbyName($vehicle_id) {
		$vehicle_id = str_replace("%20", " ", $vehicle_id);
		$data = $this->mydb->GetLoaderbyName($vehicle_id);
		echo json_encode($data);
	}


	public function ManipulationLoader($unit_model, $vehicle_id, $brand, $ip_address, $ip_display, $kode, $id)
	{
		$unit_model = str_replace("%20", " ", $unit_model);
		$brand = str_replace("%20", " ", $brand);
		$ip_address = str_replace("%20", " ", $ip_address);

		if ($kode == 1) { //inserta
			$res = $this->mydb->InsertData("tblloader", array(
				"unit_model"=>$unit_model,
				"vehicle_id"=>$vehicle_id,
				"brand"=>$brand,
				"ip_address"=>$ip_address,
				"ip_display"=>$ip_display
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tblloader", array(
				"unit_model"=>$unit_model,
				"vehicle_id"=>$vehicle_id,
				"brand"=>$brand,
				"ip_address"=>$ip_address,
				"ip_display"=>$ip_display
			), array("id"=>$id));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tblloader", array("vehicle_id"=>$vehicle_id));
			if ($res >= 1) {
				redirect("Welcome/input_loader");
			}
		}
	}

	//Operator
	public function GetOperator() {
		$data = $this->mydb->GetOperator();
		echo json_encode($data);
	}

	public function GetCountOperator($sn) {
		$data = $this->mydb->GetCountOperator($sn);
		echo json_encode($data);
	}

	public function CekOperatorbyName($sn) {
		$data = $this->mydb->GetOperatorbyName($sn);
		echo json_encode($data);
	}

	public function ManipulationOperator($name, $sn, $auth_num, $tag_rfid, $kode, $id)
	{
		$name = str_replace("%20", " ", $name);

		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tbloperator", array(
				"nama"=>$name,
				"no_otorisasi"=>$auth_num,
				"sn"=>$sn,
				"tag_rfid"=>$tag_rfid
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tbloperator", array(
				"nama"=>$name,
				"no_otorisasi"=>$auth_num,
				"sn"=>$sn,
				"tag_rfid"=>$tag_rfid
			), array("id"=>$id));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			 $res = $this->mydb->DeleteData("tbloperator", array("sn"=>$sn));
			if ($res >= 1) {
				redirect("Welcome/input_operator");
			}
		}
	}

	//Time Shift
	public function GetTimeShift() {
		$data = $this->mydb->GetTimeShift();
		echo json_encode($data);
	}

	public function GetCountTimeShift($shift) {
		$data = $this->mydb->GetCountTimeShift($shift);
		echo json_encode($data);
	}

	public function CekTimeShiftbyName($shift) {
		$data = $this->mydb->GetTimeShiftbyName($shift);
		echo json_encode($data);
	}

	public function ManipulationTimeShift($job_as, $description, $time_from, $time_end, $kode, $id)
	{

		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tbltime_shift", array(
				"job_as"=>$job_as,
				"description"=>$description,
				"time_from"=>$time_from,
				"time_end"=>$time_end
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tbltime_shift", array(
				"job_as"=>$job_as,
				"description"=>$description,
				"time_from"=>$time_from,
				"time_end"=>$time_end
			), array("id"=>$id));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tbltime_shift", array("job_as"=>$job_as, "description"=>$description));
			if ($res >= 1) {
				redirect("Welcome/input_time_shift");
			}
		}
	}

	//Setting
	public function GetSetting() {
		$data = $this->mydb->GetSetting();
		echo json_encode($data);
	}

	public function UpdateSetting($eng_over,$speed,$trans_abuse,$gear_miss_use,$brake_abuse,$move_with_body_up,$coasting_neutral,$wheel_speening,$high_susp_press,$overload,$start_abuse,$stop_abuse) {
		$res = $this->mydb->UpdateData("tblsetting", array(
			"eng_over"=>$eng_over,
			"speed"=>$speed,
			"trans_abuse"=>$trans_abuse,
			"gear_miss_use"=>$gear_miss_use,
			"brake_abuse"=>$brake_abuse,
			"move_with_body_up"=>$move_with_body_up,

			"coasting_neutral"=>$coasting_neutral,
			"wheel_speening"=>$wheel_speening,
			"high_susp_press"=>$high_susp_press,
			"overload"=>$overload,
			"start_abuse"=>$start_abuse,
			"stop_abuse"=>$stop_abuse
		), array("id"=>1));
		echo json_encode($res);
	}

	public function input_model($unit_model, $kode) {
		$unit_model = str_replace("%20", " ", $unit_model);
		if ($kode == 1) {
			$res = $this->mydb->InsertData("tblunit_model", array(
					"unit_model"=>$unit_model
				));
			echo json_encode($res);
		}else if($kode == 2) {
			$res = $this->mydb->DeleteData("tblunit_model", array(
					"unit_model"=>$unit_model
				));
			echo json_encode($res);
		}
	}

	//Status
	public function ManipulationStatus($unit, $code, $kode, $category, $id)
	{
		$unit = str_replace("%20", " ", $unit);
		if ($kode == 1) { //insert
			$res = $this->db->query("call insert_status_unit('$unit','$code','$category');");
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->db->query("call insert_status_unit('$unit','$code','$category');");
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tblstatus_unit", array("id"=>$id));
			if ($res >= 1) {
				redirect("Welcome/input_status");
			}
		}
	}

	//Master Status
	public function GetStatus() {
		$data = $this->mydb->GetStatus();
		echo json_encode($data);
	}

	public function GetCountStatus($code) {
		$data = $this->mydb->GetCountStatus($code);
		echo json_encode($data);
	}

	public function CekStatustbyName($code) {
		$data = $this->mydb->CekStatusbyName($code);
		echo json_encode($data);
	}

	public function ManipulationMasterStatus($category, $code, $status, $is_active, $kode, $id)
	{
		$status = str_replace("%20", " ", $status);
		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tblstatus", array(
				"category"=>$category,
				"code"=>$code,
				"status_name"=>$status,
				"is_active"=>$is_active,
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tblstatus", array(
				"category"=>$category,
				"code"=>$code,
				"status_name"=>$status,
				"is_active"=>$is_active,
			), array("id"=>$id));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tblstatus", array("code"=>$code));
			if ($res >= 1) {
				redirect("Welcome/master_status");
			}
		}
	}

	//Input Pit
	public function GetFleetbyLoader() {
		$data = $this->mydb->GetFleetbyLoader();
		echo json_encode($data);
	}

	public function GetCountFleetbyLoader($ticket_fleet) {
		$data = $this->mydb->GetCountFleetbyLoader($ticket_fleet);
		echo json_encode($data);
	}

	public function CekFleetbyLoaderbyName($ticket_fleet) {
		$data = $this->mydb->CekFleetbyLoaderbyName($ticket_fleet);
		echo json_encode($data);
	}

	public function input_pit($pit_name, $kode) {
		$pit_name = str_replace("%20", " ", $pit_name);

		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tblpit", array(
				"pit_name"=>$pit_name
			));
			echo json_encode($res);
		}else if($kode == 2) { //delete
			$res = $this->mydb->DeleteData("tblpit", array("pit_name"=>$pit_name));
			echo json_encode($res);
		}
	}

	public function ManipulationFleet($ticket_fleet, $pit_name, $loader_name, $shift_desc, $operator, $fleet_name, $kode, $id)
	{
		$pit_name = str_replace("%20", " ", $pit_name);
		$loader_name = str_replace("%20", " ", $loader_name);
		$fleet_name = str_replace("%20", " ", $fleet_name);

		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tblfleet_by_loader", array(
				"ticket_fleet"=>$ticket_fleet,
				"pit_name"=>$pit_name,
				"loader_name"=>$loader_name,
				"shift_desc"=>$shift_desc,
				"work_date"=>date("Y-m-d"),
				"operator"=>$operator,
				"fleet"=>$fleet_name
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tblfleet_by_loader", array(
				"ticket_fleet"=>$ticket_fleet,
				"pit_name"=>$pit_name,
				"loader_name"=>$loader_name,
				"shift_desc"=>$shift_desc,
				"work_date"=>date("Y-m-d"),
				"operator"=>$operator,
				"fleet"=>$fleet_name
			), array("id"=>$id));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tblfleet_by_loader", array("ticket_fleet"=>$ticket_fleet));
			$res1 = $this->mydb->DeleteData("tblunit_by_loader", array("ticket_fleet"=>$ticket_fleet));
			if ($res >= 1) {
				redirect("Welcome/input_fleetbyloader");
			}
		}
	}

	public function ManipulationUnitbyLoader($ticket_fleet, $unit_name, $operator, $sn, $kode, $id)
	{
		$unit_name = str_replace("%20", " ", $unit_name);
		$operator = str_replace("%20", " ", $operator);
		
		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tblunit_by_loader", array(
				"ticket_fleet"=>$ticket_fleet,
				"unit_name"=>$unit_name
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tblunit_by_loader", array(
				"operator"=>$operator,
				"sn"=>$sn
			), array("ticket_fleet"=>$ticket_fleet));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tblunit_by_loader", array("ticket_fleet"=>$ticket_fleet,"unit_name"=>$unit_name));
			echo json_encode($res);
		}
	}

	function DeleteFileUpload($file_name) {
		unlink("C:/xampp/htdocs/ckabn/uploads/file/" . $file_name); //hapus file di folder
		$res = $this->mydb->DeleteData("tblupload_file", array("file_name"=>$file_name));
		echo json_encode($res);
	}

	function download_file($dari, $sampai, $unit, $model) {
		/* $dari = str_replace("-", "/", $dari);
		$sampai = str_replace("-", "/", $sampai); */
		if ($model == "CAT777") {
			$res = $this->db->query("call GetDataCAT777('$dari','$sampai','$unit')")->result_array();
			echo json_encode($res);
		}else if ($model == "CAT777V") {
			$res = $this->db->query("call GetDataCAT777V('$dari','$sampai','$unit')")->result_array();
			echo json_encode($res);
		}else if($model == "CAT6030") {
			$res = $this->db->query("call GetDataCAT6030('$dari','$sampai','$unit')")->result_array();
			echo json_encode($res);
		}
		
	}

	public function ManipulationTargetKPI($fleet_production, $fleet_productivity, $payload_cat777, $kode, $id)
	{
		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tbltarget_kpi", array(
				"fleet_production"=>$fleet_production,
				"fleet_productivity"=>$fleet_productivity,
				"payload_cat777"=>$payload_cat777
			));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tbltarget_kpi", array("id"=>$fleet_production));
			echo json_encode($res);
		}
	}

	public function Ping($host){
		exec("ping -c 4 " . $host, $output, $result);
		echo json_encode($output);
	}

	public function SendMessage($idmessage, $message, $ip_display, $operator, $sn, $kode)
	{
		$message = str_replace("%20", " ", $message);
		$operator = str_replace("%20", " ", $operator);

		if ($kode == 1) {
			$res = $this->mydb->InsertData("tblmessage", array(
				"idmessage"=>$idmessage,
				"message"=>$message,
				"status"=>0,
				"ip_display"=>$ip_display,
				"operator"=>$operator,
				"sn"=>$sn,
				"_as"=>'Administrator'
			));
			echo json_encode($res);
		}else if ($kode == 2) {
			$res = $this->mydb->DeleteData("tblmessage", array(
			"idmessage"=>$idmessage));
			echo json_encode($res);
		}
		
	}

	public function GetCountMessage($unit) {
		$res = $this->mydb->GetCountMessage($unit);
		echo json_encode($res);
	}
	
	public function GetLatLongCATD10T($unit, $kode) {
		$res = $this->mydb->GetLatLongCATD10T($unit, $kode);
		echo json_encode($res);
	}
	

	public function GetLatLong($unit, $kode, $unit_model) {
		if ($unit_model == 'all') {			
		 	$res = $this->mydb->GetLatLong($unit, $kode);
			$res2 = $this->mydb->GetLatLongHD785_5($unit, $kode); 
			$res3 = $this->mydb->GetLatLongHD785_7($unit, $kode); 
			$res4 = $this->mydb->GetLatLongCAT390D($unit, $kode); 
			$res5 = $this->mydb->GetLatLongHITACHI($unit, $kode); 
			$res6 = $this->mydb->GetLatLongWHEEL($unit, $kode); 
			$res7 = $this->mydb->GetLatLongPC2000($unit, $kode);  
			$res8 = $this->mydb->GetLatLongCAT16M($unit, $kode);   
			$res9 = $this->mydb->GetLatLongCAT24H($unit, $kode); 
			$res10 = $this->mydb->GetLatLongCATD10T($unit, $kode); 
			$res11 = $this->mydb->GetLatLongD8R($unit, $kode);
			$res12 = $this->mydb->GetLatLongHmaster($unit, $kode);
			$res13 = $this->mydb->GetLatLongHD985_5($unit, $kode);			
			$res14 = $this->mydb->GetLatLongZX870($unit, $kode);			
			echo json_encode(array($res, $res2,  $res3, $res4, $res5, $res6, $res7, $res8, $res9, $res10, $res11, $res12, $res13, $res14));
			/* $res = $this->mydb->GetLatLong($unit, $kode);*/
			//echo json_encode(array(0,0,0,0,0,0,0,0,0,0,0,0,0, $res14)); 
		}else if ($unit_model == 'CAT777D' || $unit_model == 'CAT785C') {
			$res = $this->mydb->GetLatLong($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'HD785-5') {
			$res = $this->mydb->GetLatLongHD785_5($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'HD785-7') {
			//echo 5;
			$res = $this->mydb->GetLatLongHD785_7($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'CAT390D') {
			//echo 6; 
			$res = $this->mydb->GetLatLongCAT390D($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'EX-1900') {
			//echo 6; 
			$res = $this->mydb->GetLatLongHITACHI($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'CAT992') {
			$res = $this->mydb->GetLatLongWHEEL($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'PC-2000') {
			$res = $this->mydb->GetLatLongPC2000($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'CAT16M') {
			$res = $this->mydb->GetLatLongCAT16M($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'CAT24H') {
			$res = $this->mydb->GetLatLongCAT24H($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'CATD10T') {
			$res = $this->mydb->GetLatLongCATD10T($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'CATD8R') { 
			$res = $this->mydb->GetLatLongD8R($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'HAULMASTER') { 
			$res = $this->mydb->GetLatLongHmaster($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'HD985-5') { 
			$res = $this->mydb->GetLatLongHD985_5($unit, $kode); 
			echo json_encode($res);
		}else if ($unit_model == 'ZAXIS-870') { 
			$res = $this->mydb->GetLatLongZX870($unit, $kode); 
			echo json_encode($res);
		}
	}
	
	public function GetCountEvent($unit) {
		$engine_overspeed = $this->mydb->GetCountEvent('engine overspeed', $unit);
		$overspeeding = $this->mydb->GetCountEvent('overspeeding', $unit);
		$trasmission_abuse = $this->mydb->GetCountEvent('trasmission abuse', $unit);
		$gear_miss_use = $this->mydb->GetCountEvent('gear miss use', $unit);
		$move_with_body_up = $this->mydb->GetCountEvent('move with body up', $unit);
		$overload = $this->mydb->GetCountEvent('overload', $unit);
		$wheel_spinning = $this->mydb->GetCountEvent('wheel spinning', $unit);
		$LF_strut_press = $this->mydb->GetCountEvent('LF strut press', $unit);
		$RF_strut_press = $this->mydb->GetCountEvent('RF strut press', $unit);
		$LR_strut_press = $this->mydb->GetCountEvent('LR strut press', $unit);
		$RR_strut_press = $this->mydb->GetCountEvent('RR strut press', $unit);
		$brake_abuse = $this->mydb->GetCountEvent('brake abuse', $unit);
		
		echo json_encode(array($engine_overspeed, $overspeeding, $trasmission_abuse, $gear_miss_use, $move_with_body_up, $overload, $wheel_spinning, $LF_strut_press, $RF_strut_press, $LR_strut_press, $RR_strut_press, $brake_abuse));
	}
	
	public function input_fleet($fleet_name, $kode) {
		$fleet_name = str_replace("%20", " ", $fleet_name);

		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tblmaster_fleet", array(
				"fleet_name"=>$fleet_name
			));
			echo json_encode($res);
		}else if($kode == 2) { //delete
			$res = $this->mydb->DeleteData("tblmaster_fleet", array("fleet_name"=>$fleet_name));
			echo json_encode($res);
		}
	}

	public function GetMonitoringFleet() {
		$res = $this->mydb->GetMonitoringFleet();
		echo json_encode($res);
	}

	public function data_monitoringFleet($tiket) {
		$data = $this->mydb->data_monitoringFleet($tiket);
		echo json_encode($data);
	}

	public function get_current_location($unit_name) {
		$unit_name = str_replace("%20", " ", $unit_name);
		$data = $this->mydb->get_current_location($unit_name);
		echo json_encode($data);
	}

	public function input_currentlocation_loader($latitude, $longitude, $latitudeDP, $longitudeDP, $unit_name) {
		$unit_name = str_replace("%20", " ", $unit_name);
		$data = $this->db->query("select * from tbllocation_loader where loader_name = '$unit_name'")->result_array();
		$data2 = $this->db->query("select FORMAT(get_distance_between_geo_locations('$latitude', '$longitude', '$latitudeDP', '$longitudeDP'), 2) as jarak")->result_array();

		$jarak = $data2[0]['jarak'];
		$count = count($data);
		if ($count == 0) {
	       $res = $this->mydb->InsertData("tbllocation_loader", array(
				"loader_name"=>$unit_name,
				"latitude"=>$latitude,
				"longitude"=>$longitude,
				"latitude_dumping"=>$latitudeDP,
				"longitude_dumping"=>$longitudeDP,
				"distance"=>$jarak
			));
			echo json_encode($res);
	    }elseif ($count > 0){
	        $res = $this->mydb->UpdateData("tbllocation_loader", array(
				"latitude"=>$latitude,
				"longitude"=>$longitude,
				"latitude_dumping"=>$latitudeDP,
				"longitude_dumping"=>$longitudeDP,
				"distance"=>$jarak,
				"timestamps"=>date('Y-m-d H:i:s')
			), array("loader_name"=>$unit_name));
			echo json_encode($res);
	    }		
	} 
	public function view_location($unit_name) {
		$unit_name = str_replace("%20", " ", $unit_name);
		$data = $this->mydb->view_location($unit_name);
		echo json_encode($data);
	}
	
	//input grader
	public function GetCountGrader($vehicle_id) {
		$vehicle_id = str_replace("%20", " ", $vehicle_id);
		$data = $this->mydb->GetCountGrader($vehicle_id);
		echo json_encode($data);
	}

	public function CekGraderbyName($vehicle_id) {
		$vehicle_id = str_replace("%20", " ", $vehicle_id);
		$data = $this->mydb->GetGraderbyName($vehicle_id);
		echo json_encode($data);
	}
	public function ManipulationGrader($unit_model, $vehicle_id, $brand, $ip_address, $ip_display, $kode, $id)
	{
		$unit_model = str_replace("%20", " ", $unit_model);
		$brand = str_replace("%20", " ", $brand);
		$ip_address = str_replace("%20", " ", $ip_address);

		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tblgrader", array(
				"unit_model"=>$unit_model,
				"vehicle_id"=>$vehicle_id,
				"brand"=>$brand,
				"ip_address"=>$ip_address,
				"ip_display"=>$ip_display
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tblgrader", array(
				"unit_model"=>$unit_model,
				"vehicle_id"=>$vehicle_id,
				"brand"=>$brand,
				"ip_address"=>$ip_address,
				"ip_display"=>$ip_display
			), array("id"=>$id));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tblgrader", array("vehicle_id"=>$vehicle_id));
			if ($res >= 1) {
				redirect("Welcome/input_grader");
			}
		}
	}
	
	public function GetParameter($vehicle_id) {
		$data = $this->mydb->GetParameter($vehicle_id);
		echo json_encode($data);
	}

	
	public function event_by_unit($vehicle_id) {
		$data = $this->mydb->GetUnitbyEventByNoLambung($vehicle_id); 
		echo json_encode($data);
	}  
	
	public function GetChartData2($kode, $unit, $nama_table){ 
		$data = $this->mydb->GetChartData($kode, $unit, $nama_table);
		echo json_encode($data);
	}
	
	public function GetChartData($kode, $unit, $nama_table){
		$data = $this->mydb->GetChartData($kode, $unit, $nama_table);
		if ($nama_table != "tblchart_suspension2") {
			
			$total =0;
			
			if (empty($data)) {
				$date = 0;
				$chardata = 0;
				$unit_model = 0;
			}else{
				foreach ($data as $d) {
					//$date[] = $d['tes'];
					if ($nama_table == 'tblchart_engine_speed2') {
						$min[] = [(Float)$d['datetimes'], 1400];
						$max[] = [(Float)$d['datetimes'], 2300];
						$chardata[] = [(Float)$d['datetimes'], (Float)$d['value']];
					}else if ($nama_table == 'tblchart_ground_speed2') {
						$min[] = [(Float)$d['datetimes'], 0];
						$max[] = [(Float)$d['datetimes'], 40];
						$chardata[] = [(Float)$d['datetimes'], (Float)$d['value']];
					}else if ($nama_table == 'tblchart_payload2') {
						if ($d['unit_model'] == 'CAT777' || $d['unit_model'] == 'CAT777D'){
							$min[] = [(Float)$d['datetimes'], 91];
							$max[] = [(Float)$d['datetimes'], 109];
							$chardata[] = [(Float)$d['datetimes'], (Float)$d['value']];
						}else if($d['unit_model'] == 'CAT785C') {
							$min[] = [(Float)$d['datetimes'], 118];
							$max[] = [(Float)$d['datetimes'], 155];
							$chardata[] = [(Float)$d['datetimes'], (Float)$d['value']];
						}
					}

					$unit_model = $d['unit_model'];
					$total += 1;
				}
			}
//			echo json_encode(array('unit_model'=>$unit_model, 'total'=>$total, 'date'=>$date, 'chardata'=>$chardata));
			echo json_encode(array('unit_model'=>$unit_model, 'total'=>$total, 'chardata'=>$chardata, 'max'=>$max, 'min'=>$min));

		}else{					
			$total =0;
			if (empty($data)) {
				$date = 0;
				$left_front  = 0;
				$right_front  = 0;
				$left_rear  = 0;
				$right_rear  = 0;
			}else{
echo $nama_table;
				foreach ($data as $d) {
					//$date[] = $d['datetimes'];
					$left_front[] = [$d['datetimes'], (int)$d['left_front']];
					$right_front[] =[$d['datetimes'],  (int)$d['right_front']];
					$left_rear[] = [$d['datetimes'], (int)$d['left_rear']];
					$right_rear[] = [$d['datetimes'], (int)$d['right_rear']];
					$total += 1;

					if ($nama_table == 'tblchart_suspension2') {
						$min[] = [(Float)$d['datetimes'], 0];
						$max[] = [(Float)$d['datetimes'], 14000];
					}
				}
			}
//			echo json_encode(array('total'=>$total, 'date'=>$date, 'left_front'=>$left_front, 'right_front'=>$right_front, 'left_rear'=>$left_rear, 'right_rear'=>$right_rear));
			echo json_encode(array('total'=>$total,  'left_front'=>$left_front, 'right_front'=>$right_front, 'left_rear'=>$left_rear, 'right_rear'=>$right_rear, 'max'=>$max, 'min'=>$min));

		}
	}
	
	public function GetTruck($kode){
		$data = $this->mydb->GetTruck($kode);
		echo json_encode($data);	
	}
	
	public function online_unit(){
		$data = $this->mydb->online_unit();

		json_encode($data, JSON_PRETTY_PRINT);
	}
	
	public function update_event($unit_name) {
		$res = $this->mydb->UpdateData("tblstatus_event_unit_map", array(
			"status"=>0
		), array("no_lambung"=>$unit_name));
		echo json_encode($res);
	}
	
	public function lastest_event_1day(){
		$data = $this->mydb->lastest_event_1day();
		echo json_encode($data);	
	}
	
	public function get_event_location($event){
		$event = str_replace("%20", " ", $event);
		$data = $this->mydb->get_event_location($event);
		echo json_encode($data);	
	}
	
	public function download_data($from, $to, $unit) {
		$from = str_replace("%20", " ", $from);
		$to = str_replace("%20", " ", $to);
		$unit = str_replace("%20", " ", $unit);
		$data = $this->mydb->download_data($from, $to, $unit);
		echo json_encode($data);	
	}
	
	public function download_event($from, $to, $unit, $parameter) {		
		$from = str_replace("%20", " ", $from);
		$to = str_replace("%20", " ", $to);
		$unit = str_replace("%20", " ", $unit);
		$parameter = str_replace("%20", " ",  $parameter);
		$data = $this->mydb->download_event($from, $to, $unit, $parameter);
		echo json_encode($data);	
	}
	
	public function trend_event() {		
		$data = $this->mydb->trend_event();
		echo json_encode($data);
	}
	
	public function trend_event_by_date() {		
		$data = $this->mydb->trend_event_by_date();
		echo json_encode($data);
	}
	
	public function get_kontur_jalan($unit) {
		$data = $this->mydb->get_kontur_jalan($unit);
		echo json_encode($data);
	}
	
	public function get_kontur_jalan_by_date($from, $to, $unit) {
		$data = $this->mydb->get_kontur_jalan_by_date($from, $to, $unit);
		echo json_encode($data);
	}
	
	public function get_trend_event_by_date($from, $to, $unit) {
		$data = $this->mydb->get_trend_event_by_date($from, $to, $unit);
		echo json_encode($data);
	}
	
	public function chart_by_date($date1, $date2, $unit, $nama_table) {
		if ($nama_table != "tblchart_suspension2" && $nama_table != "tblchart_analysis2") {
			$data = $this->mydb->chart_by_date($date1, $date2, $unit, $nama_table);
			$total =0;
			
			if (empty($data)) {
				$date = 0;
				$chardata = 0;
				$unit_model = 0;		
				$min = 0;
				$max = 0;
			}else{
				foreach ($data as $d) {
					//$date[] = $d['datetimes'];
					$chardata[] = [(Float)$d['datetimes'], (Float)$d['value']];
					$unit_model = $d['unit_model'];
					$total += 1;
					if ($nama_table == 'tblchart_brake_oil_temp2' || $nama_table == 'tblchart_eng_coolant_temp2') {
						$min[] = [(Float)$d['datetimes'], 75];
						$max[] = [(Float)$d['datetimes'], 90];
					}elseif ($nama_table == 'tblchart_eng_oil_press2') {
						$min[] = [(Float)$d['datetimes'], 300];
						$max[] = [(Float)$d['datetimes'], 550];
					}elseif ($nama_table == 'tblchart_engine_speed2') {
						$min[] = [(Float)$d['datetimes'], 1400];
						$max[] = [(Float)$d['datetimes'], 2300];
					}elseif ($nama_table == 'tblchart_fuel_level2' || $nama_table == 'tblchart_ground_speed2') {	
						$min[] = [0];
						$max[] = [(Float)$d['datetimes'], 40];
					}elseif ($nama_table == 'tblchart_payload2') {
						if ($d['unit_model'] == 'CAT777' || $d['unit_model'] == 'CAT777D') {
							$min[] = [(Float)$d['datetimes'], 91];
							$max[] = [(Float)$d['datetimes'], 109];
						}elseif ($d['unit_model'] == 'CAT785C') {
							$min[] = [(Float)$d['datetimes'], 118];
							$max[] = [(Float)$d['datetimes'], 155];
						}
					}elseif ($nama_table == 'tblchart_throttle_position2') {	
						$min[] = [0];
						$max[] = [(Float)$d['datetimes'], 90];
					}elseif ($nama_table == 'tblchart_actual_gear2') {	
						$min[] = [0];
						$max[] = [0];
					}	
				}				
			}

			//echo json_encode(array('unit_model'=>$unit_model, 'total'=>$total, 'date'=>$date, 'chardata'=>$chardata));
			echo json_encode(array('unit_model'=>$unit_model, 'total'=>$total, 'chardata'=>$chardata, 'min'=>$min, 'max'=>$max));
			
		}else if ($nama_table == "tblchart_analysis2") {
			$data = $this->mydb->chart_by_date($date1, $date2, $unit, $nama_table);
			$total =0;
			
			if (empty($data)) {				
				$date = 0;
				$service_brake = 0;
				$retarder_status = 0;
				$altitude = 0;
				$throttle = 0;
				$unit_model = 0;		
			}else{				
				foreach ($data as $d) {				
					$service_brake[] = [(Float)$d['datetimes'], (int)$d['service_brake']];
					$retarder_status[] = [(Float)$d['datetimes'], (int)$d['retarder_status']];
					$altitude[] = [(Float)$d['datetimes'], (int)$d['altitude']];
					$throttle[] = [(Float)$d['datetimes'], (int)$d['throttle']];
					$unit_model = $d['unit_model'];
					$total += 1;
				}		
			}

			echo json_encode(array('unit_model'=>$unit_model, 'total'=>$total, 'service_brake'=>$service_brake, 'retarder_status'=>$retarder_status, 'altitude'=>$altitude, 'throttle'=>$throttle));
		}else if ($nama_table == "tblchart_suspension2") {			
			$data = $this->mydb->chart_by_date($date1, $date2, $unit, $nama_table);
			$total =0;			
			if (empty($data)) {
				$date = 0;
				$left_front = 0;
				$right_front = 0;
				$left_rear = 0;
				$right_rear = 0;
				$max = 0;
			}else{
				foreach ($data as $d) {
					//$date[] = $d['datetimes'];
					$left_front[] = [(Float)$d['datetimes'], (int)$d['left_front']];
					$right_front[] = [(Float)$d['datetimes'], (int)$d['right_front']];
					$left_rear[] = [(Float)$d['datetimes'], (int)$d['left_rear']];
					$right_rear[] = [(Float)$d['datetimes'], (int)$d['right_rear']];					
					$max[] = [(Float)$d['datetimes'], 14000];	
					$total += 1;
				}
			}
			
			echo json_encode(array('total'=>$total, 'left_front'=>$left_front, 'right_front'=>$right_front, 'left_rear'=>$left_rear, 'right_rear'=>$right_rear, 'max'=>$max));
		}
	}
	
	
	public function chart_by_date3($date1, $date2, $unit) {
			$data = $this->mydb->chart_by_date($date1, $date2, $unit, 'tblchart_suspension2');
			$dataSpeed = $this->mydb->chart_by_date($date1, $date2, $unit, "tblchart_ground_speed2");
			$total =0;
			
			if (empty($data)) {
				//$date = 0;
				$left_front = 0;
				$right_front = 0;
				$left_rear = 0;
				$right_rear = 0;
				$max = 0;
			}else{
				foreach ($data as $d) {
					//$date[] = $d['datetimes'];
					$left_front[] = [(Float)$d['datetimes'], (int)$d['left_front']];
					$right_front[] = [(Float)$d['datetimes'], (int)$d['right_front']];
					$left_rear[] = [(Float)$d['datetimes'], (int)$d['left_rear']];
					$right_rear[] = [(Float)$d['datetimes'], (int)$d['right_rear']];					
					$max[] = [(Float)$d['datetimes'], 14000];	
				}
			}
			
			if (empty($dataSpeed)) {
				$speed = 0;
			}else{
				foreach ($dataSpeed as $d) {
					$speed[] = [(Float)$d['datetimes'], (int)$d['value']];
				}
			}
			
			echo json_encode(array('total'=>$total, 'left_front'=>$left_front, 'right_front'=>$right_front, 'left_rear'=>$left_rear, 'right_rear'=>$right_rear, 'speed'=>$speed, 'max'=>$max));
	}

	public function chart_by_date2($date1, $date2, $unit) {
			$data = $this->mydb->chart_analysis2($date1, $date2, $unit, 'tblchart_analysis');
			$total =0;
			foreach ($data as $d) {
				$datetimes[] = $d['datetimes'];
				$service_brake[] = (int)$d['service_brake'];
				$retarder_status[] = (int)$d['retarder_status'];
				$altitude[] = (int)$d['altitude'];
				$total += 1;
		
			echo json_encode(array('total'=>$total, 'datetimes'=>$datetimes, 'service_brake'=>$service_brake, 'retarder_status'=>$retarder_status, 'altitude'=>$altitude));
	}
	}

	
	public function GetDataEventByDate($kode, $parameter) {
		$parameter = str_replace("%20", " ", $parameter);
		$data = $this->mydb->GetDataEventByDate($kode, $parameter);
		echo json_encode($data);
	}
	
	public function GetLatLongHD785_5($unit, $kode) {
		$res = $this->mydb->GetLatLongHD785_5($unit, $kode);
		echo json_encode($res);
	}
	
	public function GetLatLongHD785_7($unit, $kode) {
		$res = $this->mydb->GetLatLongHD785_7($unit, $kode);
		echo json_encode($res);
	}
	
	public function GetLatLongCAT390D($unit, $kode) {
		$res = $this->mydb->GetLatLongCAT390D($unit, $kode);
		echo json_encode($res);
	}
	
	public function GetParameter785HD_7($vehicle_id) {
		$data = $this->mydb->GetParameter785HD_7($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameter785HD_5($vehicle_id) {
		$data = $this->mydb->GetParameter785HD_5($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterCAT390D($vehicle_id) {
		$data = $this->mydb->GetParameterCAT390D($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterPC2000($vehicle_id) {
		$data = $this->mydb->GetParameterPC2000($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterCAT992($vehicle_id) {
		$data = $this->mydb->GetParameterCAT992($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterCAT24H($vehicle_id) {
		$data = $this->mydb->GetParameterCAT24H($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterCATD10T($vehicle_id) {
		$data = $this->mydb->GetParameterCATD10T($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterHD985_5($vehicle_id) {
		$data = $this->mydb->GetParameterHD985_5($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetTruckbyNameUnit($unit){
		$data = $this->mydb->GetTruckbyNameUnit($unit);
		echo json_encode($data);	
	}
	
	public function track_location($parameter, $date1, $date2, $unit){
		$date1 = str_replace("%20", " ", $date1);
		$date2 = str_replace("%20", " ", $date2);		 
		
		if ($parameter == 'enginespeed') {
			$data = $this->mydb->GetTrackLocation('tblchart_engine_speed2', $date1, $date2, $unit);
			
		}else if ($parameter == 'groundspeed') {
			$data = $this->mydb->GetTrackLocation('tblchart_ground_speed2', $date1, $date2, $unit);
			
		}else if ($parameter == 'brakeoil') {
			$data = $this->mydb->GetTrackLocation('tblchart_brake_oil_temp2', $date1, $date2, $unit);
			
		}else if ($parameter == 'enginecoolant') {
			$data = $this->mydb->GetTrackLocation('tblchart_eng_coolant_temp2', $date1, $date2, $unit);
			
		}else if ($parameter == 'engineoil') {
			$data = $this->mydb->GetTrackLocation('tblchart_eng_oil_temp2', $date1, $date2, $unit);
			
		}else if ($parameter == 'fuellevel') {
			$data = $this->mydb->GetTrackLocation('tblchart_fuel_level2', $date1, $date2, $unit);
			
		}else if ($parameter == 'payload') {
			$data = $this->mydb->GetTrackLocation('tblchart_payload2', $date1, $date2, $unit);
			
		}else if ($parameter == 'suspension') {
			$data = $this->mydb->GetTrackLocation('tblchart_suspension2', $date1, $date2, $unit);
			
		}else if ($parameter == 'throttle') {
			$data = $this->mydb->GetTrackLocation('tblchart_throttle_position2', $date1, $date2, $unit);
		
		}else if ($parameter == 'actualgear') {
			$data = $this->mydb->GetTrackLocation('tblchart_actual_gear2', $date1, $date2, $unit);
			
		}
		
		/* if (empty($data)) {
			$data = 0;
		}else{
			foreach ($data as $d) {
				$data[] = (int)$d['value'];
			}
		} */
		
		echo json_encode($data);		
	}
	
	public function chartEventOverview() {
		$data = $this->mydb->chartEventOverview();
		if (empty($data)) {
			//$date = 0;
			$chardata = 0;
		}else{
			$c = 0;
			$cd1tahun;
			$cd1bulan;
			$cd1hari;
			
			$cd2tahun;
			$cd2bulan;
			$cd2hari;
			foreach ($data as $d) {
				//$date[] = $d['bulan'];
				if ($c == 0) {
					$cd1tahun = (int)date("Y", strtotime($d['date']));
					$cd1bulan = (int)date("m", strtotime($d['date']));
					$cd1hari = (int)date("d", strtotime($d['date']));
					$c = 1;
				}
				$chardata[] = [(Float)$d['datetimes'], (int)$d['total']];
				$c = $c + 1;
				$cd2tahun = (int)date("Y", strtotime($d['date']));
				$cd2bulan = (int)date("m", strtotime($d['date']));
				$cd2hari = (int)date("d", strtotime($d['date']));
				
			}
		}
		echo json_encode(array('chardata'=>$chardata, 'cd1tahun'=>$cd1tahun, 'cd1bulan'=>$cd1bulan, 'cd1hari'=>$cd1hari, 'cd2tahun'=>$cd2tahun, 'cd2bulan'=>$cd2bulan, 'cd2hari'=>$cd2hari,));
	}
	
	public function PopulationEventOverview() {
		$data = $this->mydb->detailEventOverview();
		if (empty($data)) {
			//$date = 0;
			$chardata = 0;
		}else{
			foreach ($data as $d) {
				//$date[] = $d['bulan'];
				$chardata[] = [$d['event'], (int)$d['total']];
			}
		}
		echo json_encode(array('chardata'=>$chardata));
	}

	public function GetParameterCAT16M($vehicle_id) {
		$data = $this->mydb->GetParameterCAT16M($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterD8R($vehicle_id) {
		$data = $this->mydb->GetParameterD8R($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterHmaster($vehicle_id) {
		$data = $this->mydb->GetParameterHmaster($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterHITACHI($vehicle_id) {
		$data = $this->mydb->GetParameterHITACHI($vehicle_id);
		echo json_encode($data);
	}
	
	public function GetParameterZX870($vehicle_id) {
		$data = $this->mydb->GetParameterZX870($vehicle_id);
		echo json_encode($data);
	}
	
	public function ConfirmEvent($id_event, $id_user, $action) {
		$action = str_replace("%20", " ", $action);	
		$res = $this->mydb->InsertData("tblconfirm_event", array(
			"id_event"=>$id_event,
			"id_user"=>$id_user,
			"action"=>$action			
		));
		 
		$this->mydb->UpdateData("tblevent", array(
			"status"=>1
		), array("id"=>$id_event));	
		
		 
		echo json_encode($res);
	}
	
	public function count_event_groupmodel() {
		$res = $this->mydb->count_event_groupmodel();
		echo json_encode($res);
	}

	public function count_event_map($no_lambung) {
		$res = $this->mydb->count_event_mapToday($no_lambung);
		$res2 = $this->mydb->count_event_mapLast30Day($no_lambung);
		echo json_encode(array($res, $res2));
	}

	public function chart_by_date_realtime($unit, $nama_table) {
			$data = $this->mydb->chart_by_date_realtime($unit, $nama_table);
			if (empty($data)) {
				$chardata = 0;
			}else{
				foreach ($data as $d) {
					$chardata = [(Float)$d['datetimes'], (Float)$d['value']];
				}							
			}

			echo json_encode(array('chardata'=>$chardata));
	}

	public function chart_by_date_realtime_basic($unit, $nama_table) {
			$data = $this->mydb->chart_by_date_realtime_basic($unit, $nama_table);
			if (empty($data)) {
				$chardata = 0;
				$limit = 0;
				$min = 0;
				$max = 0;
			}else{
				foreach ($data as $d) {
					$chardata[] = [(Float)$d['datetimes'], (Float)$d['value']];
					if ($nama_table == 'tblchart_engine_speed2') {
							$limit = 2200;
							$min = 1900;
							$max = 3000;
					}else if ($nama_table == 'tblchart_ground_speed2') {
							$limit = 40;
							$min = 30;
							$max = 70;
					}else if ($nama_table == 'tblchart_actual_gear2') {
							$limit = 7;
							$min = 0;
							$max = 9;
					}else if ($nama_table == 'tblchart_brake_oil_temp2' || $nama_table == 'tblchart_eng_coolant_temp2' || $nama_table == 'tblchart_fuel_level2') {
							$limit = 90;
							$min = 80;
							$max = 100;
					}else if ($nama_table == 'tblchart_payload2') {
						if ($d['unit_model'] == 'CAT785C') {
							$limit = 155;
							$min = 145;
							$max = 200;
						}else{
							$limit = 110;
							$min = 90;
							$max = 120;
						}
					}else if ($nama_table == 'tblchart_eng_oil_press2') {
						$limit = 600;
						$min = 400;
						$max = 550;
					}else if ($nama_table == 'tblchart_lf' || $nama_table == 'tblchart_lr' || $nama_table == 'tblchart_rf' || $nama_table == 'tblchart_rr') {
						$limit = 14000;
						$min = 12000;
						$max = 30000;
					}
				}							
			}

			echo json_encode(array('chardata'=>$chardata, 'limit'=>$limit, 'min'=>$min, 'max'=>$max));
	}

	public function get_fmi($id_code) {
		$data = $this->mydb->get_fmi($id_code);		
		echo json_encode($data);
	}	

	public function  chart_runwith_brake($date1, $date2, $unit) {
		$date1 = str_replace("%20", " ", $date1);
		$date2 = str_replace("%20", " ", $date2);
		//service brake
		$data1 = $this->mydb->chart_runwith_brake(1, $date1, $date2, $unit);	
		if (empty($data1)) {
			$chardataServiceBrake = 0;
		}else{	
			foreach ($data1 as $d) {
				$chardataServiceBrake[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

		//engine speed
		$data2 = $this->mydb->chart_runwith_brake(2, $date1, $date2, $unit);			
		if (empty($data2)) {
			$chardataEngineSpeed = 0;
		}else{
			foreach ($data2 as $d) {
				$chardataEngineSpeed[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
		}

		//ground speed
		$data3 = $this->mydb->chart_runwith_brake(3, $date1, $date2, $unit);			
		if (empty($data3)) {
			$chardataGroundSpeed = 0;
		}else{
			foreach ($data3 as $d) {
				$chardataGroundSpeed[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
		}

		//brake air press
		$data4 = $this->mydb->chart_runwith_brake(4, $date1, $date2, $unit);			
		if (empty($data4)) {
			$chardataBrakeAirPress = 0;
		}else{
			foreach ($data4 as $d) {
				$chardataBrakeAirPress[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
		}

		echo json_encode(array('engine_speed'=>$chardataEngineSpeed, 'service_brake'=>$chardataServiceBrake,'ground_speed'=>$chardataGroundSpeed,'brake_air_press'=>$chardataBrakeAirPress)); 
	}

	public function  chart_lowpower($date1, $date2, $unit) {
		$date1 = str_replace("%20", " ", $date1);
		$date2 = str_replace("%20", " ", $date2);
		//engine speed
		$data1 = $this->mydb->chart_lowpower(1, $date1, $date2, $unit);	
		if (empty($data1)) {
			$chardataEngineSpeed = 0;
		}else{	
			foreach ($data1 as $d) {
				$chardataEngineSpeed[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		//engine load factor
		$data2 = $this->mydb->chart_lowpower(2, $date1, $date2, $unit);	
		if (empty($data2)) {
			$chardataEngineLoadFactor = 0;
		}else{	
			foreach ($data2 as $d) {
				$chardataEngineLoadFactor[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		//engine oil press
		$data3 = $this->mydb->chart_lowpower(3, $date1, $date2, $unit);	
		if (empty($data3)) {
			$chardataEngineOilPress = 0;
		}else{	
			foreach ($data3 as $d) {
				$chardataEngineOilPress[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		//engine coolant temp
		$data4 = $this->mydb->chart_lowpower(4, $date1, $date2, $unit);	
		if (empty($data4)) {
			$chardataEngineCoolant = 0;
		}else{	
			foreach ($data4 as $d) {
				$chardataEngineCoolant[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		//engine coolant temp
		$data5 = $this->mydb->chart_lowpower(5, $date1, $date2, $unit);	
		if (empty($data5)) {
			$chardataAirFilterRestric = 0;
		}else{	
			foreach ($data5 as $d) {
				$chardataAirFilterRestric[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

		echo json_encode(array('engine_speed'=>$chardataEngineSpeed, 'engine_load_factor'=>$chardataEngineLoadFactor, 'engine_oil_press'=>$chardataEngineOilPress, 'engine_coolant'=>$chardataEngineCoolant, 'air_filter_restric'=>$chardataAirFilterRestric)); 
	}


	public function  chart_engineblowby($date1, $date2, $unit) {
		$date1 = str_replace("%20", " ", $date1);
		$date2 = str_replace("%20", " ", $date2);
		//engine speed
		$data1 = $this->mydb->chart_engineblowby(1, $date1, $date2, $unit);	
		if (empty($data1)) {
			$chardataBoostPress = 0;
		}else{	
			foreach ($data1 as $d) {
				$chardataBoostPress[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		//engine load factor
		$data2 = $this->mydb->chart_engineblowby(2, $date1, $date2, $unit);	
		if (empty($data2)) {
			$chardataCrankcasePress = 0;
		}else{	
			foreach ($data2 as $d) {
				$chardataCrankcasePress[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		echo json_encode(array('boost_press'=>$chardataBoostPress, 'cranckase_press'=>$chardataCrankcasePress)); 
	}

	public function  chart_turbocondition($date1, $date2, $unit) {
		$date1 = str_replace("%20", " ", $date1);
		$date2 = str_replace("%20", " ", $date2);
		//engine speed
		$data1 = $this->mydb->chart_turbocondition(1, $date1, $date2, $unit);	
		if (empty($data1)) {
			$chardataEngineSpeed = 0;
		}else{	
			foreach ($data1 as $d) {
				$chardataEngineSpeed[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		//engine Left Exhaust
		$data2 = $this->mydb->chart_turbocondition(2, $date1, $date2, $unit);	
		if (empty($data2)) {
			$chardataLeftExhaust = 0;
		}else{	
			foreach ($data2 as $d) {
				$chardataLeftExhaust[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		//engine Right Exhaust
		$data3 = $this->mydb->chart_turbocondition(3, $date1, $date2, $unit);	
		if (empty($data3)) {
			$chardataRightExhaust = 0;
		}else{	
			foreach ($data3 as $d) {
				$chardataRightExhaust[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		echo json_encode(array('engine_speed'=>$chardataEngineSpeed, 'left_exhaust'=>$chardataLeftExhaust, 'right_exhaust'=>$chardataRightExhaust)); 
	}

	public function  chart_engineoilpump($date1, $date2, $unit) {
		$date1 = str_replace("%20", " ", $date1);
		$date2 = str_replace("%20", " ", $date2);
		//engine speed
		$data1 = $this->mydb->chart_engineoilpump(1, $date1, $date2, $unit);	
		if (empty($data1)) {
			$chardataEngineSpeed = 0;
		}else{	
			foreach ($data1 as $d) {
				$chardataEngineSpeed[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		//engine oil press
		$data2 = $this->mydb->chart_engineoilpump(2, $date1, $date2, $unit);	
		if (empty($data2)) {
			$chardataOilPress = 0;
		}else{	
			foreach ($data2 as $d) {
				$chardataOilPress[] = [(Float)$d['datetimes'], (Float)$d['value']];		
			}				
 		}

 		echo json_encode(array('engine_speed'=>$chardataEngineSpeed, 'OilPress'=>$chardataOilPress)); 
	}


	public function input_map_operation($unit, $operation)
	{
		$count = $this->mydb->countMapOperation($unit, $operation);	

		if ($count == 0) {
			$res = $this->mydb->InsertData("tblmap_operation", array(
				"no_lambung"=>$unit,
				"operation"=>$operation,
			));
			echo json_encode($res);
		}else{
			$res = $this->mydb->UpdateData("tblmap_operation", array(
				"operation"=>$operation,
			), array("no_lambung"=>$unit));
			echo json_encode($res);
		}	
	}


	public function ManipulationPM($unit, $smu, $date, $kode, $id)
	{
		if ($kode == 1) { //insert
			$res = $this->mydb->InsertData("tblPM", array(
				"no_lambung"=>$unit,
				"date"=>$date,
				"smu"=>$smu,
				"next_pm"=>($smu + 300)
			));
			echo json_encode($res);
		}else if($kode == 2) { //update
			$res = $this->mydb->UpdateData("tblPM", array(
				"no_lambung"=>$unit,
				"date"=>$date,
				"smu"=>($smu + 300),
			), array("id"=>$id));
			echo json_encode($res);
		}else if($kode == 3) { //delete
			$res = $this->mydb->DeleteData("tblPM", array("id"=>$id));
			if ($res >= 1) {
				redirect("Welcome/input_pmcheck");
			}
		}
	}
	
	public function getketerangankode($kode) {
		$data = $this->mydb->getketerangankode($kode);	
		echo json_encode(array('data'=>$data));
		
	}
}



