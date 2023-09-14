<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    /*
    blog一覧の表示
      @param int $id
      @return view
    */
    public function showList()
    {
        $blogs = Blog::all();

        //dd($blogs);

      return view('blog.list',['blogs'=> $blogs]);
    }

    //ブログ詳細
    public function showDetail($id)
    {
      $blog = Blog::find($id);

        //dd($blogs);
      if(is_null($blog)){
        \Session::flash('err_msg','データがありません');
        return redirect(route('blogs'));
      }

      //return view('blog.detail',['blogs'=> $blog]);
      return view('blog.detail')->with('blog', $blog);
    }

    //blog登録画面の表示
    public function showCreate() {
        return view('blog.form');
    }

    //blogの投稿
    public function exeStore(BlogRequest $request) 
    {
        //dd($request->all());
        //ブログでデータを受け取る
        $inputs = $request->all();

        //トランザクション処理
        \DB::beginTransaction();
        try{
            //ブログ投稿
            Blog::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        
        \Session::flash('err_msg','ブログを登録しました');
        return redirect(route('blogs'));
    }

    //ブログ編集フォームを表示
    public function showEdit($id)
    {
      $blog = Blog::find($id);

        //dd($blogs);
      if(is_null($blog)){
        \Session::flash('err_msg','データがありません');
        return redirect(route('blogs'));
      }

      //return view('blog.detail',['blogs'=> $blog]);
      return view('blog.edit')->with('blog', $blog);
    }

    //blogの更新
    public function exeUpdate(BlogRequest $request) 
    {
        //dd($request->all());
        //ブログのデータを受け取る
        $inputs = $request->all();

        //トランザクション処理
        \DB::beginTransaction();
        try{
            //ブログ投稿
            $blog = Blog::find($inputs['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content'],
            ]);
            $blog->save();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        
        \Session::flash('err_msg','ブログを登録しました');
        return redirect(route('blogs'));
    }

    //ブログ削除
    public function exeDelete($id)
    {
        if (empty($id)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }

        try {
            Blog::destroy($id);
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        return redirect(route('blogs'));
    }
}
