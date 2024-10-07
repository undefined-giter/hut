<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $files = Storage::disk('public')->files('gallery');
        $images = array_map(function ($file) {
            return basename($file);
        }, $files);
    
        return inertia('Gallery/index', ['images' => $images]);
    }
}
