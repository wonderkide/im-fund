<?php

namespace app\components;

use Yii;

//https://api.sec.or.th/FundDailyInfo/{proj_id}/dailynav/{nav_date}

class FundApi {
    public $url = 'https://api.settrade.com/api';
    public $start_date;
    public $end_date;
    
    public $amc_url = 'https://api.sec.or.th/FundFactsheet/fund/amc';
    public $fund_url = '';
    public $amc_key = 'a53d258caf3b4488b2ca157d14b6659e';
    public $fund_key = '42bd395a8d464a508181edf08851f4f5';
    
    public function get($url, $decode = true) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $data = null;
        } else {
            if ($decode) {
                $data = json_decode($result, true);
            } else {
                $data = $result;
            }
        }
        return $data;
    }
    
    public function getSec($url, $key, $decode = true){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Cache-Control: no-cache',
            'Ocp-Apim-Subscription-Key:'.$key
          ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
            $data = null;
        } else {
            if ($decode) {
                $data = json_decode($result, true);
            } else {
                $data = $result;
            }
        }
        return $data;
    }
    
    public function getAmc(){
        $result = $this->getSec($this->amc_url, $this->amc_key);
        
        return $result;
    }
    
    public function getFund(){
        $result = $this->getSec($this->fund_url, $this->fund_key);
        
        return $result;
    }
    
    public function getFundNav(){
        $path = 'fund-nav/all';
        $params = '?fromDate=' . $this->start_date . '&toDate=' . $this->end_date;
        
        $url = $this->url . '/' . $path . $params;
        
        $data = $this->get($url);
        
        return $data;
        
    }
}