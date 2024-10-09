<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return response()->json(Blog::all(), 200);
    }


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

    
    public function show($id)
    {
        $blog = Blog::find($id);
        
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        return response()->json($blog, 200);
    }

   
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
