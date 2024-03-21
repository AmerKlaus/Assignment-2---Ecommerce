<?php
//defined a few routes "url"=>"controller,method"
$this->addRoute('User/register', 'User,register');
$this->addRoute('User/login', 'User,login');
$this->addRoute('User/logout', 'User,logout');
$this->addRoute('User/update', 'User,update');
$this->addRoute('User/delete', 'User,delete');
$this->addRoute('User/securePlace', 'Profile,index');
$this->addRoute('Profile/index', 'Profile,index');
$this->addRoute('Profile/create', 'Profile,create');
$this->addRoute('Profile/modify', 'Profile,modify');
$this->addRoute('Profile/delete', 'Profile,delete');
$this->addRoute('Publications/index', 'Publications,index');
$this->addRoute('Publications/create', 'Publications,create');
$this->addRoute('Publications/store', 'Publications,store');
$this->addRoute('Publications/edit/{id}', 'Publications,edit');
$this->addRoute('Publications/update/{id}', 'Publications,update');
$this->addRoute('Publications/delete/{id}', 'Publications,delete');
$this->addRoute('Publications/content/{id}', 'Publications,content');
$this->addRoute('Publications/addComment/{id}', 'Publications,addComment');
$this->addRoute('Publications/editComment/{id}', 'Publications,editComment');
$this->addRoute('Publications/deleteComment/{id}', 'Publications,deleteComment');