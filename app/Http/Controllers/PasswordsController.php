<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {   
        $this->authorize('view', auth()->user());
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request)
    {
        $this->authorize('update', auth()->user());

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            'new_password_confirmation' => ['required'],
        ]);

        $authenticated_user = auth()->user();

        if (!Hash::check($request->current_password, $authenticated_user->password)) {
            return back()->with('error', __('Current password does not match.'));
        }

        $authenticated_user->password = Hash::make($request->new_password);
        $authenticated_user->save();

        return back()->with('success', __('Password successfully changed.'));
    }
}
