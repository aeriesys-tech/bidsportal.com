<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function getCategories(Request $request){
		$cacheKey = 'categories';
        $categories = Cache::remember($cacheKey, 60 * 60, function () use($request) {
        	return Category::orderBy('category_name')->get();
        });
        return $categories;
	}

	public function paginateCategories(Request $request)
	  {
	      $request->validate([
	          'order_by' => 'required',
	          'per_page' => 'required|numeric',
	          'keyword' => 'required'
	      ]);
	      $query = Category::query();
	        
	      if($request->search!='')
	      {
	          $query->where('category_name', 'like', "%$request->search%")
	            ->orWhere('sort', 'like', "$request->search%");
	      }
	      $categories = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
	      return CategoryResource::collection($categories);
	  }

	  public function addCategory(Request $request)
	  {
	      $data = $request->validate([
	          'category_name' => 'required',
	          'sort' => 'nullable'
	      ]);

	      $state = Category::create($data);
	      return new CategoryResource($state);
	  }

	  public function getCategory(Request $request)
	  {
	      $request->validate([
	          'category_id' => 'required|exists:categories,category_id'
	      ]);

	      $category = Category::where('category_id', $request->category_id)->first();
	      return new CategoryResource($category);
	  }

	  public function updateCategory(Request $request)
	  {
	      $data = $request->validate([
	          'category_id' => 'required|exists:categories,category_id',
	          'category_name' => 'required',
	          'sort' => 'nullable'
	      ]);

	      $state = Category::where('category_id', $request->category_id)->first();
	      $state->update($data);
	      return new CategoryResource($state);
	  }

	  public function deleteCategory(Request $request)
	  {
	      $request->validate([
	          'category_id' => 'required|exists:categories,category_id'
	      ]);

	      Category::where('category_id', $request->category_id)->forceDelete();
	      return response()->json([
	          "message" => 'StateAgency Deleted Successfully'
	      ]);
	  }
}
