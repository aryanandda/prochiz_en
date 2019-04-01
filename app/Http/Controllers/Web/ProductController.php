<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Article;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::status('published')->orderBy('id', 'asc')->first();

        return redirect('/produk/'.$product->slug, 301);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::status('published')->slug($slug)->first();

        if (!$product) {
            return abort(404);
        }

        $products = Product::status('published')->orderBy('id', 'asc')->get();
        $recipes = $product->recipes()
                    ->whereIn('status', ['published', 'approved'])
                    ->with('user', 'category')
                    ->orderBy('published_at', 'desc')
                    ->paginate(12);

        $currents = ['produk'];

        if ($recipes->currentPage() === 1)  {
            $footer_text = Article::type('footertext')->slug($slug)->status('published')->orderBy('published_at', 'desc')->first();
        }

        return view('web.product-detail', compact('product', 'products', 'recipes', 'slug', 'currents', 'footer_text'));
    }
}
