<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class fileUpload extends Controller
{
    //
    public function upload(Request $request)
    {
        // Validate both files
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:2048', // Validate PDF file (max size: 2MB)
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048', // Validate image file (max size: 2MB)
        ]);

        $uploadedFiles = []; // To store file paths

        // Handle PDF upload
        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $pdfName = time() . '_pdf_' . $pdf->getClientOriginalName(); // Generate unique file name
            $pdfPath = $pdf->storeAs('uploads/pdfs', $pdfName, 'public'); // Store file in 'uploads/pdfs'
            $uploadedFiles['pdf'] = asset('storage/' . $pdfPath); // Generate URL to the stored file
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_image_' . $image->getClientOriginalName(); // Generate unique file name
            $imagePath = $image->storeAs('uploads/images', $imageName, 'public'); // Store file in 'uploads/images'
            $uploadedFiles['image'] = asset('storage/' . $imagePath); // Generate URL to the stored file
        }

        // Return response with uploaded file paths
        return response()->json([
            'message' => 'Files uploaded successfully',
            'files' => $uploadedFiles,
        ]);
    }
}

