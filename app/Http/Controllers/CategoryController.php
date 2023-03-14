<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\ApiFormat;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        return new ApiFormat(true, 'Daftar Kategori', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
        }

        $data = Category::create([
            'name' => $request->name
        ]);
        if (!$data) {
            return new ApiFormat(true, 'Kategori baru gagal ditambahkan!', $data);
        }
        return new ApiFormat(true, 'Kategori baru berhasil ditambahkan!', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $data = Category::find($category);
        if (!$data) {
            return new ApiFormat(false, 'Data kategori tidak ditemukan!', null);
        }
        return new ApiFormat(true, 'Berhasil mendapatkan data kategori!', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = Category::find($category->id);
        if (!$data) {
            return new ApiFormat(false, 'Data kategori tidak ditemukan!', null);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return new ApiFormat(false, 'Validasi gagal', $validator->errors()->all());
        }

        $data->update([
            'name' => $request->name
        ]);

        return new ApiFormat(true, 'Data kategori berhasil diubah!', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $data = Category::find($category->id);
        if (!$data) {
            return new ApiFormat(false, 'Data kategori tidak ditemukan!', null);
        }
        $data->delete();

        return new ApiFormat(true, 'Data kategori berhasil dihapus!', $data);
    }
}
