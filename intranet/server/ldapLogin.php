<?php require __DIR__.'/functions.php' ?>
<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
 
    $dbh = connect_to_db();
	$staff = fetchStaff($dbh,$request->login);
    if($staff){
        $ldap_dn = "uid=".$request->login.",ou=People,dc=stuba,dc=sk";
        $ldap_password = $request->password;

        $ldap_con = ldap_connect("ldap.stuba.sk");

        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

        if(ldap_bind($ldap_con, $ldap_dn, $ldap_password)) {
            $roles = fetchStaffRoles($dbh, $staff['id']);
            session_start();
            $_SESSION['username'] = $request->login;
            $_SESSION['roles'] = $roles;
            $data['loginState'] = "loginOK";
            $data['roles'] = $roles;
            echo json_encode($data); 
        } else {
            echo "wrongLogin";  
        }
    }
?>