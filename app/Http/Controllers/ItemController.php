<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct(
        private ItemService $itemService
    ) {}

    public function index(Request $request)
    {
        $items = $this->itemService->getAllItems(
            $request->query('search'),
            10
        );

        return view('items.index', compact('items'));
    }

    public function show(string $id)
    {
        $item = $this->itemService->getItemById((int) $id);

        return view('items.show', compact('item'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(StoreItemRequest $request)
    {
        $this->itemService->createItem($request->validated());

        return redirect()
            ->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    public function edit(string $id)
    {
        $item = $this->itemService->getItemById((int) $id);

        return view('items.edit', compact('item'));
    }

    public function update(UpdateItemRequest $request, string $id)
    {
        $this->itemService->updateItem(
            (int) $id,
            $request->validated()
        );

        return redirect()
            ->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->itemService->deleteItem((int) $id);

        return redirect()
            ->route('items.index')
            ->with('success', 'Item deleted successfully.');
    }
}
