<?php

namespace App\Imports;

use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'category_id' => $row['category'],
            'brand_id' => $row['brand'],
            'product_name' => $row['title'],
            'product_slug' => $row['slug'],
            'product_desc' => $row['description'],
            'product_keywords' => $row['keywords'],
            'product_content' => $row['content'],
            'product_price' => $row['price'],
            'product_image' => $row['image'],
            'product_status' => $row['status'],
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}