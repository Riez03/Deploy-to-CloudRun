<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientsRequest;

class IngredientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $ingredients = Ingredients::paginate(10);

        return view('ingredients.index', [
            'ingredients' => $ingredients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ingredients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IngredientsRequest $request)
    {
        $data = $request->all();

        $data['picture_path'] = $request->file('picture_path')->store('assets/ingredients', 'public');

        Ingredients::create($data);

        return redirect()->route('ingredients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredients $ingredients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredients $ingredient)
    {
        return view('ingredients.edit', [
            'item' => $ingredient
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IngredientsRequest $request, Ingredients $ingredient)
    {
        $data = $request->all();

        if ($request->file('picture_path')) {
            $data['picture_path'] = $request->file('picture_path')->store('assets/ingredients', 'public');
        }
        $ingredient->update($data);

        return redirect()->route('ingredients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredients $ingredient)
    {
        $ingredient->delete();

        return redirect()->route('ingredients.index');
    }
}
