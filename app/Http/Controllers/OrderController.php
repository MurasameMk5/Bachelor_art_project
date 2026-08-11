<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Order;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    #[Authorize('viewAny', Order::class)]
    public function index()
    {
        $orders = Order::with(['artist', 'client', 'commission', 'commission.images'])->get();

        return Inertia::render('Dashboard', [
            'orders' => $orders
            ]);
    }

    #[Authorize('viewAny', Order::class)]
    public function toDoRequest()
    {
        $orders = Order::with(['artist', 'client', 'commission'])->get();

        return Inertia::render('Request', [
            'orders' => $orders->where('status', 'to do')->values()
            ]);
    }



    #[Authorize('view', 'order')]
    public function show(Request $request, Order $order)
    {

        return Inertia::render('Order', [
            'order' => $order->load(['artist', 'client', 'commission.questions', 'messages.sender', 'contract', 'answers.question', 'escrow', 'deliverables']),
            'user' => $request->user(),
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'commission_id' => 'required|exists:commissions,id',
            'answers' => 'sometimes|array',
        ]);

        $commission = Commission::findOrFail($validated['commission_id']);

        Gate::authorize('create', [Order::class, $commission]);

        $order = DB::transaction(function () use ($commission, $request, $validated) {
            $order = Order::create([
                'artist_id' => $commission->artist->id,
                'client_id' => $request->user()->id,
                'commission_id' => $commission->id,
                'base_price' => $commission->base_price,
                'final_price' => $commission->base_price,
                'max_free_revisions' => $commission->max_free_revisions,
                'current_revision_count' => 0,
                'status' => 'to do',
            ]);

            foreach ($validated['answers'] ?? [] as $questionId => $value) {
                $order->answers()->create([
                    'question_id' => $questionId,
                    'value' => ['text' => $value],
                ]);
            }

            return $order;
        });

        return redirect()->back();
    }
    #[Authorize('update', 'order')]
        public function update(Request $request, Order $order)
        {
            $validated = $request->validate([
                'status' => 'sometimes|in:to do,doing,done,cancelled',
                'production_stage' => 'sometimes|nullable|in:brief,production,revision,final_delivery,awaiting_payment',
                'final_price' => 'sometimes|integer|min:0',
                'current_revision_count' => 'sometimes|integer|min:0',
                'awaiting_confirmation' => 'sometimes|boolean',
                'stage_details' => 'sometimes|array',
                'image_stages' => 'sometimes|array',
                'files' => 'sometimes|array',
                'files.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);

            $stageDetails = $validated['stage_details'] ?? $order->stage_details ?? [];

            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $stages = $request->input('image_stages', []);

                foreach ($files as $index => $file) {
                    if ($file->isValid()) {
                        $path = $file->store('order-images', 'public');
                        $url = Storage::url($path);

                        $stage = $stages[$index] ?? 'general';

                        if (!isset($stageDetails['production'][$stage])) {
                            $stageDetails['production'][$stage] = [];
                        }

                        $stageDetails['production'][$stage][] = [
                            'url' => $url,
                            'name' => $file->getClientOriginalName(),
                            'uploaded_at' => now()->toDateTimeString(),
                        ];
                    }
                }

                $validated['stage_details'] = $stageDetails;
            }
            unset($validated['files'], $validated['image_stages']);
            $order->update($validated);

            return redirect()->back();
        }
}
