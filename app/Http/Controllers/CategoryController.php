<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;

class CategoryController extends Controller
{


    // get categories and children recursive
    public function index()
    {
        $categories = Category::where('parent_id', null)
            ->with('childrenRecursive')->get();

        return response()->json(['categories' => $categories], 200);
    }

    // retrive category recursive news
    public function retriveCategoryNews($categoryId)
    {
        $category = Category::whereId($categoryId)
            ->with('news')
            ->first();

        try {

            $news = $this->collectData($category, true);
            return $news->isEmpty()
                ? response()->json(['msg' => 'No news found for the specified category.'], 404)
                : response()->json(["news" => $news], 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


    // get category by name and recursive active news
    public function searchRecursiveNews($categoryName)
    {

        $category = Category::where('nom', $categoryName)
            ->with('notExpiredNews')
            ->first();

        try {

            $news = $this->collectData($category);
            return $news->isEmpty()
                ? response()->json(['msg' => 'No news found for the specified category.'], 200)
                : response()->json(["news" => $news], 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function collectData($category, $expired = false)
    {
        $news = collect(); // Initialize an empty collection
        $this->getNewsRecursively($category, $news, $expired); // Call the recursive function to retrieve the news

        return $news;
    }

    // Iterate through the news of the category
    public function getNewsRecursively($category, &$news, $expired = false)
    {

        $categoryNews = $expired ? $category->news : $category->notExpiredNews; // check need expired news

        if($category->news->count()>0){
            $news = $news->merge($categoryNews); // Retrieve the news associated with the current category
        }

        // Iterate through the subcategories of the current category
        if ($category->children->count() > 0) {
            foreach ($category->children as $childCategory) {
                $this->getNewsRecursively($childCategory, $news); // Recursion for each subcategory
            }
        }
    }
}
