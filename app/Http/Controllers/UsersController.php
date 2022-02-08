<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
// use DB;
use App\Models\User;
// use Hash;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
 {

    // --------------------- [ ' For login ' ] -------------------

    public function login( request $request ) {

        try {
            $user = DB::table( 'users' )->where( 'email', $request->email )->get();

            if ( count( $user ) == 1 ) {

                foreach ( $user as $value ) {
                }
                if ( !$user || !Hash::check( $request->password, $value->password ) ) {
                    $response = array( 'status' => false, 'message' => 'Password Not valid..!!!' );
                    $seccess = json_encode( $response );
                } else {
                    $response = array( 'status' => true, 'message' => 'Login SuccessFully..!!!' );
                    $seccess = json_encode( $response );
                }
            } else {
                $response = array( 'status' => false, 'message' => 'Email Not Valid..!!!' );
                $seccess = json_encode( $response );
            }
            return $response;
        } catch ( Exception $e ) {
            return false;
        }
        return $response;
    }

    // --------------- [ 'For Regiter' ] ------------------

    public function register( Request $request ) {

        try {
            $data = DB::table( 'users' )->where( 'email', $request->email )->get();
            ;
            if ( count( $data ) == 0 ) {
                $user_password = Hash::make( $request->password );
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = $user_password;

                $data = $user->save();
                if ( $data == 1 ) {
                    $response = array( 'status' => true, 'message' => 'Register Is Success..!!!' );
                    $seccess = json_encode( $response );
                } else {
                    $response = array( 'status' => false, 'message' => 'Register Faild..!!!' );
                    $seccess = json_encode( $response );
                }
            } else {
                $response = array( 'status' => false, 'message' => 'Email Already Exit..!!!' );
                $seccess = json_encode( $response );

            }
        } catch ( Exception $e ) {
            return false;
        }
        return $seccess;

    }

}
