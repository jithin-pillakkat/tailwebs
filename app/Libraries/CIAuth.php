<?php
namespace App\Libraries;
class CIAuth{

    public static function checkPassword($password, $hashPassword){
        if(password_verify($password, $hashPassword)){
            return true;
        }else{
            return false;
        }
    }

    public static function setUserData($userData){
        session()->set('isLogged', true);
        session()->set('userData', $userData);
    }

    public static function isLogged(){
        if( session()->has('isLogged') ){
            return session()->get('isLogged');
        }else{
            return false;
        }
    }

    public static function userId(){
        if( session()->has('userData') ){
            return session()->get('userData')->id;
        }
    }

    public static function logOut(){
        session()->remove('isLogged');
        session()->remove('userData');
        return true;
    }

}