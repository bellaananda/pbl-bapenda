<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
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
    public function index(Request $request)
    {
        $search = $request->search;
        $data = Category::paginate(15);
        if ($search != null) {
            $data = DB::table('categories')
                    ->where('name', 'LIKE', '%' . $search .'%')->paginate(15);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Kategori',
            'data'    => $data  
        ], 200);
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
            return response()->json($validator->errors(), 400);
        }

        $data = Category::create([
            'name' => $request->name
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori baru gagal ditambahkan!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Kategori baru berhasil ditambahkan!',
            'data'    => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Category::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data kategori!',
            'data'    => $data
        ], 200);
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
            return response()->json([
                'success' => false,
                'message' => 'Data kategori tidak ditemukan!'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data->update([
            'name' => $request->name
        ]);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori gagal diubah!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil diubah!',
            'data'    => $data
        ], 200);
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
            return response()->json([
                'success' => false,
                'message' => 'Data kategori tidak ditemukan!'
            ], 404);
        }
        $data->delete();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori gagal dihapus!'
            ], 409);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil dihapus!'
        ], 200);
    }
}
