<?php

class Utils{

    public static function array_get(array $array, $key){

        return array_key_exists($key, $array) ? $array[$key] : null;

    }

    public static function debug_print_post(bool $write_to_temp=false){

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