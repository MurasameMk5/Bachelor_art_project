<?php

namespace App\Http\Controllers;

use App\Models\StorefrontComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

        $storefront = $request->user()->storefront;
        Gate::authorize('create', $storefront);

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


        $component = $storefront->components()->create($validated);
        return redirect()->back();
    }

    public function update(Request $request, StorefrontComponent $component)
    {
        $component->load('storefront');
        Gate::authorize('update', $component);

        $validated = $request->validate([
            'content' => 'sometimes|array',
            'position' => 'sometimes|integer|min:0',
            'is_visible' => 'sometimes|boolean',
        ]);

        if (isset($validated['content']['images']) && is_array($validated['content']['images'])) {
            $images = $validated['content']['images'];
            $fileIndex = 0;
            $uploadedFiles = $request->file('files', [] );

            foreach ($images as &$image) {
                if (empty($image['ref']) && isset($uploadedFiles[$fileIndex])) {
                    $path = $uploadedFiles[$fileIndex]->store('storefront-images', 'public');
                    $image['ref'] = Storage::url($path);
                    $fileIndex++;
                }
            }
            unset($image);
            $validated['content']['images'] = $images;
        }

        $component->update($validated);

        return redirect()->back();
    }

    public function delete(Request $request, StorefrontComponent $component)
    {
        $component->load('storefront');
        Gate::authorize('delete', $component);

        if (isset($component->content['images']) && is_array($component->content['images'])) {
            foreach ($component->content['images'] as $image) {
                if (!empty($image['ref'])) {
                    // On retire le "/storage/" pour avoir le vrai chemin du fichier
                    $path = str_replace('/storage/', '', $image['ref']);
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $component->delete();

        return redirect()->back();
    }
}
