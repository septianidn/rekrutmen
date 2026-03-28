<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipStoreRequest;
use App\Http\Requests\MembershipUpdateRequest;
use App\Models\Membership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function index(Request $request): Response
    {
        $memberships = Membership::all();

        return view('membership.index', compact('memberships'));
    }

    public function create(Request $request): Response
    {
        return view('membership.create');
    }

    public function store(MembershipStoreRequest $request): Response
    {
        $membership = Membership::create($request->validated());

        $request->session()->flash('membership.id', $membership->id);

        return redirect()->route('membership.index');
    }

    public function show(Request $request, Membership $membership): Response
    {
        return view('membership.show', compact('membership'));
    }

    public function edit(Request $request, Membership $membership): Response
    {
        return view('membership.edit', compact('membership'));
    }

    public function update(MembershipUpdateRequest $request, Membership $membership): Response
    {
        $membership->update($request->validated());

        $request->session()->flash('membership.id', $membership->id);

        return redirect()->route('membership.index');
    }

    public function destroy(Request $request, Membership $membership): Response
    {
        $membership->delete();

        return redirect()->route('membership.index');
    }
}
