<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class VerifyController extends Controller
{
    public function index($lang,$token){
        
    $user = User::where('email_verification_token', $token)->first();
    if (!$user) {
        return redirect()->route('login', ['lang' => app()->getLocale()])
            ->with('error', __('valdition.invalid_verification_link'));
    } 
    
    $user->email_verified_at = now();
    $user->email_verification_token = null; 
    $user->save();
    
    return redirect()->route('login', ['lang' => app()->getLocale()])
        ->with('success', __('valdition.account_verified'));
    
    }
}
