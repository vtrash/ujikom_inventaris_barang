<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer', 'min:1', 'max:50']
        ]);

        $perPage = $validated['per_page'] ?? 10;

        $data = Siswa::latest()->paginate($perPage);

        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:255'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'nama_siswa' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:255']
        ]);

        $data = Siswa::create($validated);

        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        return response()->json(['data' => $siswa], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => ['sometimes', 'string', 'max:255'],
            'kelas_id' => ['sometimes', 'exists:kelas,id'],
            'nama_siswa' => ['sometimes', 'string', 'max:255'],
            'no_hp' => ['sometimes', 'string', 'max:255']
        ]);

        $siswa->update($validated);

        return response()->json(['data' => $siswa], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return response()->json('', 204);
    }
}
