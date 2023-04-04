@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card p-4">
                <div class="mb-3">
                    <label for="procategoryid" class="form-label">Category</label>
                    <select class="form-select" id="procategoryid" aria-label="Default select example" disabled>
                        <option selected disabled>{{ $product->categories->name }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="proname" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="proname" value="{{ $product->name }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="proprice" class="form-label">Product Price</label>
                    <input type="text" class="form-control" id="proprice" value="{{ $product->price }}" disabled>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection