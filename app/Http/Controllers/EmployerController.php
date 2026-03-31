<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployerStoreRequest;
use App\Models\Employer;
use App\Models\IndustriType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmployerController extends Controller
{
    

    public function index()
    {
        $assets = ['vanilla-counter', 'glightbox', 'animation','wow'];
                   
        $user = Auth::user();
       $employer = Employer::where('user_id', $user->id)->join('industri_type','industri_type.id', 'employer.industriType_id')->join('users', 'users.id', 'user_id')->first();
            
        return view('frontoffice.employer.profile.profile', compact('assets','employer'));
       
    }

    public function verifikasi(){
        $assets = ['vanilla-counter', 'glightbox', 'animation','wow'];
        $user = Auth::user();

       $employer = Employer::where('user_id', $user->id)->join('industri_type','industri_type.id', 'employer.industriType_id')->join('users', 'users.id', 'user_id')->first();
        return view('frontoffice.employer.verifikasi', compact('assets', 'user'));
    }

    public function create(Request $request): Response
    {
        return view('employer.create');
    }

    public function store(EmployerStoreRequest $request)
    {
        $request->validated();

        
        $employer = Employer::create([
            'user_id' => $request->id_user,
            'nama_perusahaan' => $request->nama_perusahaan,
            'deskripsi_perusahaan' => $request->deskripsi_perusahaan,
            'industriType_id' => $request->id_industri_type,
            'alamat_perusahaan' => $request->alamat,
            'telp_perusahaan' => $request->telp,
            'website' => $request->website
        ]);

        $request->session()->flash('employer.id', $employer->id);

        return $this->index();
    }

    public function show(Request $request, Employer $employer): Response
    {
        return view('employer.show', compact('employer'));
    }

    public function edit()
    {
        $assets = ['vanilla-counter', 'glightbox', 'animation', 'wow'];
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();
        $industriTypes = IndustriType::all();

        return view('frontoffice.employer.profile.edit', compact('assets', 'employer', 'user', 'industriTypes'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:50',
            'deskripsi_perusahaan' => 'required|string',
            'industriType_id' => 'required|exists:industri_type,id',
            'alamat_perusahaan' => 'nullable|string|max:150',
            'telp_perusahaan' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();

        $employer->update($request->only([
            'nama_perusahaan',
            'deskripsi_perusahaan',
            'industriType_id',
            'alamat_perusahaan',
            'telp_perusahaan',
            'website',
        ]));

        return redirect()->route('employer.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(Request $request, Employer $employer): Response
    {
        $employer->delete();

        return redirect()->route('employer.index');
    }
}
