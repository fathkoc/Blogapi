@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit Blog Post</h3>
        </div>
        <div class="card-body">
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ url('/blogs/' . $blog->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required>{{ $blog->content }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Yazar</label>
                    <input type="text" class="form-control" id="author" name="author" value="{{ $blog->author }}" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="text" class="form-control" id="image" name="image" value="{{ $blog->image }}" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <input type="text" class="form-control" id="category" name="category" value="{{ $blog->category }}">
                </div>
                <button type="submit" class="btn btn-primary">Güncelle</button>
            </form>
        </div>
    </div>
@endsection
