<?php
namespace App\sendemail;
//载入ucpass类
require_once('lib/Ucpaas.class.php');

//初始化必填
//填写在开发者控制台首页上的Account Sid
$options['accountsid']='a7d6a71ad621a9179cc97c9f8ecd44d1';
//填写在开发者控制台首页上的Auth Token
$options['token']='b8b9bcc0c34400765300a3e7cbbd2d71';

//初始化 $options必填
$ucpass = new Ucpaas($options);