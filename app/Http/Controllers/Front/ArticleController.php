<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $articles = Article::simplePaginate(5);

        return view('front.articles.index', compact('articles'));
    }

    /**
     * Display a listing of the resource filtered by the specified criteria.
     *
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View
    {
        $articles = Article::where(function ($query) use ($request) {
            $query
                ->where('title', 'like', '%'.$request->search.'%')
                ->orWhere('desc', 'like', '%'.$request->search.'%')
                ->orWhere('body', 'like', '%'.$request->search.'%');
        })->simplePaginate(5);

        return view('front.articles.index', compact('articles'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Announcement $announcement
     *
     * @return \Illuminate\View\View
     */
    public function show(Article $article): View
    {
        return view('front.articles.show', compact('article'));
    }
}

