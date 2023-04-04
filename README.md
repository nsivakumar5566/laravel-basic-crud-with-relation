# Laravel CRUD with One to Many Relation

Hi Viewers, In this example you can see the source code of CRUD with One to Many Relation in Laravel 9

## Getting Started

#### 1. Create a new project
````
composer create-project laravel/laravel your-project-name
````

#### 2. Set your Database name, Username and Passowrd in .ENV file
This folder will be available in your project root folder
````
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE= // set database name
DB_USERNAME= // set username
DB_PASSWORD= // set password
````

#### 3. Create a Category Table with Model and Controller in one line use the below command
````
php artisan make:model Category -mcr
````

#### 4. Create a Product Table with Model and Controller in one line use the below command
````
php artisan make:model Product -mcr
````

#### 4. In database/migration/create_categories_table
````
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
````

#### 5. In database/migration/crate_products_table.php
````
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('category_id');
    $table->string('name');
    $table->bigInteger('price');
    $table->timestamps();

    $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
});
````

#### 6. Run the below command to migrate your table to the database
````
php artisan migrate:fresh
````

#### 7. In App/Models/Category.php
````
protected $table = 'categories';

protected $fillable = [
    'name',
];

public function products()
{
    return $this->hasMany(Product::class);
}
````

#### 8. In App/Models/Product.php
````
protected $table = 'products';

protected $fillable = [
    'category_id', 'name', 'price',
];

public function categories()
{
    return $this->belongsTo(Category::class, 'category_id', 'id');
}
````

#### 9. In routes/web.php
````
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;



Route::resource('category', CategoryController::class);
Route::resource('products', ProductController::class);
````

#### 10. In App/Http/Controllers/CategoryController.php
````
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(5);

        return view('category.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Category::create($request->all());

        return redirect()->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category->update($request->all());

        return redirect()->route('category.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')
            ->with('success', 'Category deleted successfully');
    }
}
````

#### 11. In App/Http/Controllers/ProductController.php
````
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);

        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
````

#### 12. Create a file views/layout/app.blade.php and Paste the below code.
````
<!DOCTYPE html>
<html>

<head>
    <title>Laratask</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
````

#### 13. In views/welcome.blade.php paste the below code.
````
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
````

#### 14. Create a file views/category/index.blade.php and Paste the below code.
````
@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card p-4">
                <a href="{{ route('category.create') }}" class="btn btn-secondary p-3 mb-4">
                    <h5 class="mb-0">Create Category</h5>
                </a>

                @if ($message = Session::get('success'))
                <div class="alert alert-success mb-4">
                    <p class="mb-0">{{ $message }}</p>
                </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">S.No</th>
                            <th scope="col">Category Name</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <th scope="row" class="text-center">{{ ++$i }}</th>
                            <td>{{ $category->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('category.destroy',$category->id) }}" method="POST">
                                    <a href="{{ route('category.show',$category->id) }}"
                                        class="btn btn-primary">Show</a>
                                    <a href="{{ route('category.edit',$category->id) }}"
                                        class="btn btn-success">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex">
                    {!! $categories->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
````

#### 15. Create a file views/category/create.blade.php and Paste the below code.
````
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card p-4">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="catname" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="catname" name="name">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Create Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
````

#### 16. Create a file views/category/edit.blade.php and Paste the below code.
````
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
````

#### 17. Create a file views/category/show.blade.php and Paste the below code.
````
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card p-4">
                <div class="mb-3">
                    <label for="catname" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="catname" name="name" value="{{ $category->name }}"
                        disabled>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
````

#### 18. Create a file views/products/index.blade.php and Paste the below code.
````
@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card p-4">
                <a href="{{ route('products.create') }}" class="btn btn-secondary p-3 mb-4">
                    <h5 class="mb-0">Create Product</h5>
                </a>

                @if ($message = Session::get('success'))
                <div class="alert alert-success mb-4">
                    <p class="mb-0">{{ $message }}</p>
                </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">S.No</th>
                            <th scope="col">Category</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <th scope="row" class="text-center">{{ ++$i }}</th>
                            <td>{{ $product->categories->name }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td class="text-center">
                                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                                    <a href="{{ route('products.show',$product->id) }}" class="btn btn-primary">Show</a>
                                    <a href="{{ route('products.edit',$product->id) }}" class="btn btn-success">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
````

#### 19. Create a file views/products/create.blade.php and Paste the below code.
````
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card p-4">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="procategoryid" class="form-label">Category</label>
                        <select class="form-select" id="procategoryid" aria-label="Default select example"
                            name="category_id">
                            <option selected disabled>Choose your category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="proname" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="proname" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="proprice" class="form-label">Product Price</label>
                        <input type="text" class="form-control" id="proprice" name="price">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Create Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
````

#### 20. Create a file views/products/edit.blade.php and Paste the below code.
````
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
````

#### 21. Create a file views/products/show.blade.php and Paste the below code.
````
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
````


#### 22. Fix the pagination by editing the file App/Providers/AppServiceProvider.php.
````
use Illuminate\Pagination\Paginator;

public function boot()
{
    Paginator::useBootstrap();
}
````


## END




















