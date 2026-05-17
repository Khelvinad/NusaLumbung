<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PetaniProfile;
use App\Models\PembeliProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'name' => strip_tags($request->name ?? ''),
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:15'],
            'role' => ['required', 'string', 'in:petani,pembeli'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'petani') {
            PetaniProfile::create([
                'user_id' => $user->id,
                'no_telp' => $request->phone,
                'farm_name' => $request->name.' Farm',
                'location' => 'Belum ditentukan',
            ]);
        } else {
            PembeliProfile::create([
                'user_id' => $user->id,
                'no_telp' => $request->phone,
            ]);
        }


        event(new Registered($user));

        Auth::login($user);

        $redirectRoute = $request->role === 'petani'
            ? route('petani.dashboard', absolute: false)
            : route('home', absolute: false);

        return redirect($redirectRoute);
    }
}
