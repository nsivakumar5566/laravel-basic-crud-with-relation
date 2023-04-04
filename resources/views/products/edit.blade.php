@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card p-4">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="procategoryid" class="form-label">Category</label>
                        <select class="form-select" id="procategoryid" aria-label="Default select example"
                            name="category_id" value="{{ $product->category_id }}">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="proname" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="proname" name="name" value="{{ $product->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="proprice" class="form-label">Product Price</label>
                        <input type="text" class="form-control" id="proprice" name="price"
                            value="{{ $product->price }}">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection