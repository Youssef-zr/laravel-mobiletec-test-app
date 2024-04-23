<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Models\News;
use Carbon\Carbon;
use Exception;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::orderBy('date_debut', 'desc')
            ->distinct()->with('category')
            ->where('date_expiration', '>', Carbon::now())
            ->get();

        return response()->json(['news' => $news], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $news = new News();
        $data = $request->validated();
        $news->create($data);

        return response()->json(['msg' => 'created successfully','news' => $news], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {

            $news = News::findOrFail($id);
            return response()->json(['news' => $news, 200]);

        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, $id)
    {
        try {

            $news = News::findOrFail($id);
            $data = $request->validated();
            $news->update($data);

            return response()->json(['msg' => 'updated successfully','news' => $news], 201);

        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $news = News::findOrFail($id);
            $news->delete();

            return response()->json(['msg' => 'deleted successfully','news' => null], 204);

        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
