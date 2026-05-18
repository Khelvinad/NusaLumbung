<?php

namespace App\Http\Controllers;

use App\Enums\HarvestPoolStatus;
use App\Http\Requests\JoinHarvestPoolRequest;
use App\Http\Requests\StoreHarvestPoolRequest;
use App\Http\Resources\HarvestPoolResource;
use App\Models\HarvestPool;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class HarvestPoolController extends Controller
{
    use AuthorizesRequests;

    /**
     * List active pools (open & not past deadline).
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', HarvestPool::class);

        $pools = HarvestPool::query()
            ->with(['creator'])
            ->withCount('members')
            ->where('status', HarvestPoolStatus::Open)
            ->where('deadline', '>=', now()->toDateString())
            ->latest()
            ->paginate(15);

        if ($request->expectsJson() || $request->is('api/*')) {
            return HarvestPoolResource::collection($pools);
        }

        return view('petani.harvest-pools.index', compact('pools'));
    }

    public function show(Request $request, HarvestPool $harvestPool)
    {
        $this->authorize('view', $harvestPool);

        if ($request->expectsJson() || $request->is('api/*')) {
            return new HarvestPoolResource(
                $harvestPool->load(['creator', 'members.user'])
            );
        }

        return view('petani.harvest-pools.show', compact('harvestPool'));
    }

    public function create()
    {
        $this->authorize('create', HarvestPool::class);
        return view('petani.harvest-pools.create');
    }

    /**
     * Create a new harvest pool.
     */
    public function store(StoreHarvestPoolRequest $request)
    {
        $this->authorize('create', HarvestPool::class);

        $pool = HarvestPool::create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        if ($request->expectsJson() || $request->is('api/*')) {
            return (new HarvestPoolResource($pool->load('creator')))
                ->response()
                ->setStatusCode(201);
        }

        return redirect()->route('petani.harvest-pools.index')->with('success', 'Pooling panen berhasil dibuat!');
    }

    /**
     * Join a pool with a qty contribution.
     */
    public function join(JoinHarvestPoolRequest $request, HarvestPool $harvestPool)
    {
        $this->authorize('join', $harvestPool);

        $user = $request->user();
        $qty = $request->validated('qty');

        $pool = DB::transaction(function () use ($harvestPool, $user, $qty) {
            $pool = HarvestPool::lockForUpdate()->find($harvestPool->id);

            if (! $pool->isJoinable()) {
                abort(409, 'Pool ini sudah tidak bisa diikuti.');
            }

            if ($pool->members()->where('user_id', $user->id)->exists()) {
                abort(409, 'Anda sudah bergabung di pool ini.');
            }

            $pool->members()->create([
                'user_id' => $user->id,
                'qty' => $qty,
            ]);

            $pool->increment('current_qty', $qty);
            $pool->refresh();

            if ($pool->current_qty >= $pool->target_qty) {
                $pool->update(['status' => HarvestPoolStatus::Fulfilled]);
            }

            return $pool;
        });

        if ($request->expectsJson() || $request->is('api/*')) {
            return (new HarvestPoolResource($pool->load(['creator', 'members.user'])))
                ->response()
                ->setStatusCode(201);
        }

        return redirect()->route('petani.harvest-pools.show', $harvestPool)->with('success', 'Berhasil bergabung dengan pooling panen!');
    }
}
