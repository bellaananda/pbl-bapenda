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
        $search = $request->input('search', null);
        $order = $request->input('order', 'id');
        $sort = $request->input('sort', 'asc');
        $page = $request->input('page', 15);
        $data = Category::paginate($page);
        if ($search != null) {
            $data = DB::table('categories')
                    ->where('name', 'LIKE', '%' . $search .'%')
                    ->orderBy($order, $sort)->paginate($page);
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
            'name' => 'required|string|max:100|unique:categories',
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
            'name' => 'required|string|max:100|unique:categories',
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

    public function trash(Request $request)
    {
        $page = $request->input('page', 15);
        $data = Category::onlyTrashed()->paginate($page);
        return response()->json([
            'success' => true,
            'message' => 'Daftar Kategori (Dihapus)',
            'data'    => $data  
        ], 200);
    }

    public function restore($id)
    {
        $data = Category::withTrashed()->find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori tidak ditemukan di sampah!'
            ], 404);
        }
        if($data->trashed()){
            $data->restore();
            return response()->json([
                'success' => true,
                'message' => 'Data kategori berhasil dipulihkan!',
                'data'    => $data  
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori tidak ditemukan di sampah!',
            ], 404);
        }
    }

    public function deletePermanent($id)
    {
        $data = Category::withTrashed()->find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori tidak ditemukan di sampah!'
            ], 404);
        }
        if(!$data->trashed())
        {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori tidak ditemukan di sampah!',
            ], 404);
        } else {
            $data->forceDelete();
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kategori gagal dihapus permanen!'
                ], 409);
            }
            return response()->json([
                'success' => true,
                'message' => 'Data kategori berhasil dihapus permanen!'
            ], 200);
        }
    }   
}
