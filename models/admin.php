<?php
class Admin {
    public $admin_id;
    public $username;
    public $password; // hashé

    public function __construct($admin_id, $username, $password) {
        $this->admin_id = $admin_id;
        $this->username = $username;
        $this->password = $password;
    }
}
?>
