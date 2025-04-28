<?php

class DBManager{

    public static function connect(string $db_host, int $db_port, string $db_name,
        string $db_user, string $db_pass): ?PDO {

        if(empty($db_host)
        || empty($db_port)
        || empty($db_name)
        || empty($db_user)
        || empty($db_pass))
        die(MESSAGE_FORGOT_TO_EDIT_CONNECTION);

        try{
    
            $conn = new PDO("mysql:host=".$db_host.";port=".$db_port.";dbname=".$db_name, $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;

        } catch(PDOException $e){

            die("Connection failed: ".$e->getMessage());

        }

    }

    public static function baseSelect(array $vars, string $table, string $var2, $value){

        $vars_string = join(",", $vars);

        $query = CONN->prepare("SELECT {$vars_string} FROM {$table} WHERE {$var2} = :{$var2}");
        $query->execute([":{$var2}"=>$value]);

        if(count($vars) > 1
        || $vars[0] == "*")
        return $query->fetch();

        return $query->fetchColumn();

    }

    public static function baseInsert(array $vars, string $table){

        //городить очередной трёхколёсный самокат из велосипедов и костылей

        $vars_string = join(",", array_keys($vars));
        $vars_map = array_map(function($var){return ":".$var;}, array_keys($vars));
        $vars_string2 = join(",", $vars_map);

        $query = CONN->prepare("INSERT INTO {$table} ({$vars_string}) VALUES ({$vars_string2})");
        $query->execute(array_combine($vars_map, array_values($vars)));

    }

}

?>