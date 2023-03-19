<?php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\App;

    if(!function_exists('user_email')){
        function user_email(){
            $user=Auth::user();
            return $user->email;
        }
    }

    if(!function_exists('test_function')){
        function test_function(){
            return "test";
        }
    }

    if(!function_exists('get_prefix')){
        function get_prefix(){
            if (App::environment('local')) {
                // The environment is local
                return "aa_";
            }else if  (App::environment('staging')) {
                return "aa001_";    
            }
        }    
    }