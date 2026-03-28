<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployerStoreRequest;
use App\Http\Requests\EmployerUpdateRequest;
use App\Models\Employer;
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

    public function edit(Request $request, Employer $employer): Response
    {
        return view('employer.edit', compact('employer'));
    }

    public function update(EmployerUpdateRequest $request, Employer $employer): Response
    {
        $employer->update($request->validated());

        $request->session()->flash('employer.id', $employer->id);

        return redirect()->route('employer.index');
    }

    public function destroy(Request $request, Employer $employer): Response
    {
        $employer->delete();

        return redirect()->route('employer.index');
    }
}
