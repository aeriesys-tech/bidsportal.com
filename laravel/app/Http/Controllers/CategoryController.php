<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function getCategories(Request $request){
		$cacheKey = 'categories';
        $categories = Cache::remember($cacheKey, 60 * 60, function () use($request) {
        	return Category::orderBy('category_name')->get();
        });
        return $categories;
	}
}
