<?php
namespace lighthouse;
class Api{
    public static function getGasTankBalance($slug) {
        $url = "https://lighthouse-poc-seven.vercel.app/api/contractsAPI/".$slug."/getTankBalance?key=".API_KEY;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "accept: application/json",
            "Content-Length: 0",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        $obj = json_decode($response);
        if(!isset($obj->error))
            return $obj->balance;
        else
            return null;
    }

    public static function solana_addPoints($to_address,$amount) {

        $url = "https://lighthouse-poc-seven.vercel.app/api/addSolPoints";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = '{
            "mintAddress": "'.MINT_ADDRESS.'",
            "to": "'.$to_address.'",
            "amount": "'.$amount.'"
        }';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public static function addPoints($url,$dao_domain,$receiver,$amount) {
        $url = $url."api/contractsAPI/".$dao_domain."/addPoints?key=".API_KEY;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = '{
            "receiver": "'.$receiver.'",
            "amount": "'.$amount.'"
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public static function addCommunity($url,$initialAdmin,$contractName,$tokenName,$tokenSymbol,$tokenDecimals,$tankTopUpAmount) {
        $url = $url."api/contractsAPI?key=".API_KEY;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = '{
          "initialAdmin": "'.$initialAdmin.'",
          "contractName": "'.$contractName.'",
          "tokenName": "'.$tokenName.'",
          "tokenSymbol": "'.$tokenSymbol.'",
          "tokenDecimals": "'.$tokenDecimals.'",
          "tankTopUpAmount": "'.$tankTopUpAmount.'"
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}
?>