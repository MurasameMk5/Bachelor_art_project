<?php

namespace App\Http\Controllers;

use App\Models\StorefrontComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorefrontComponentController extends Controller
{
    public function insert(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'content' => 'required|array',
            'position' => 'required|integer|min:0',
            'is_visible' => 'required|boolean',
        ]);

        if (isset($validated['content']['images']) && is_array($validated['content']['images'])) {
            $images = $validated['content']['images'];
            $fileIndex = 0;
            $uploadedFiles = $request->file('files', []);

            foreach ($images as &$image) {
                if (empty($image['ref'])) {
                    if (isset($uploadedFiles[$fileIndex])) {
                        $path = $uploadedFiles[$fileIndex]->store('storefront-images', 'public');
                        $image['ref'] = Storage::url($path);
                        $fileIndex++;
                    }
                }
            }
            unset($image);
            $validated['content']['images'] = $images;
        }


        $component = StorefrontComponent::create($validated);
        return response()->json($component, 201);
    }

    public function update(Request $request, StorefrontComponent $component)
    {
        $validated = $request->validate([
            'content' => 'sometimes|array',
            'position' => 'sometimes|integer|min:0',
            'is_visible' => 'sometimes|boolean',
        ]);

        $images = $validated['content']['images'];
        $fileIndex = 0;

        foreach ($images as $i => &$image) {
            if (!isset($image['ref'])) {
                // Cette image n'a pas encore de ref = c'est une nouvelle image à uploader
                $uploadedFile = $request->file('files')[$fileIndex] ?? null;
                if ($uploadedFile) {
                    $path = $uploadedFile->store('storefront-images', 'public');
                    $image['ref'] = '/storage/' . $path;
                    $fileIndex++;
                }
            }
        }

        $component->update([
            'content' => [
                'image_nb' => $validated['content']['image_nb'],
                'images' => $images,
            ],
        ]);
        return redirect()->back();

    }
}
