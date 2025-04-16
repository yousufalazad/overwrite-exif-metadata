<?php

namespace App\Http\Controllers;

use App\Models\ImageOverwrite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Inertia\Inertia;

class ImageOverwriteController extends Controller
{
    public function index()
    {
        $images = ImageOverwrite::latest()->get();
        return Inertia::render('ImageOverwrites/Index', ['imageOverwrites' => $images]);
    }

    public function create()
    {
        return Inertia::render('ImageOverwrites/Create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image'],
        ]);

        $file = $request->file('image');
        $originalName = $file->getClientOriginalName();
        $path = $file->store('images', 'public');
        $fullPath = storage_path('app/public/' . $path);

        // Read EXIF data using exiftool
        $process = new Process(['exiftool', '-json', $fullPath]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $exifData = json_decode($process->getOutput(), true)[0] ?? [];

        $image = ImageOverwrite::create([
            'original_name' => $originalName,
            'stored_path' => $path,
            'exif_data' => $exifData,
        ]);

        return redirect()->route('image-overwrites.index');
    }


    public function show(ImageOverwrite $imageOverwrite)
    {
        return Inertia::render('ImageOverwrites/Show', compact('imageOverwrite'));
    }


    public function edit(ImageOverwrite $imageOverwrite)
    {
        return Inertia::render('ImageOverwrites/Edit', compact('imageOverwrite'));
    }


    public function update(Request $request, ImageOverwrite $imageOverwrite)
    {
        $request->validate([
            'exif_data' => ['required', 'array'],
        ]);

        $fullPath = storage_path('app/public/' . $imageOverwrite->stored_path);
        $metadata = $request->input('exif_data');

        // Prepare exiftool command arguments
        $cmd = ['exiftool', '-overwrite_original'];
        foreach ($metadata as $key => $value) {
            $cmd[] = "-$key=$value";
        }
        $cmd[] = $fullPath;

        $process = new Process($cmd);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Re-read updated EXIF data
        $process = new Process(['exiftool', '-json', $fullPath]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $exifData = json_decode($process->getOutput(), true)[0] ?? [];

        $imageOverwrite->update([
            'exif_data' => $exifData,
        ]);

        return redirect()->route('image-overwrites.show', $imageOverwrite->id);
    }


    public function destroy(ImageOverwrite $imageOverwrite) {}
}
