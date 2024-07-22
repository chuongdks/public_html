<?php
$CFG = new stdClass();

# Replace the following URL with your site's URL...
$CFG->base_url = 'https://pham75.myweb.cs.uwindsor.ca/';

# Site-wide password salt...
$CFG->site_wide_password_salt = 'dhgsa77w';

# Set a "global"  session timeout...
$CFG->session_timeout = 60*10; // in seconds

# Database information...

// $CFG->dbtype = 'mysql';
// $CFG->dbhost = 'localhost';
// $CFG->dbname = 'pham75_comp3340-project-shopping-carts';

$CFG->db_dsn = 'mysql:host=localhost;dbname=pham75_comp3340-project-shopping-carts';

$CFG->db_user = 'pham75_comp3340-project-shopping-carts';
$CFG->db_pass = 'Truong!2345';

# Special database "admin" security settings...
$CFG->db_admin_permit_create_drop = FALSE;
$CFG->db_admin_only_allow_ip = '172.22.144.22'; // 

# e.g., Special email support address...
$CFG->emailaddr_support = 'pham75@uwindsor.ca';

?>
