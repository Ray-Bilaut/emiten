<?php

class Apisdk {
	public $CREDS;
	public $SESSTOKEN;
	public $PROD_URL = "https://trade.profits.co.id/apiEmitenNews/";
	public $STG_URL = "https://trade.profits.co.id/apiEmitenNews/";

	function __construct() {
	}

	public function set_credential($credential) {
		$this->CREDS = $credential;
		$this->CREDS['host'] = (isset($credential['app-production']) and $credential['app-production']) ? $this->PROD_URL : $this->STG_URL;
	}

	public function get_credential() {
		return $this->CREDS;
	}

	public function set_token($token) {
		$this->SESSTOKEN = $token;
	}

	public function get_token() {
		return $this->SESSTOKEN;
	}

	public function call_post($url,$fields,$auth=FALSE,$asis=FALSE,$head=[]) {
		$curl = curl_init();

		$headers = $head;

		if($auth) {
			$headers[] = "Authorization: Bearer ".$this->SESSTOKEN;
		}


		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->CREDS['host'].$url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_POST => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => http_build_query($fields),
			CURLOPT_HTTPHEADER => $headers,
		));

		$response = curl_exec($curl);
		$datas = json_decode($response);

		if($datas->statusCode == 200) {
			return ($asis) ? $datas : $datas->data;
		}

		return $datas;;
	}

	public function call_get($url,$auth=FALSE) {
		$curl = curl_init();

		$headers = [];

		if($auth) {
			$headers[] = "Authorization: Bearer ".$this->SESSTOKEN;
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->CREDS['host'].$url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => $headers,
		));

		$response = curl_exec($curl);
		curl_close($curl);

		$datas = json_decode($response);

		if(isset($datas->s) && $datas->s == "ok") {
			return $datas;
		}

		return false;
	}

	public function call_raw($url,$data,$auth=FALSE,$asis=FALSE) {
		$curl = curl_init();

		$headers = [
			'Content-Type: application/json'
		];

		if($auth) {
			$headers[] = "Authorization: Bearer ".$this->SESSTOKEN;
		}


		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->CREDS['host'].$url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_POST => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_VERBOSE => true
		));

		$response = curl_exec($curl);
		$datas = json_decode($response);

		if(isset($datas->statusCode) and $datas->statusCode == 200) {
			return ($asis) ? $datas : $datas->data;
		}

		return $datas;
	}

	public function call_put($url,$fields,$auth=FALSE,$asis=FALSE) {
		$curl = curl_init();

		$headers = [
			'Content-Type: application/json'
		];

		if($auth) {
			$headers[] = "Authorization: Bearer ".$this->SESSTOKEN;
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->CREDS['host'].$url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_POST => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "PUT",
			CURLOPT_POSTFIELDS => $fields,
			CURLOPT_HTTPHEADER => $headers,
		));

		$response = curl_exec($curl);
		$datas = json_decode($response);

		if($datas->statusCode == 200) {
			return ($asis) ? $datas : $datas->data;
		}

		return $datas;
	}
}