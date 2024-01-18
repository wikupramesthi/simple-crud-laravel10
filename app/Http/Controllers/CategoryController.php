<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('category.index', [
            'category' => Category::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('category.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $create = Category::create($validated);

        if ($create) {
            // add flash for the success notification
            session()->flash('notif.success', 'Category created successfully!');
            return redirect()->route('category.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return response()->view('category.show', [
            'category' => Category::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        return response()->view('category.form', [
            'category' => Category::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $validated = $request->validated();

        $update = $category->update($validated);

        if ($update) {
            session()->flash('notif.success', 'Category updated successfully!');
            return redirect()->route('category.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $delete = $category->delete($id);

        if ($delete) {
            session()->flash('notif.success', 'Category deleted successfully!');
            return redirect()->route('category.index');
        }

        return abort(500);
    }
}
