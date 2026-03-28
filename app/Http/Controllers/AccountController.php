<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): Response
    {
        $accounts = Account::all();

        return view('account.index', compact('accounts'));
    }

    public function create(Request $request): Response
    {
        return view('account.create');
    }

    public function store(AccountStoreRequest $request): Response
    {
        $account = Account::create($request->validated());

        $request->session()->flash('account.id', $account->id);

        return redirect()->route('account.index');
    }

    public function show(Request $request, Account $account): Response
    {
        return view('account.show', compact('account'));
    }

    public function edit(Request $request, Account $account): Response
    {
        return view('account.edit', compact('account'));
    }

    public function update(AccountUpdateRequest $request, Account $account): Response
    {
        $account->update($request->validated());

        $request->session()->flash('account.id', $account->id);

        return redirect()->route('account.index');
    }

    public function destroy(Request $request, Account $account): Response
    {
        $account->delete();

        return redirect()->route('account.index');
    }
}
