<?php
namespace lighthouse;
class Api{
    public static function getGasTankBalance($url,$dao_domain) {
        $url = $url."api/contractsAPI/".$dao_domain."/getTankInfo?key=".API_KEY;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
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

    public static function getSolanaGasTankBalance($url,$slug) {
        $url = SOLANA_API."api/".$slug."/getTankBalance?key=".SOLANA_API_KEY;
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

        $url = SOLANA_API."api/".$dao_domain."/addPoints?key=".SOLANA_API_KEY;
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

    public static function addCommunityWithoutToken($url,$contractName,$tankTopUpAmount,$initialSteward) {
        $url = $url."api/contractsAPI/createWithoutToken?key=".API_KEY;
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
          "tankTopUpAmount": '.$tankTopUpAmount.',
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

    public static function addSolanaCommunityWithoutMint($contractName,$initialSteward) {
        $url = SOLANA_API."api/createWithoutMint?key=".SOLANA_API_KEY;
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

    public static function addSolanaCommunity($contractName,$tokenName,$tokenSymbol,$tokenDecimals,$initialSteward,$quorumPercent,$votingDuration) {
        $url  = SOLANA_API."api/create?key=".SOLANA_API_KEY;
        $curl = curl_init($url);
        $tokenSymbol = '$rep'.$tokenSymbol;
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
            "tokenDecimals": '.$tokenDecimals.',
            "initialAdmin": "'.$initialSteward.'",
            "quorumPercent": '.$quorumPercent.',
            "votingDuration": '.$votingDuration.'
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
       // curl_setopt($curl, CURLOPT_FAILONERROR,true);
        $response = curl_exec($curl);
        /*$error_msg = curl_error($curl);
        var_dump($error_msg);exit();*/
        curl_close($curl);
        return json_decode($response);
    }

    public static function AddSolanaAttestation($url,$domain,$receiver,$amount,$reason,$tags,$pointsBreakdown) {
        $url = $url."api/".$domain."/addLog?key=".SOLANA_API_KEY;
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
          "tags": "'.$tags.'",
          "pointsBreakdown": "'.$pointsBreakdown.'"
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
                /*$error_msg = curl_error($curl);
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

    public static function realms_get_info($realmKey,$start=null,$end=null) {
        $url  = 'https://realms-api.vercel.app/api/getInfo';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if(is_null($start))
            $data = '{"realmPubKey":"'.$realmKey.'"}';
        else
            $data = '{"realmPubKey":"'.$realmKey.'","start":'.$start.',"end":'.$end.'}';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($curl, CURLOPT_FAILONERROR,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        /*$error_msg = curl_error($curl);
            var_dump($error_msg);exit();*/
        curl_close($curl);
        return json_decode($response);
    }

    public static function realms_update($realmKey) {
        $url  = 'https://realms-api.vercel.app/api/addOrUpdate';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = '{"realmKeys":["'.$realmKey.'"]}';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        /* $error_msg = curl_error($curl);
           var_dump($error_msg);exit();*/
        curl_close($curl);
        return json_decode($response);
    }

    public static function getRealmInfo($url,$governance_pk) {
        $url = $url."api/getRealmInfo?key=".API_KEY;
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
          "councilMintGovPk": "'.$governance_pk.'"
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

    public static function getSolanaRealmsStewards($url,$realm_pk) {
        $url = $url."api/getRealmStewards?key=".API_KEY;
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
          "realmPk": "'.$realm_pk.'"
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

    public static function tokenGated($url,$user,$mount,$mint,$type="NFT",$cluster) {
        $url = $url."api/tokenGated?key=".API_KEY;
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
          "user": "'.$user.'",
          "thresholdAmt": '.$mount.',
          "mintOrCollectionAddress": "'.$mint.'",
          "type": "'.$type.'",
          "cluster": "'.$cluster.'"
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

    public static function addSolanaCommunityWithRealm($contractName,$tokenName,$tokenSymbol,$tokenDecimals,$initialSteward,$yesVoteThreshold,$quorumPercent,$votingDuration) {
        $url = SOLANA_API."api/createWithRealmWithoutMint?key=".SOLANA_API_KEY;
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
            "tokenDecimals": '.$tokenDecimals.',
            "yesVoteThreshold": '.$yesVoteThreshold.',
            "councilMemberPks": ["'.$initialSteward.'"],
            "walletPk": "'.$initialSteward.'",
            "quorumPercent": '.$quorumPercent.',
            "votingDuration": '.$votingDuration.'
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl, CURLOPT_FAILONERROR,true);
        $response = curl_exec($curl);
        /*$error_msg = curl_error($curl);
        var_dump($error_msg);exit();*/
        curl_close($curl);
        return json_decode($response);
    }

    public static function addSolanaCommunityWithRealmWithoutMint($contractName,$initialSteward,$yesVoteThreshold) {
        $url = SOLANA_API."api/createWithRealmWithoutMint?key=".SOLANA_API_KEY;
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
            "yesVoteThreshold": '.$yesVoteThreshold.',
            "councilMemberPks": ["'.$initialSteward.'"],
            "walletPk": "'.$initialSteward.'"
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);
        $response = curl_exec($curl);
        /*$error_msg = curl_error($curl);
        var_dump($error_msg);exit();*/
        curl_close($curl);
        return json_decode($response);
    }

    public static function createLogProposal($url,$community_name,$receiver,$amount,$reason,$tags,$proposalType,$admin,$categories=null) {
        $url = $url."api/$community_name/createLogProposal?key=".SOLANA_API_KEY;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if(is_array($categories)) {
            $categories = json_encode($categories);
            $data = '{
            "admin": "' . $admin . '",
                "proposalType": {
                    "type": "' . $proposalType . '",
                    "receiver": "' . $receiver . '",
                    "reason": "' . $reason . '",
                    "tag": "' . $tags . '",
                    "maxPoints": ' . $amount . ',
                    "categories": '.$categories.'
                }
            }';
        }
        else {
            $data = '{
            "admin": "' . $admin . '",
                "proposalType": {
                    "type": "' . $proposalType . '",
                    "receiver": "' . $receiver . '",
                    "reason": "' . $reason . '",
                    "tag": "' . $tags . '",
                    "maxPoints": ' . $amount . ',
                    "action": "ADD"
                }
            }';
        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
        /* $error_msg = curl_error($curl);
         var_dump($error_msg);exit();*/
        return json_decode($response);
    }

    public static function executePointsProposal($url,$community_name,$proposalId) {
        $url = $url."api/$community_name/executePointsProposal?key=".SOLANA_API_KEY;
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
            "proposalId": "'.$proposalId.'"
        }';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
        /* $error_msg = curl_error($curl);
         var_dump($error_msg);exit();*/
        return json_decode($response);
    }

    public static function executePointProposal($url,$community_name,$proposalId) {
        $url = $url."api/$community_name/executePointsProposal?key=".SOLANA_API_KEY;
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
            "proposalId": "'.$proposalId.'"
        }';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
        /* $error_msg = curl_error($curl);
         var_dump($error_msg);exit();*/
        return json_decode($response);
    }

    public static function executeBasicProposal($url,$community_name,$proposalId) {
        $url = $url."api/$community_name/executeBasicProposal?key=".SOLANA_API_KEY;
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
            "proposalId": "'.$proposalId.'"
        }';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
        /* $error_msg = curl_error($curl);
         var_dump($error_msg);exit();*/
        return json_decode($response);
    }

    public static function executeAdminProposal($url,$community_name,$proposalId,$newAdmin,$action='ADD') {
        $url = $url."api/$community_name/executeAdminProposal?key=".SOLANA_API_KEY;
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
            "proposalId": "'.$proposalId.'",
            "modifiedAdmin": "'.$newAdmin.'",
            "action": "'.$action.'"
        }';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
        /* $error_msg = curl_error($curl);
         var_dump($error_msg);exit();*/
        return json_decode($response);
    }

    public static function getSolanaProposal($url,$community_name,$proposalId) {
        $url = $url."api/$community_name/getProposal?key=".SOLANA_API_KEY;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = '{"proposalId": "'.$proposalId.'"}';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
        /* $error_msg = curl_error($curl);
         var_dump($error_msg);exit();*/
        return json_decode($response);
    }

    public static function getSolanaCommunity($url,$community_name) {
        $url = $url."api/$community_name/getCommunity?key=".SOLANA_API_KEY;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
        /* $error_msg = curl_error($curl);
         var_dump($error_msg);exit();*/
        return json_decode($response);
    }

    public static function solanaProposalVote($url,$community_name,$admin,$proposalId,$vote,$type='BINARY') {
        $url = $url."api/$community_name/vote?key=".SOLANA_API_KEY;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        if($type == Proposal::PROPOSAL_TYPE_SUBJECTIVE){
            $vote = json_encode($vote);
            $data = '{
            "admin": "'.$admin.'",
            "proposalId": "'.$proposalId.'",
            "voteType": {
                "type": "'.$type.'",
                "vote": '.$vote.'
                }
            }';
        }
        else {
            $data = '{
            "admin": "'.$admin.'",
            "proposalId": "'.$proposalId.'",
            "voteType": {
                "type": "'.$type.'",
                "vote": "'.$vote.'"
                }
            }';
        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
       /* $error_msg = curl_error($curl);
        var_dump($error_msg);exit();*/
        return json_decode($response);
    }

    public static function addSolanaQuorumProposal($url,$community_name,$proposer,$new_quorum) {
        $url = $url."api/$community_name/createQuorumProposal?key=".SOLANA_API_KEY;
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
            "admin": "'.$proposer.'",
            "newQuorum": '.$new_quorum.'
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

    public static function addDelegate($url,$community_name,$user) {
        $url = $url."api/$community_name/delegate?key=".SOLANA_API_KEY;
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
            "user": "'.$user.'"
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

    public static function addSolanaAdminProposal($url,$community_name,$newAdmin,$proposer,$action='ADD') {
        $url = $url."api/$community_name/createAdminProposal?key=".SOLANA_API_KEY;
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
            "modifiedAdmin": "'.$newAdmin.'",
            "admin": "'.$proposer.'",
            "action": "'.$action.'"
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

    public static function addSolanaLogProposal($url,$community_name,$receiver,$proposer,$realmPk) {
        $url = $url."api/.$community_name./addLogProposal?key=".SOLANA_API_KEY;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
        );

        $data = '{
            "receiver": "'.$receiver.'",
            "realmPk": "'.$realmPk.'",
            "amount": 0,
            "reason":"null",
            "tags": "null",
            "pointsBreakdown": "null",
            "proposer": "'.$proposer.'"
        }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl, CURLOPT_FAILONERROR,true);

        $response = curl_exec($curl);
        curl_close($curl);
        /*$error_msg = curl_error($curl);
        var_dump($error_msg);exit();*/
        return json_decode($response);
    }
}
?>