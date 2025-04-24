<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class StockMovementController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of stock movements.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', StockMovement::class);

        $query = StockMovement::with(['product', 'user'])
            ->when($request->product_id, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            });

        $movements = $query->latest()->paginate(10)->withQueryString();
        $products = Product::all();

        return Inertia::render('StockMovements/Index', [
            'movements' => $movements,
            'products' => $products,
            'filters' => $request->only(['product_id', 'type']),
            'can' => [
                'create' => Gate::allows('create', StockMovement::class),
            ],
        ]);
    }

    /**
     * Show the form for creating a new stock movement.
     */
    public function create()
    {
        $this->authorize('create', StockMovement::class);

        $products = Product::orderBy('name')->get();
        $types = [
            'in' => 'Stock In',
            'out' => 'Stock Out',
        ];

        return Inertia::render('StockMovements/Create', [
            'products' => $products,
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created stock movement.
     */
    public function store(Request $request)
    {
        $this->authorize('create', StockMovement::class);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255'
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'out' && $product->stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        $stockMovement = StockMovement::create([
            'product_id' => $validated['product_id'],
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'notes' => $validated['notes'],
            'user_id' => Auth::id()
        ]);

        // Update product stock
        $product->stock += $validated['type'] === 'in' ? $validated['quantity'] : -$validated['quantity'];
        $product->save();

        return redirect()->route('stock-movements.index')
            ->with('success', 'Stock movement recorded successfully.');
    }

    /**
     * Display the specified stock movement.
     */
    public function show(StockMovement $stockMovement)
    {
        $this->authorize('view', $stockMovement);

        $stockMovement->load(['product', 'user']);
        return Inertia::render('StockMovements/Show', [
            'movement' => $stockMovement,
        ]);
    }
}
