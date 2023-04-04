@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card p-4">
                <form action="{{ route('category.update',$category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="catname" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="catname" name="name" value="{{ $category->name }}">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection