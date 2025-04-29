<?php

class Utils{

    public static function arrayGet(array $array, $key){

        return array_key_exists($key, $array) ? $array[$key] : null;

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