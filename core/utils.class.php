<?php
namespace Core;

class Utils {
	private static $instance;

    public static function removeTextBeforeMatch($string, $match)
    {
        if(preg_match("/".$match."/i", $string))
            return trim(str_ireplace($match,"",$string));
        else
           return $string;
    }

    public static function coinAddressFormat($address) {
        if(strlen($address) > 0) {
            $first = substr($address, 0,6);
            $last = substr($address, -4);
            return $first . '...' . $last;
        }
        else
            return '';
    }

    public static function LightHouseApi($endpoint,$post=null)
    {
        //var_dump($endpoint);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, app_api_url.DS.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if(is_array($post)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        else
            curl_setopt($ch, CURLOPT_POST, 0);
       // curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $data = curl_exec($ch);
      //  $error_msg = curl_error($ch);
       // var_dump($error_msg);exit();
        curl_close($ch);
        $response = json_decode($data, true);
        return $response;
    }

    public static function snapshotApi($address) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://hub.snapshot.org/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"query":"query Votes{votes(first:100000\\r\\nskip: 0\\r\\nwhere:{voter:\\"'.$address.'\\"}orderBy: \\"created\\",orderDirection: desc) {voter\\r\\n proposal{title}space{id}}}","variables":{}}',
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public static function graphqlApi($address) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graphql.bitquery.io',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"query":"{ethereum{address(address:{is: \\"'.$address.'\\"}){balances{currency{symbol}value}}}}","variables":{}}',
            CURLOPT_HTTPHEADER => array(
                'X-API-KEY: '.GRAPH_QL_KEY,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public static function getTweetIdByUsername($twitter_username) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.twitter.com/2/users/by/username/'.$twitter_username,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer AAAAAAAAAAAAAAAAAAAAANeUYQEAAAAAoIjX1OWz%2Bfteb1Pw4rh8YXRmtVw%3DmhnvrEsQRXY8pBjM37sNctmYhiR3XNWUhFAw72UDFToq01ua0y',
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if(isset($response->errors))
            return null;
        else
            return $response->data->id;
    }

    public static function getTweet($type='tweets',$twitter_username,$id=null) {

        if(is_null($id))
           $id = Utils::getTweetIdByUsername($twitter_username);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.twitter.com/2/users/'.$id.'/'.$type,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer AAAAAAAAAAAAAAAAAAAAANeUYQEAAAAAoIjX1OWz%2Bfteb1Pw4rh8YXRmtVw%3DmhnvrEsQRXY8pBjM37sNctmYhiR3XNWUhFAw72UDFToq01ua0y',
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public static function etherscanApiECR20($address) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.etherscan.io/api?module=account&action=tokentx&address='.$address.'&page=1&offset=100&startblock=0&endblock=27025780&sort=asc&apikey='.ETHERSCAN_TOKEN,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public static function etherscanApiECR721($address) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.etherscan.io/api?module=account&action=tokennfttx&address='.$address.'&page=1&offset=100&startblock=0&endblock=27025780&sort=asc&apikey='.ETHERSCAN_TOKEN,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public static function lineBreak($review) {
        $review = str_replace(" I ", " i ", $review);
        $review = str_replace(" A ", " a ", $review);

        preg_match_all('/\b([A-Z]+)\b/', $review, $capitalized_words);

        foreach($capitalized_words[0] as $c_word)
        {
            $lowercase_c_word = strtolower($c_word);
            $review = str_replace(" {$c_word} ", " {$lowercase_c_word} ", $review);
        }

        $result = preg_split("/(?=(?<![A-Z]|^)[A-Z])/", $review);
        $review_lines = '';

        foreach ($result as $index => $line){
            $line = rtrim($line);
            $str_word_count = str_word_count($line,0);
            $str_next_word_count = isset($result[$index+1])?str_word_count(isset($result[$index+1]),1):array();
            if(substr($line,-1) != '.' && $str_word_count > 2) {
                if(count($str_next_word_count) > 0 && strpos('.',$str_next_word_count[0]) == false)
                    $line = $line . '.';
            }
            $review_lines = $review_lines.' '.$line;
        }

        return $review_lines;
    }

    public static function divideToLines($text) {

        // split sentence to array
        $sentence_array = preg_split('/\s+/', $text);
        $sentence       = "";
        $sentence_list  = array();

        foreach($sentence_array as $word)
        {
            // Reset on conjunction
            if(Utils::is_conjunction_word($word))
            {
                array_push($sentence_list, $sentence);
                $sentence = "";
            }

            // Add word to sentence
            $sentence .= $word;

            // Reset on fullstop otherwise add a space so the next word can fit in
            if(Utils::contains_fullstop($word))
            {
                array_push($sentence_list, $sentence);
                $sentence = "";
            }
            else
            {
                $sentence .= " ";
            }
        }

        // Add last element to sentence list
        array_push($sentence_list, $sentence);

        // Clean array
        foreach($sentence_list as $key => $each_sentence)
        {
            // Remove strings that don't contain atleast one letter - it's garbedge
            if(!preg_match("/[a-z]/i",$each_sentence))
                unset($sentence_list[$key]);
        }

        return $sentence_list;
    }

    public static function is_conjunction_word($word)
    {
        $conjunction = array('but','yet','or');
        return in_array($word, $conjunction);
    }

    public static function contains_fullstop($word)
    {
        return (strpos($word, '.') !== false);
    }

    public static function removeSpecialCharacters($string) {
        // Remove special characters but keep spaces
        $string = trim(strip_tags($string));
        $string = str_replace("\xc2\xa0",'',$string);
        $string = str_replace("nbsp",'',$string);
        $string = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $string)));
        return preg_replace('/[^A-Za-z0-9\ .]/', '', $string);
    }

    public static function tokenize($string) {
        // Split striing into tokens breaking it by spaces - even if it has multiple spaces between words
        return preg_split('/\s+/', $string); // Removes special chars.
    }

    public static function word_count($text, $excludes=array(), $sort = 'ar')
    {
        $text = " " . strtoupper($text) . " ";

        $cloud = array();

        $words = preg_split('/\s+/', $text);
        //$words = str_word_count($text, 1);

        foreach($words as $word)
        {
            if(trim($word) == "" || is_numeric($word))
                continue;

            if(!in_array($word,$excludes))
            {
                $cloud[$word] = substr_count($text, $word);
            }
        }

        $sort .= 'sort';

        $sort($cloud);

        return $cloud;
    }

    public static function getUniqid()
    {
        return uniqid(str_replace('.','',microtime(true)));
    }

    public static function isValidImageSize($size)
    {
        return MAX_IMAGE_UPLOAD_SIZE* 1024 * 1024 >= $size;
    }

    public static function isValidFileSize($size)
    {
        return MAX_FILE_UPLOAD_SIZE* 1024 * 1024 >= $size;
    }

    public static function convertUltraPlannerDateToTimestamp($date){
        date_default_timezone_set('UTC');
        $date_elements = explode('-',$date);
        $d = isset($date_elements[1])?$date_elements[1]:null;
        $m = isset($date_elements[0])?$date_elements[0]:null;
        $y = isset($date_elements[2])?$date_elements[2]:null;
        return strtotime($d.'-'.$m.'-'.$y);
    }

    public static function getSmallDate($timestamp=null,$format=null)
    {
        date_default_timezone_set('UTC');

        if(is_null($timestamp))
            $timestamp = time();

        if(!is_null($format))
            return date($format, $timestamp);
        else {
            $date = date("d-m-Y", $timestamp);
            $date = str_replace('-','/',$date);
            return $date;
        }
    }

    public static function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    public static function hourFormat($minutes){
        $h = round($minutes/60);
        $m = $minutes % 60;
        $result ='';
        if($h != 0)
            $result = $h.'h ';

        if($m != 0)
            $result .= $m.'m';

         $result = trim($result);
         return empty($result)?'0h':$result;
    }

    public static function getLongDate($timestamp=null,$withTime=false)
    {
        date_default_timezone_set('UTC');

        if(is_null($timestamp))
            $timestamp = time();

        if($withTime == false)
            return date('l d M Y', $timestamp);
        else
            return date('l d M Y h:i A', $timestamp);
    }

    public static function getDueDate($default_time_to_resolve)
    {
        $resolve_time = time();
        switch ($default_time_to_resolve){
            case '2 weeks':
                $resolve_time += 60*60*24*14;
                break;
            case '1 month':
                $resolve_time += 60*60*24*30;
                break;
            case '3 month':
                $resolve_time += 60*60*24*90;
                break;
            case '7 days':
            default:
                $resolve_time += 60*60*24*7;
        }
        return date('d/m/Y',$resolve_time);
    }

    public static function ordering_data($data,$col,$dir='asc'){

        if(!is_array($data))
            return $data;

        if($dir == 'asc') {
            usort($data, function ($a, $b,$col) {
                return strcmp($a[$col], $b[$col]);
            });
        }
        else{
            usort($data, function ($a, $b,$col) {
                if($a[$col]==$b[$col]) return 0;
                    return $a[$col] < $b[$col]?1:-1;
            });
        }
    }
}
?>
