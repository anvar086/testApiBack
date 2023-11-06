<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function store(ArticleCreateRequest $request){
        $article = new Article();
        $requestAll = $request->except('_token');
        if($request->hasFile('image')==true) {
            $uploadFile = $request->file('image');
            $fileName = Article::uploadPhoto($uploadFile);
            $requestAll['image'] = $fileName;
        }
        else{
            $fileName = null;
        }
        $article->image = $fileName;
        $article->title = $request->title;
        $article->text = $request->text;
        $article->user_id = Auth::user()->id;
        $article->article_date = $request->article_date;
        $article->save();
        return $this->success($article);
    }

    public function show($id){
        $article = Article::where('id',$id)->first();
        $user = $article->user->name;
        Log::channel('daily')->critical('asdadsa');
        return $this->success($article);
    }

    public function update(ArticleUpdateRequest $request,$id){
        $article = Article::where('id',$id)->first();
        $requestAll = $request->except('_token');
        if($request->hasFile('image')==true) {
            $uploadFile = $request->file('image');
            $fileName = Article::uploadPhoto($uploadFile);
            $requestAll['image'] = $fileName;
        }
        else{
            $fileName = null;
        }
        $article->image = $fileName;
        $article->title = $request->title;
        $article->text = $request->text;
        $article->user_id = Auth::user()->id;
        $article->article_date = $request->article_date;
        $article->save();
        return $this->success($article);
    }

    public function delete($id){
        $article = Article::where('id',$id)->first();
        $article->delete();
        return $this->success($article);
    }
}
