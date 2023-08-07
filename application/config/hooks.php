<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'] = array(
    'class' => 'Auth_module',
    'function' => 'check_user_login',
    'filename' => 'Auth_module.php',
    'filepath' => 'hooks',
    'params'  => array()
);