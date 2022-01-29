<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all(
            'category_id',
            'brand_id',
            'product_name',
            'product_slug',
            'product_keywords',
            'product_desc',
            'product_content',
            'product_price',
            'product_image',
            'product_status',
            'created_at',
            'updated_at',
        );
    }
}