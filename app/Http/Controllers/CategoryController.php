<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id)
    {
        if ($id > 0){
            $category = Category::findOrFail($id);
            $posts = Post::where('category_id', $id)->with('user', 'category')->recent()->paginate(15);
            return view('categories.show', compact('category', 'posts'));
        } else if ($id == 0){
            $posts = Post::with('user', 'category')->recent()->paginate(15);
            $category = new Category();
            $category->id = 0;
            return view('categories.show', compact('category', 'posts'));
        } else if ($id == -1){
            $posts = Post::recent()->paginate(15);
            $category = new Category();
            $category->id = -1;
            return view('categories.show', compact('category', 'posts'));
        }

//		$posts = Post::where('category_id', $id)->with('user', 'category')->recent()->get();


    }
}
