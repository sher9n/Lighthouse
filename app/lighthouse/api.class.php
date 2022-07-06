<?php
namespace lighthouse;
class Api{
    public static function getGasTankBalance($url,$slug) {
        $url = SOLANA_API."api/".$slug."/getTankBalance";
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

    public static function addSolanaPoints($dao_domain,$to_address,$amount) {

        $url = SOLANA_API."api/".$dao_domain."/addPoints";
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
            "receiver": "'.$to_address.'",
            "amount": "'.$amount.'"
        }';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      //  curl_setopt($curl, CURLOPT_FAILONERROR,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
/*        $error_msg = curl_error($curl);
        var_dump($error_msg);exit();*/
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

    public static function addCommunity($url,$contractName,$tokenName,$tokenSymbol,$tokenDecimals,$tankTopUpAmount,$initialSteward) {
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
          "communityName": "'.$contractName.'",
          "tokenName": "'.$tokenName.'",
          "tokenSymbol": "'.$tokenSymbol.'",
          "tokenDecimals": "'.$tokenDecimals.'",
          "tankTopUpAmount": "'.$tankTopUpAmount.'",
          "initialSteward": "'.$initialSteward.'"
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
        /*$error_msg = curl_error($curl);
        var_dump($error_msg);exit();*/
        return json_decode($response);
    }

    public static function addSolanaCommunity($contractName,$tokenName,$tokenSymbol,$tokenDecimals,$initialSteward) {
        $url = SOLANA_API."api/create";
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
          "name": "'.$contractName.'",
          "tokenName": "'.$tokenName.'",
          "tokenSymbol": "'.$tokenSymbol.'",
          "tokenDecimals": "'.$tokenDecimals.'",
          "initialAdmin": "'.$initialSteward.'"
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
       // curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
/*        $error_msg = curl_error($curl);
        var_dump($error_msg);exit();*/
        curl_close($curl);
        return json_decode($response);
    }

    public static function AddSolanaAttestation($url,$domain,$receiver,$amount,$reason,$tags,$pointsBreakdown) {
        $url = $url."api/".$domain."/addLog";
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
          "amount": "'.$amount.'",
          "reason": "'.$reason.'",
          "tags": "'.$tags.'"
          "pointsBreakdown": "'.$pointsBreakdown.'"
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        /*        $error_msg = curl_error($curl);
                var_dump($error_msg);exit();*/
        curl_close($curl);
        return json_decode($response);
    }

    public static function AddAttestation($url,$domain,$receiver,$amount,$reason,$tags) {
        $url = $url."api/contractsAPI/".$domain."/attest?key=".API_KEY;
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
          "amount": "'.$amount.'",
          "reason": "'.$reason.'",
          "tags": "'.$tags.'"
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        /*        $error_msg = curl_error($curl);
                var_dump($error_msg);exit();*/
        curl_close($curl);
        return json_decode($response);
    }
}
?>