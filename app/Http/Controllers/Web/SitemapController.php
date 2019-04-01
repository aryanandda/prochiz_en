<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Article;
use App\Models\Recipe;
use Response;

class SitemapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <url>
                <loc>%1$s</loc>
                <changefreq>daily</changefreq>
            </url>
            <url>
                <loc>%2$s</loc>
            </url>
            <url>
                <loc>%3$s</loc>
            </url>
            <url>
                <loc>%4$s</loc>
            </url>
            <url>
                <loc>%5$s</loc>
            </url>
            <url>
                <loc>%6$s</loc>
            </url>
            <url>
                <loc>%7$s</loc>
            </url>
        </urlset>';

        $content = sprintf($content, url('/'), url('/sitemap/produk'), url('/sitemap/resep/prochiz'), url('/sitemap/resep/prochizlover'), url('/sitemap/news'), url('/sitemap/tips'), url('/sitemap/video'));

        return Response::make($content, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        $products = Product::status('published')->orderBy('id', 'asc')->get();

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            %1$s
        </urlset>';

        $items = '';
        foreach ($products as $key => $value) 
        {
            $items .= '
            <url>
                <loc>'.url('/produk/'.$value->slug).'</loc>
                <lastmod>'.$value->updated_at->format('Y-m-d\TH:i:sP').'</lastmod>
            </url>';
        }

        $content = sprintf($content, $items);

        return Response::make($content, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recipes($type)
    {
        $status = ($type == 'prochiz') ? 'published' : 'approved';

        $recipes = Recipe::type($type)
                    ->status($status)
                    ->orderBy('published_at', 'desc')
                    ->get();

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <url>
                <loc>%1$s</loc>
                <changefreq>daily</changefreq>
            </url>
            %2$s
        </urlset>';

        $items = '';
        foreach ($recipes as $key => $value) 
        {
            $items .= '
            <url>
                <loc>'.url('/resep/'.$value->type.'/'.$value->id.'/'.$value->slug).'</loc>
                <lastmod>'.$value->published_at->format('Y-m-d\TH:i:sP').'</lastmod>
            </url>';
        }

        $content = sprintf($content, url('/resep/'.$type), $items);

        return Response::make($content, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articles($type)
    {
        $articles = Article::type($type)
                    ->status('published')
                    ->orderBy('published_at', 'desc')
                    ->get();

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <url>
                <loc>%1$s</loc>
                <changefreq>daily</changefreq>
            </url>
            %2$s
        </urlset>';

        $items = '';
        foreach ($articles as $key => $value) 
        {
            $items .= '
            <url>
                <loc>'.url('/'.$value->type.'/'.$value->slug).'</loc>
                <lastmod>'.$value->published_at->format('Y-m-d\TH:i:sP').'</lastmod>
            </url>';
        }

        $content = sprintf($content, url('/'.$type), $items);

        return Response::make($content, 200)->header('Content-Type', 'application/xml');
    }
}
