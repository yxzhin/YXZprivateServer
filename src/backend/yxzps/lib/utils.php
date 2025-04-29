<?php

class Utils{

    public static function arrayGet(array $array, $key){

        return array_key_exists($key, $array) ? $array[$key] : null;

    }

    public static function getReadableTimeDifferenceFromUnixTimestamp(int $time): string {
        
        $now = new DateTime();

        $old = new DateTime();
        $old->setTimestamp($time);

        $delta = $now->diff($old);

        $years = $delta->y > 0 ? $delta->y." years, " : "";
        $months = $delta->m > 0 ? $delta->m." months, " : "";
        $days = $delta->d > 0 ? $delta->d." days, " : "";
        $hours = $delta->h > 0 ? $delta->h." hours, " : "";
        $minutes = $delta->i > 0 ? $delta->i." minutes, " : "";
        $seconds = $delta->s." seconds ";

        $diff = $years.$months.$days.$hours.$minutes.$seconds."ago";

        return $diff;

    }

    public static function getErrorMessageFromErrorCode(string $code): ?string {

        $constants = get_defined_constants();
        $constant_name = array_search($code, $constants, true);

        if(!$constant_name)
        return null;

        $error_message = constant("MESSAGE_".$constant_name);

        return $error_message;

    }

    public static function debugPrintPost(bool $write_to_temp=false){

        $post = array();
        $path = __DIR__."/../temp";
        if(!file_exists($path)) mkdir($path);

        foreach($_POST as $k=>$v){

            $print = "key: ".$k."; value: ".$v."\n";
            print_r($print);
            if($write_to_temp) array_push($post, $print);

        }

        if($write_to_temp) file_put_contents($path."/debug_print_post.txt", join("", $post));

    }

}

?>