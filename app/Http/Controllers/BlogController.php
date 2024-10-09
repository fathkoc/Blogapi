<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Tüm blog yazılarını listeleme
    public function index()
    {
        return response()->json(Blog::all(), 200);
    }

    // Yeni bir blog yazısı oluşturma
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'image' => 'required|string',
        ]);

        $blog = Blog::create($request->all());

        return response()->json($blog, 201);
    }

    // Belirli bir blog yazısını gösterme
    public function show($id)
    {
        $blog = Blog::find($id);
        
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        return response()->json($blog, 200);
    }

    // Blog yazısını güncelleme
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required',
            'author' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|required|string',
        ]);

        $blog = Blog::find($id);
        
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        $blog->update($request->all());

        return response()->json($blog, 200);
    }

    // Blog yazısını silme
    public function destroy($id)
    {
        $blog = Blog::find($id);
        
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted'], 200);
    }
}
