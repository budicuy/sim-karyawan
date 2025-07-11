<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class KaryawanController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Karyawan::select(['id', 'user_id', 'tujuan', 'foto_tiket', 'tanggal', 'nopol', 'created_at'])
            ->with(['user:id,name,email']) // Hanya load kolom yang diperlukan dari user
            ->latest('created_at');

        // Optimasi query berdasarkan role dengan single query
        if (Gate::allows('admin') || Auth::user()->role === 'manager') {
            $karyawans = $query->paginate(10);
        } else {
            $karyawans = $query->where('user_id', Auth::id())->paginate(10);
        }

        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKaryawanRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        // Handle file upload
        if ($request->hasFile('foto_tiket')) {
            $data['foto_tiket'] = $request->file('foto_tiket')->store('tiket_photos', 'public');
        }

        Karyawan::create($data);

        return redirect()->route('karyawan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        $this->authorize('view', $karyawan);
        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $this->authorize('update', $karyawan);
        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKaryawanRequest $request, Karyawan $karyawan)
    {
        $this->authorize('update', $karyawan);
        $data = $request->validated();
        // Handle file upload
        if ($request->hasFile('foto_tiket')) {
            $data['foto_tiket'] = $request->file('foto_tiket')->store('tiket_photos', 'public');
        }

        $karyawan->update($data);

        return redirect()->route('karyawan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $this->authorize('delete', $karyawan);
        $karyawan->delete();
        return redirect()->route('karyawan.index');
    }
}
