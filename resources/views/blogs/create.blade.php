@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>New Blog Post</h3>
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

            <form action="{{ url('/blogs') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Baslik</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Yazar</label>
                    <input type="text" class="form-control" id="author" name="author" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">İmage</label>
                    <input type="text" class="form-control" id="image" name="image" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-control" id="category_id" name="category_id">
                        <option value="">Kategori Seçin</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Oluştur</button>
            </form>
        </div>
    </div>
@endsection
