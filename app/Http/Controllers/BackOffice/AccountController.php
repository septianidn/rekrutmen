<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::withCount('pembayarans')
            ->orderBy('nama_bank')
            ->paginate(20);

        return view('backoffice.account.index', compact('accounts'));
    }

    public function create()
    {
        return view('backoffice.account.form', [
            'account' => new Account(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        Account::create($data);

        return redirect()->route('backoffice.account.index')
            ->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function edit(Account $account)
    {
        return view('backoffice.account.form', [
            'account' => $account,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Account $account)
    {
        $data = $this->validatedData($request, $account->id);
        $account->update($data);

        return redirect()->route('backoffice.account.index')
            ->with('success', 'Rekening bank berhasil diperbarui.');
    }

    public function destroy(Account $account)
    {
        if ($account->pembayarans()->exists()) {
            return redirect()->route('backoffice.account.index')
                ->with('error', 'Rekening ini sudah terpakai pada pembayaran dan tidak dapat dihapus. Nonaktifkan saja.');
        }

        $account->delete();

        return redirect()->route('backoffice.account.index')
            ->with('success', 'Rekening bank dihapus.');
    }

    protected function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $unique = 'unique:account,nomor_rekening' . ($ignoreId ? ',' . $ignoreId : '');

        return $request->validate([
            'nama_bank'      => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50|' . $unique,
            'nama_pemilik'   => 'required|string|max:150',
            'is_active'      => 'sometimes|boolean',
        ]) + [
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
