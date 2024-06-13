<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function view($id)
    {
        $file = File::findOrFail($id);
        return view('view', compact('file'));
    }


    public function show()
    {
        $files = File::where('user_id', session('LoggedUser'))->get();
        return view('files', compact('files'));
    }

    public function upload(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls|max:2048',
                "name" => 'required|min: 3'
            ]);

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');

            File::create([
                'user_id' => session('LoggedUser'),
                'filename' => $request->name,
                'filepath' => $path,
            ]);

            return redirect()->route('files')->with('success', 'File uploaded successfully.');
        }
        return view('upload');
    }

    public function delete($id)
    {
        $file = File::findOrFail($id);
        Storage::delete($file->filepath);
        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully.');
    }
}
