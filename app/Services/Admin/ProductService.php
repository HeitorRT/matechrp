<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    /**
     * @var UploadImageService
     */
    protected UploadImageService $uploadImageService;

    /**
     * @param UploadImageService $uploadImageService
     */
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }

   /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Product[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        return Product::when(Arr::get($filters, 'name'), function (Builder $builder, $name) {
            return $builder->where('name', 'like', "%{$name}%");
        })->when($orderBy, function(Builder $query) use ($orderBy, $sort){
            return $query->orderBy($orderBy, $sort);
        })->paginate($rowsPerPage);
    }

    /**
     * @param array $requestData
     * @return Product
     */
    public function store(array $requestData = []): Product
    {
        $product = Product::create($this->transformData($requestData));

        $this->uploadImageService->upload($product, 'image', Arr::get($requestData, 'image'));

        return $product;
    }

   /**
     * @param Product $product
     * @param array $requestData
     * @return Product
     */
    public function update(Product $product, array $requestData = []): Product
    {
        $product->update($this->transformData($requestData));

        $this->uploadImageService->upload($product, 'image', Arr::get($requestData, 'image'));

        return $product;
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        return Arr::except($requestData, ['image']);
    }

    /**
     * @param Product $product
     * @return boolean|null
     */
    public function delete(Product $product): ?bool
    {
        $this->uploadImageService->delete($product, 'image');

        return $product->delete();
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($product = Product::find($id)) {
                $this->delete($product);
            }
        }
    }
}
