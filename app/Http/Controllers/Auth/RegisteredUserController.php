<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'username' => ['required', 'string', 'max:50', 'unique:'.User::class],
                'nim' => ['required', 'string', 'size:14'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'nim.size' => 'NIM harus terdiri dari 14 karakter.',
                'nim.required' => 'NIM tidak boleh kosong.',
                'email.unique' => 'Email sudah terdaftar.',
                'username.unique' => 'Username sudah terdaftar.',
                
            ]);
            Log::info('Validasi berhasil');

             // cek apakah nim sudah terdaftar di mahasiswa
            $mhs = Mahasiswa::where('nim', $request->nim)->first();;
            
            // Mahaisswa terdaftar dan memiliki akun
            if($mhs != null && $mhs->user_id != null){
                Log::info("NIM sudah terdaftar");
                return redirect()->back()->withErrors(['nim'=> 'NIM Sudah terdaftar, silahkan login.'])->withInput();
            }
            // Mahasiswa tidak terdaftar atau tidak mengambil tugas akhir
            elseif($mhs == null || $mhs->tugas_akhir == false){
                Log::info("NIM tidak terdaftar di mahasiswa");
                return redirect()->back()->withErrors(['nim' => 'NIM tidak terdaftar mengambil mata kuliah Tugas Akhir.'])->withInput();
            }
       
    
            // Proses data setelah validasi
            $user= DB::transaction(function () use ($request, $mhs) {

                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'mhs',
                    'mhs_nim'=>$mhs->nim,
                ]);

                // // Update existing mahassiwa dengan tambahan user_id sesuai nim terdaftar
                // $mhs->update([
                //     'user_id' => $user->id,
                // ]);
                return $user;
            });
            
            Log::info('Berhasil membuat akun + mahasiswa');
            
            // Auto-login user after berhasil registrasi
            event(new Registered($user));
            Auth::login($user);
            
            // Redirect to dashboard berdasarkan role
            switch ($user->role) {
                case 'adm':
                    return redirect()->route('admin.dashboard')->with('success', 'Anda sudah berhasil mendaftar!');
                case 'mhs':
                    return redirect()->route('mhs.dashboard')->with('success', 'Anda sudah berhasil mendaftar!');
                default:
                    return redirect()->route('login');
            }
            
        } catch (QueryException $e) {
            Log::error($e);
            return redirect()->back()->withInput()->withErrors(['error' => 'Maaf, terjadi kesalahan pada database. Silahkan coba lagi.']);
        }
        catch (ValidationException $e) {
            throw $e;
        }
        catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan. Coba lagi']);
        }
        
    }
}
