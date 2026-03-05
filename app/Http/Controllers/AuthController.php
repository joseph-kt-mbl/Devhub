<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Developer;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class  AuthController extends Controller{
    public function index(){
        
    }
    public function create_user(){
        return view("auth.register");
    }

    public function register_user(Request $request)
    {
        // Validate common fields
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:developer,client'],

            // Developer fields
            'title' => ['nullable', 'required_if:role,developer', 'string', 'max:255'],
            'skills' => ['nullable', 'required_if:role,developer', 'string'],
            'hourly_rate' => ['nullable', 'required_if:role,developer', 'numeric', 'min:0'],
            'bio' => ['nullable', 'required_if:role,developer', 'string', 'min:8','max:512'],
            'experience_years' => ['nullable', 'required_if:role,developer', 'numeric', 'min:1'],
            


            // Client fields
            'company_name' => ['nullable', 'required_if:role,client', 'string', 'max:255'],
            'website' => ['nullable', 'url'],
        ]);

        // Create the User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        // Create related profile
        if ($validated['role'] === 'developer') {
           $developer = Developer::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'hourly_rate' => $validated['hourly_rate'],
            'bio' => $validated['bio'], 
            'experience_years' => $validated['experience_years'],
        ]);

            // Convert comma string to array
            $skillsArray = array_map('trim', explode(',', $validated['skills']));

            foreach ($skillsArray as $skillName) {
                $skill = \App\Models\Skill::firstOrCreate([
                    'name' => $skillName
                ]);

                $developer->skills()->attach($skill->id);
            }
        }
         elseif ($validated['role'] === 'client') {
            Client::create([
                'user_id' => $user->id,
                'company_name' => $validated['company_name'],
                'website' => $validated['website'] ?? null,
            ]);
        }

        // Log the user in (optional)
        auth()->login($user);

        // Redirect to dashboard or home
        return redirect()->route('dashboard');
    }

}