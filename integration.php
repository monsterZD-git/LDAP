<?php

/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/

/**
 * Get a list of users from Active Directory.
 */
 
$ldap_password = '';
$ldap_username = '';

$ldap_connection = ldap_connect('8.8.8.8');
if (FALSE === $ldap_connection){
  // Ой-ой, что-то не так ...
}
// Мы должны установить этот параметр для используемой версии Active Directory.
ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Невозможно установить версию протокола LDAP');
ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0); 

if (TRUE === ldap_bind($ldap_connection, $ldap_username, $ldap_password)){
  // запрос получения групп
  $ldap_base_dn = 'OU=,OU=Groups,OU=,OU=,DC=,DC=,DC=RU';
  $search_filter = '(&(objectCategory=group)(description=*))';
  $attributes = array();
  $attributes[] = 'givenname';
  $attributes[] = 'memberOf';
  $attributes[] = 'description';
  $attributes[] = 'samaccountname';
  $attributes[] = 'sn';
  $result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter, $attributes);
  if (FALSE !== $result){
    $entries = ldap_get_entries($ldap_connection, $result);
    var_dump($entries);
  }
  ldap_unbind($ldap_connection); 
}
