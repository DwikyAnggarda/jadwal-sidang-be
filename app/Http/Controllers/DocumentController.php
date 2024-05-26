<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\MhsDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('mhsDocuments')->get();
        return response()->json($documents);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'jenis_document_id' => 'required|exists:jenis_documents,id',
            'semester' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'judul_aplikasi' => 'required|string',
            'status_usulan' => 'required|string',
            'file' => 'nullable|file'
        ]);

        $document = Document::create($validatedData);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('mhs_documents');
            MhsDocument::create([
                'document_id' => $document->id,
                'file_code' => $filePath
            ]);
        }

        return response()->json($document, 201);
    }

    public function show($id)
    {
        $document = Document::with('mhsDocuments')->findOrFail($id);
        return response()->json($document);
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $validatedData = $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'jenis_document_id' => 'required|exists:jenis_documents,id',
            'semester' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'judul_aplikasi' => 'required|string',
            'status_usulan' => 'required|string',
            'file' => 'nullable|file'
        ]);

        $document->update($validatedData);

        if ($request->hasFile('file')) {
            /* $oldFiles = MhsDocument::where('document_id', $id)->get();
            foreach ($oldFiles as $oldFile) {
                Storage::delete($oldFile->file_code);
                $oldFile->delete();
            } */

            $filePath = $request->file('file')->store('mhs_documents');
            MhsDocument::create([
                'document_id' => $id,
                'file_code' => $filePath
            ]);
        }

        return response()->json($document);
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        $mhsDocuments = MhsDocument::where('document_id', $id)->get();
        foreach ($mhsDocuments as $mhsDocument) {
            Storage::delete($mhsDocument->file_code);
            $mhsDocument->delete();
        }

        $document->delete();

        return response()->json(null, 204);
    }
}