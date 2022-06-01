<?php
namespace Core;

class Utils {
	private static $instance;

    public static function WalletAddressFormat($address) {
        if(strlen($address) > 0) {
            $first = substr($address, 0,6);
            $last = substr($address, -4);
            return $first . '...' . $last;
        }
        else
            return '';
    }

   public static function time_elapsed_string($datetime, $full = false,$date = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        if($date == true ){

            $string = array(
                'y' => 'Y',
                'm' => 'M',
                'w' => 'W',
                'd' => 'd',
                'h' => 'h',
                'i' => 'm',
                's' => 's',
            );

            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . '' . $v ;
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);

            if($diff->days > 0)
                return $ago->format('j F Y');
            else
                 return $string ? implode(' ', $string) . ' ago' : 'just now';
        }
        else {

            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );

            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v ;
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(' ', $string) . ' ago' : 'just now';
        }
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

    public static function expireDateCounts($date) {
        $date_dif = date_diff(new \DateTime('now'),new \DateTime($date));
        if($date_dif->y > 0)
            return ($date_dif->y == 1)?$date_dif->y.' year left':$date_dif->y.' years left';
        elseif ($date_dif->m > 1)
            return ($date_dif->y == 1)?$date_dif->m.' month left':$date_dif->m.' months left';
        elseif ($date_dif->d > 1)
            return ($date_dif->d == 1)?$date_dif->d.' day left':$date_dif->d.' days left';
        elseif ($date_dif->h > 1)
            return ($date_dif->h == 1)?$date_dif->h.' hour left':$date_dif->y.' hour left';
        elseif ($date_dif->i > 1)
            return ($date_dif->i == 1)?$date_dif->i.' ninute '.$date_dif->s.' seconds left':$date_dif->i.' ninutes '.$date_dif->s.' seconds left';
        else
            return $date_dif->s.' seconds left';
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
