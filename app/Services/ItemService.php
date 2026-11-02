<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class ItemService
{
    /**
     * Get all items with search and pagination.
     */
    public function getAllItems(
        ?string $search = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return Item::query()
            ->withCount('orders')
            ->when(
                $search !== null && trim($search) !== '',
                function ($query) use ($search) {
                    $term = trim($search);

                    $query->where(function ($q) use ($term) {
                        $q->where('name', 'like', "%{$term}%")
                            ->orWhere('description', 'like', "%{$term}%");
                    });
                }
            )
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Get one item by ID.
     */
    public function getItemById(int $id): Item
    {
        return Item::findOrFail($id);
    }

    /**
     * Create a new item.
     */
    public function createItem(array $data): Item
    {
        /* Store uploaded image in storage/app/public/items */
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('items', 'public');
        }

        return Item::create($data);
    }

    /**
     * Update an existing item.
     */
    public function updateItem(int $id, array $data): Item
    {
        $newImage = null;

        try {
            return DB::transaction(function () use (
                $id,
                $data,
                &$newImage
            ) {
                $item = Item::query()
                    ->lockForUpdate()
                    ->findOrFail($id);

                /* Keep the old image path */
                $oldImage = $item->image;

                /* Upload new image only when user selects one */
                if (isset($data['image'])) {
                    $newImage = $data['image']->store('items', 'public');
                    $data['image'] = $newImage;
                }

                $item->update($data);

                /* Delete old image after successful database update */
                if ($newImage && $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }

                return $item->refresh();
            });
        } catch (Throwable $e) {
            /* Delete newly uploaded image if database update fails */
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    /**
     * Delete an item if it has not been used in an order.
     */
    public function deleteItem(int $id): void
    {
        DB::transaction(function () use ($id) {
            $item = Item::query()
                ->lockForUpdate()
                ->findOrFail($id);

            if ($item->orderItems()->exists()) {
                throw ValidationException::withMessages([
                    'item' => 'This item has been used in an order and cannot be deleted.',
                ]);
            }

            /* Delete item's image */
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            $item->delete();
        });
    }
}
