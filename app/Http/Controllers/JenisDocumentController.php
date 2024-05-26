<?php

namespace App\Http\Controllers;

use App\Models\JenisDocument;
use Illuminate\Http\Request;

class JenisDocumentController extends Controller
{
    public function index()
    {
        return response()->json(JenisDocument::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        try {
            $jenisDocument = JenisDocument::create($validated);
            return response()->json(['message' => 'Jenis document berhasil dibuat'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Jenis document gagal dibuat'], 500);
        }
    }

    public function show($id)
    {
        try {
            $jenisDocument = JenisDocument::findOrFail($id);
            return response()->json($jenisDocument, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Jenis document tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_jenis' => 'sometimes|required|string|max:255',
        ]);

        try {
            $jenisDocument = JenisDocument::findOrFail($id);
            $jenisDocument->update($validated);
            return response()->json(['message' => 'Jenis document berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Jenis document gagal diperbarui'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $jenisDocument = JenisDocument::findOrFail($id);
            $jenisDocument->delete();
            return response()->json(['message' => 'Jenis document berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Jenis document gagal dihapus'], 500);
            // 'error' => $e->getMessage()
        }
    }
}