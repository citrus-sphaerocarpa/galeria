<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        return view('settings.index');
    }

    public function showAccount()
    {
        return view('settings.account.show');
    }

    public function deleteAccount()
    {
        $this->authorize('view', auth()->user());
        
        return view('settings.account.delete');
    }

    public function destroyAccount(Request $request)
    {
        $this->authorize('delete', auth()->user());

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', __('Current password does not match.'));
        }
        
        User::findOrFail(auth()->id())->delete();

        return redirect('/');
    }

    public function editAccount()
    {
        $user = auth()->user();

        $this->authorize('view', $user);

        return view('settings.account.edit', compact('user'));
    }

    public function updateAccount()
    {
        $user = auth()->user();
        
        $this->authorize('update', $user);

        if(!is_null($user)) {
            $data = request()->validate([
                'username' => ['required', 'string', 'max:25', Rule::unique('users', 'username')->ignore(auth()->id())],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')->ignore(auth()->id())],
            ]);

            auth()->user()->update($data);

            return back()->with('success', __('Successfully saved the settings.'));
        }
    }

    public function showSecurity()
    {
        return view('settings.security.show');
    }


}

