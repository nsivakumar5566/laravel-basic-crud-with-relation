@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card mb-5 text-center">
                <div class="card-header">
                    CRUD - Create, Read, Update and Delete
                </div>
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <p class="card-text">Here you can create, read, update and delete the category records.</p>
                    <a href="{{ route('category.index') }}" class="btn btn-success">Explore to Categories</a>
                </div>
                <div class="card-footer text-muted">
                    Categories
                </div>
            </div>
            <div class="card text-center">
                <div class="card-header">
                    CRUD - Create, Read, Update and Delete
                </div>
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <p class="card-text">Here you can create, read, update and delete the products records.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-success">Explore to Products</a>
                </div>
                <div class="card-footer text-muted">
                    Products
                </div>
            </div>
        </div>
    </div>
</div>

@endsection