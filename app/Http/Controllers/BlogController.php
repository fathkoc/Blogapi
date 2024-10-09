<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\ContentModerationService;

class BlogController extends Controller
{
    protected $moderationService;

    public function __construct(ContentModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    public function index()
    {
        $blogs = Blog::with('category')->get();
    
        return view('blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'image' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ],[
            'title.required' => 'Blog başlığı alanı zorunludur.',
            'title.max' => 'Blog başlığı en fazla 255 karakter olabilir.',
            'content.required' => 'İçerik alanı zorunludur.',
            'author.required' => 'Yazar alanı zorunludur.',
            'image.required' => 'Resim URL\'si alanı zorunludur.',
            'category_id.exists' => 'Seçilen kategori geçersiz.',
        ]);

        $moderationResult = $this->moderationService->moderateContent($request->input('content'));

        if ($moderationResult['status'] === 'rejected') {
            return back()->withErrors(['content' => $moderationResult['message']]);
        }
        
        Blog::create($request->all());

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function show($id)
    {
        $blog = Blog::with('category')->find($id);
        
        if (!$blog) {
            return redirect()->route('blogs.index')->with('error', 'Blog not found.');
        }

        return view('blogs.show', compact('blog'));
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        $categories = Category::all();

        if (!$blog) {
            return redirect()->route('blogs.index')->with('error', 'Blog not found.');
        }

        return view('blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required',
            'author' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|required|string',
            'category_id' => 'nullable|exists:categories,id',
        ],[
            'title.required' => 'Blog başlığı alanı zorunludur.',
            'title.max' => 'Blog başlığı en fazla 255 karakter olabilir.',
            'content.required' => 'İçerik alanı zorunludur.',
            'author.required' => 'Yazar alanı zorunludur.',
            'image.required' => 'Resim URL\'si alanı zorunludur.',
            'category_id.exists' => 'Seçilen kategori geçersiz.',
        ]);

        $blog = Blog::find($id);
        
        if (!$blog) {
            return redirect()->route('blogs.index')->with('error', 'Blog not found.');
        }

        $moderationResult = $this->moderationService->moderateContent($request->input('content'));
       
        if ($moderationResult['status'] === 'rejected') {
            return back()->withErrors(['content' => $moderationResult['message']]);
        }

        $blog->update($request->all());

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        
        if (!$blog) {
            return redirect()->route('blogs.index')->with('error', 'Blog not found.');
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
