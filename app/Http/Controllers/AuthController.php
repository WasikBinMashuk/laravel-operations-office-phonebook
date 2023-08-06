<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::logout(); // This will log the user out and destroy their session.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success','Admins cannot login'); // Redirect to the desired page after logout (replace '/' with your desired URL).
    }
}
