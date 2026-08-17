<?php

namespace App\Http\Controllers;

use App\Models\Storefront;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StorefrontController extends Controller
{
    public function showArtist(Request $request)
    {
        $storefront = $request->user()->storefront;
        $this->authorize('view', $storefront);

        return inertia('StorefrontArtist', [
            'storefront' => $storefront->load(['components.commission.images', 'components.commission.questions']),
            'orders' => $request->user()->ordersAsArtist()->with('commission', 'client')->get(),
        ]);
    }
    public function showClient(Request $request, Storefront $storefront)
    {
        return inertia('StorefrontClient', [
            'storefront' => $storefront->load(['components.commission.images', 'components.commission.questions']),
            'orders' => $storefront->user->ordersAsArtist()->with('commission', 'client')->get(),
        ]);
    }

    public function update(Request $request, Storefront $storefront)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'slug' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('storefronts')->ignore($storefront->id) // Ignore le slug actuel pour l'unicité
            ],
            'visible' => 'sometimes|boolean',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
        ]);

        // 2. Gestion de l'upload de la nouvelle image
        if ($request->hasFile('background_image')) {
            // Suppression de l'ancienne image si elle existe
            if ($storefront->background_image) {
                $oldPath = str_replace('/storage/', '', $storefront->background_image);
                Storage::disk('public')->delete($oldPath);
            }

            // Sauvegarde de la nouvelle image
            $path = $request->file('background_image')->store('storefront-backgrounds', 'public');
            $validated['background_image'] = Storage::url($path);
        }
        // 3. Gestion de la suppression de l'image (si le front envoie 'background_image' => null)
        elseif (array_key_exists('background_image', $validated) && $validated['background_image'] === null) {
            if ($storefront->background_image) {
                $oldPath = str_replace('/storage/', '', $storefront->background_image);
                Storage::disk('public')->delete($oldPath);
            }
        }

        // 4. Mise à jour de la base de données
        $storefront->update($validated);

        return redirect()->back();
    }
}
