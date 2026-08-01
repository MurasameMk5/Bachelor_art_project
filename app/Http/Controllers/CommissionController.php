<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\CommissionImage;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CommissionController extends Controller
{
    public function show(Request $request, string $storefrontSlug, Commission $commission)
    {
        return Inertia::render('OrderForm', [
            'commission' => $commission->load(['artist', 'images', 'questions']),
            'user' => $request->user(),
        ]);
    }

    public function store(Request $request)
    {
        $storefront = $request->user()->storefront;
        Gate::authorize('create', $storefront);

        $validated = $this->validateCommission($request);

        $commission = DB::transaction(function () use ($validated, $storefront, $request) {
            // 1. Crée d'abord le composant storefront
            $component = $storefront->components()->create([
                'type' => 'commission',
                'content' => [], // pas besoin de dupliquer les données ici, la commission a ses propres champs
                'position' => ($storefront->components()->max('position') ?? -1) + 1,
                'is_visible' => true,
            ]);

            // 2. Crée la commission, liée à ce composant
            $commission = $request->user()->commissions()->create([
                'component_id' => $component->id,
                'title' => $validated['title'],
                'base_price' => $validated['base_price'],
                'currency' => $validated['currency'],
                'estimated_days' => $validated['estimated_days'],
                'max_free_revisions' => $validated['max_free_revisions'],
                'slots_available' => $validated['slots_available'],
                'description' => $validated['description'],
                'status' => 'open',
            ]);

            // 3. Images et questions
            $this->syncImages($commission, $validated['images'] ?? [], $request);
            $this->syncQuestions($commission, $validated['questions'] ?? []);

            return $commission;
        });

        return redirect()->back();
    }

    public function update(Request $request, Commission $commission)
    {
        Gate::authorize('update', $commission);

        $validated = $this->validateCommission($request);

        DB::transaction(function () use ($validated, $commission, $request) {
            $commission->update([
                'title' => $validated['title'],
                'base_price' => $validated['base_price'],
                'currency' => $validated['currency'],
                'estimated_days' => $validated['estimated_days'],
                'max_free_revisions' => $validated['max_free_revisions'],
                'slots_available' => $validated['slots_available'],
                'description' => $validated['description'],
            ]);

            $this->syncImages($commission, $validated['images'] ?? [], $request);
            $this->syncQuestions($commission, $validated['questions'] ?? []);
        });

        return redirect()->back();
    }

    private function validateCommission(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'currency' => 'required|string|in:usd,eur,chf',
            'estimated_days' => 'required|integer|min:1',
            'max_free_revisions' => 'required|integer|min:0',
            'slots_available' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'images' => 'sometimes|array',
            'images.*.id' => 'nullable|integer',
            'images.*.ref' => 'nullable|string',
            'images.*.label' => 'nullable|string',
            'questions' => 'sometimes|array',
            'questions.*.label' => 'required|string',
            'questions.*.field_type' => 'required|string|in:text,number,select,checkbox,file',
            'questions.*.options' => 'sometimes|array',
        ]);
    }

    private function syncImages(Commission $commission, array $images, Request $request): void
    {
        // 1. On sécurise la récupération des fichiers (pour s'assurer d'avoir un tableau propre)
        $uploadedFiles = $request->file('files', []);
        if (!is_array($uploadedFiles)) {
            $uploadedFiles = $uploadedFiles ? [$uploadedFiles] : [];
        }
        $uploadedFiles = array_values(array_filter($uploadedFiles));

        $fileIndex = 0;
        $keptImageIds = [];

        foreach ($images as $image) {
            // 2. On vérifie la présence de l'ID, pas de la ref !
            if (!empty($image['id'])) {
                $keptImageIds[] = $image['id'];
                continue;
            }

            // 3. C'est une nouvelle image sans ID, on l'upload
            if (isset($uploadedFiles[$fileIndex]) && $uploadedFiles[$fileIndex]->isValid()) {
                $path = $uploadedFiles[$fileIndex]->store('commission-images', 'public');
                $newImage = $commission->images()->create([
                    'storage_path' => Storage::url($path),
                    'caption' => $image['label'] ?? '',
                ]);
                $keptImageIds[] = $newImage->id;
                $fileIndex++;
            }
        }

        // 4. On supprime les images qui ne sont plus dans la liste
        $commission->images()
            ->whereNotIn('id', array_filter($keptImageIds))
            ->get()
            ->each(function (CommissionImage $img) {
                if ($img->storage_path) {
                    $path = str_replace('/storage/', '', $img->storage_path);
                    Storage::disk('public')->delete($path);
                }
                $img->delete();
            });
    }

    private function syncQuestions(Commission $commission, array $questions): void
    {
        $commission->questions()->delete();

        foreach ($questions as $question) {
            $textPayload = ['label' => $question['label'] ?? ''];

            if (!empty($question['options'])) {
                $textPayload['options'] = $question['options'];
            }

            $commission->questions()->create([
                'text' => $textPayload,
                'field_type' => $question['field_type'],
            ]);
        }
    }
}
