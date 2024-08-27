<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPmail;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    // Page Controller
    function LoginPage(){
        return view('pages.auth.login-page');
    }

    //Registration Page
    function RegistrationPage(){
        return view('pages.auth.registration-page');
    }

    //Send otp page
    function SendOtpPage(){
        return view('pages.auth.send-otp-page');
    }

    //Verify Otp
    function VerifyOtpPage(){
        return view('pages.auth.verify-otp-page');
    }
    //reaet password page
    function ResetPasswordPage(){
        return view('pages.auth.reset-pass-page');
    }

    function ProfileUpdate(){
        return view('pages.dashboard.profile-update-page');
    }
   
    
    function UserRegistration(Request $request)
    {
         try{
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
                
            ]);
    
            return response()->json(
                ["status" =>"success",
                "message" =>"User Registration Successfully"],200
            );
            }
         catch(Exception $e){ 
            return response()->json(
                ["status" =>"Fail",
                "message" =>"User Registration Failed"
                ]
                );  
            }
    }


    function UserLogin(Request $request){
        $count = User::where('email','=',$request->input('email'))
                ->where('password','=',$request->input('password'))
                ->select('id')->first();


        if($count !== null){
            $token = JWTToken::CreateToken($request->input('email'),$count->id);
            return response()->json([
                'status'=>'Success',
                'message'=>'Login Successful',
            ],200)->cookie('token',$token,time()+ 60*60);
        }
        else{
            return response()->json([
                'status'=>'Failed',
                'message'=>'Unauthorized'
            ]);
        }
    }


    function SendOPTCode(Request $request){
        $email = $request->input('email');
        $otp=rand(1000,9999);
        $count = User::where('email','=',$email)->count();

        if($count ==1){
            Mail::to($email)->send(new OTPmail($otp));
            User::where('email','=',$email)->update(['otp'=>$otp]);
            return response()->json(
                [
                    'status' => 'Success',
                    'message' =>'OPP Send',
                    'otp'=>$otp
                ],200);
        }
        else{
            return response()->json(
                [
                    'status' => 'Failed',
                    'message' =>'Email not found'
                ]

            );

            
        }
    }

    function VerifyOTP(Request $request){
        $otp = $request->input('otp');
        $email = $request->input('email');

        $count = User::where('email','=',$email)->where('otp','=',$otp)->count();

        if($count == 1){
            User::where('email','=',$email)->update(['otp'=>'0']);
            
            
            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status'=>'Success',
                'message'=>'OTP Verification Successful',
                
            ])->cookie('token',$token,time()+60*60);
        }
        else{
            return response()->json(
                [
                    'status' => 'Failed',
                    'message' =>'Email not found'
                ]);
        }
    }


    function ResetPass(Request $request){

        try{
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);
            return response()->json(
                [
                    'status' => 'Success',
                    'message' =>'Reset Password Successfull'
                ],200);
        }
        catch(Exception $e){
            return response()->json(
                [
                    'status' => 'Failed',
                    'message' =>'Something Went Wrong'
                ]);
        }

    }


    function UserLogout(){
        return redirect('/userLogin')->cookie('token','',-1);
    }

    function userProfile(Request $request){
        $email = $request->header('email');
        $user = User::where('email','=',$email)->first();
        return response()->json(
            [
                'status'=>'success',
                'message'=>'Request succesfull',
                'data'=>$user
            ],200
        );

    }

    function userProfileUpdate(Request $request){
        try{
            $email = $request->header('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $mobile = $request->input('mobile');
        $password = $request->input('password');

        User::where('email','=',$email)->update([
            'firstName'=>$firstName,
            'lastName'=>$lastName,
            'lastName'=>$lastName,
            'password'=>$password,
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'Update Successful'
        ]);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>'Failed',
                'message'=>'Update not Successful'
            ]);
        }
    }



}