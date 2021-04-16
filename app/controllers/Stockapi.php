<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'core/APP_Frontend.php';
// class Stockapi extends APP_Frontend
// {
//     public function __construct()
//     {
//         parent::__construct();
//     }

//     public function sharesByTotalValue() {
//         var_dump($this->apisdk->call_get('sharesByTotalValue'));
//     }

//     public function sharesByTotalVolume() {
//         var_dump($this->apisdk->call_get('sharesByTotalVolume'));
//     }

//     public function sharesByTotalFrequency() {
//         var_dump($this->apisdk->call_get('sharesByTotalFrequency'));
//     }

//     public function sharesByChange() {
//         var_dump($this->apisdk->call_get('sharesByChange'));
//     }

//     public function sharesByChangePercentage() {
//         var_dump($this->apisdk->call_get('sharesByChangePercentage'));
//     }

//     public function sharesByLoss() {
//         var_dump($this->apisdk->call_get('sharesByLoss'));
//     }

//     public function sharesByLossPercentage() {
//         var_dump($this->apisdk->call_get('sharesByLossPercentage'));
//     }

//     public function indices() {
//         var_dump($this->apisdk->call_get('indices'));
//     }

//     public function indicesIntraday() {
//         var_dump($this->apisdk->call_get('indicesIntraday'));
//     }

//     public function sharesIntraday() {
//         var_dump($this->apisdk->call_get('sharesIntraday'));
//     }

//     public function getOpeningPrice() {
//         var_dump($this->apisdk->call_get('getOpeningPrice'));
//     }
// }