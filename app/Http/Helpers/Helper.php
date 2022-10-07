<?php

if( ! function_exists('adminOrSameUser')) {
    function adminOrSameUser() {
//        return class_basename(auth()->user()) == 'User' && auth()->user() == request()->user()->id;
    }
}
