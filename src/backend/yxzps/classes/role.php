<?php

class Role{

    public int $roleID;
    public string $display_name;
    public int $priority;
    public string $color;
    public int $mod_badge_level;
    public string $perms_commands;
    public string $perms_actions;
    public string $perms_dashboard;

    public function load(int $roleID): string|bool{
        
        $data = DBManager::baseSelect(["*"], "roles", "roleID", $roleID);

        if(empty($data)){

            if($roleID == DEFAULT_ROLE_ID){

                Cron::createDefaultRoleIfNotExists();
                return SUCCESS;

            }

            return ERROR_NOT_FOUND;

        }

        $this->roleID = $data["roleID"];
        $this->display_name = $data["display_name"];
        $this->priority = $data["priority"];
        $this->color = $data["color"];
        $this->mod_badge_level = $data["mod_badge_level"];
        $this->perms_commands = $data["perms_commands"];
        $this->perms_actions = $data["perms_actions"];
        $this->perms_dashboard = $data["perms_dashboard"];

        return SUCCESS;

    }

    public static function create(int $roleID, ?string $display_name=null, int $priority=0,
        string $color="000,000,000", int $mod_badge_level=0, array $perms_commands=
        DEFAULT_PERMS_COMMANDS, array $perms_actions=DEFAULT_PERMS_ACTIONS, array $perms_dashboard=
        DEFAULT_PERMS_DASHBOARD): string|bool {

        if(DBManager::baseSelect(["count(*)"], "roles", "roleID", $roleID))
        return ERROR_ALREADY_TAKEN;

        $attrs = json_encode([
            "roleID"=>$roleID,
            "display_name"=>$display_name,
        ]);

        DBManager::baseInsert([
            "roleID"=>$roleID,
            "display_name"=>$display_name,
            "priority"=>$priority,
            "color"=>$color,
            "mod_badge_level"=>$mod_badge_level,
            "perms_commands"=>json_encode($perms_commands),
            "perms_actions"=>json_encode($perms_actions),
            "perms_dashboard"=>json_encode($perms_dashboard),
        ], "roles");

        Protector::log_(LOG_ROLE_CREATED, $attrs);

        return 1;

    }

}

?>