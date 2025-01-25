<?php

namespace App\Repositories\Admin\Pos;

use App\Models\AttributeOption;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;


class POSRepository implements POSRepositoryInterface
{
    public function getAllProductsWithDetails(array $filters = [])
    {

        $query = Product::orderBy('product_name', 'asc')->with(
            'product_attributes.attribute',
            'product_attributes.attribute_option',
            'product_campaign',
            'product_campaign.campaign',
            'category'
        );


        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['brand'])) {
            $query->where('brand_id', $filters['brand']);
        }


        // Filter out products with a quantity of 0
         $query->where('quantity', '>', 0);

        return $query->get();
    }



    public function apigetAllProductsWithDetails()
    {
        $products = Product::orderBy('product_name', 'asc')->with([
            'product_attributes.attribute',
            'product_attributes.attribute_option',
            'product_attributes_combaine',
            'product_campaign',
            'product_campaign.campaign',
            'category'
        ])->get(); // Fetch all products with relationships.

        $products->each(function ($product) {
            $product->product_attributes = $product->product_attributes_combaine->map(function ($combine) {
                // Extract option IDs from combination_string
                $optionIds = explode('_', $combine->combination_string);

                // Fetch options and their related attributes
                $options = AttributeOption::whereIn('id', $optionIds)->with('attribute')->get();

                // Separate attributes and attribute options into distinct arrays
                $attributes = $options->map(function ($option) {
                    return [
                        'id' => $option->attribute->id,
                        'name' => $option->attribute->name,
                    ];
                })->unique(); // Avoid duplicates in the attributes array.

                $attributeOptions = $options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'name' => $option->name,
                        'attribute_id' => $option->attribute->id,
                    ];
                });

                // Return the full transformed structure for each `combine`
                return [
                    'id' => $combine->id,
                    'product_id' => $combine->product_id,
                    'combination_string' => $combine->combination_string,
                    'price' => $combine->price,
                    'quantity' => $combine->quantity,
                    'created_at' => $combine->created_at,
                    'updated_at' => $combine->updated_at,
                    'attributes' => $attributes,
                    'attribute_options' => $attributeOptions,
                ];
            });
        });

        return $products; // Return the modified products as JSON.
    }



    public function getAllCategories()
    {
        return Category::where('status', 'active')->get();
    }

    public function getAllBrands()
    {
        return Brand::latest()->get();
    }
}
