@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Blog Posts</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                        <tr>
                            <td>{{ $blog->id }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->author }}</td>
                            <td>{{ $blog->category ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ url('/blogs/' . $blog->id . '/edit') }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ url('/blogs/' . $blog->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
