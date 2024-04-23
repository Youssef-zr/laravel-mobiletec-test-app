<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;

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

        if ($category == null) {
            return response()->json(
                ['msg' => 'record not foud'],
                403
            );
        }

        $news = collect(); // Initialize an empty collection

        // Call the recursive function to retrieve the news
        $this->getNewsRecursively($category, $news, true);

        if ($news->isEmpty()) {
            return response()->json(
                [
                    'msg' => 'No news found for the specified category.'
                ],
                404
            );
        } else {
            return response()->json(["news" => $news], 200);
        }
    }

    // get category by name and recursive active news
    public function searchRecursiveNews($categoryName)
    {

        $category = Category::where('nom', $categoryName)
            ->with('notExpiredNews')
            ->first();

        if ($category == null) {
            return response()->json(
                ['msg' => 'record not foud'],
                403
            );
        }

        $news = collect(); // Initialize an empty collection

        // Call the recursive function to retrieve the news
        $this->getNewsRecursively($category, $news);

        if ($news->isEmpty()) {
            return response()->json(
                [
                    'msg' => 'No news found for the specified category.'
                ],
                404
            );
        } else {
            return response()->json(["news" => $news], 200);
        }
    }

    // Iterate through the news of the category
    public function getNewsRecursively($category, &$news, $expired = false)
    {

        $categoryNews = $expired ? $category->news : $category->notExpiredNews;

        // Retrieve the news associated with the current category
        $news = $news->merge($categoryNews);

        // Iterate through the subcategories of the current category
        foreach ($category->children as $childCategory) {

            // Recursion for each subcategory
            $this->getNewsRecursively($childCategory, $news);
        }
    }
}
