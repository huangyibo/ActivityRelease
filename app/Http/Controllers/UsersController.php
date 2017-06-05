<?php namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;

use Cache;
use Auth;
use Flash;
use App\Jobs\SendActivateMail;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;

class UsersController extends Controller
{
    public function __construct()
    {

    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = Post::where('user_id', $id)->with('user', 'category')->recent()->get();

        return view('users.show', compact('user', 'posts'));
    }

    public function update($id, StoreUserRequest $request)
    {
        if ($request->ajax()) {
            $user = User::findOrFail($id);
            $data = $request->all();
            $gender = $data['gender'];
            if ($gender && $gender!='' && $gender != $user->gender){
                $user->gender = $gender;
            }
            $real_name = trim($data['real_name']);
            if ($real_name && $real_name!='' && $real_name!=$user->real_name){
                $user->real_name = $real_name;
            }
            $company = trim($data['company']);
            if ($company && $company!='' && $company!=$user->company){
                $user->company = $company;
            }
            $weibo_id = trim($data['weibo_id']);
            if ($weibo_id && $weibo_id!='' && $weibo_id!=$user->weibo_id){
                $user->weibo_id = $weibo_id;
            }
            $personal_website = trim($data['personal_website']);
            if ($personal_website && $personal_website!='' && $personal_website!=$user->personal_website){
                $user->personal_website = $personal_website;
            }
            $introduction = trim($data['introduction']);
            if ($introduction && $introduction!='' && $introduction!=$user->introduction){
                $user->introduction = $introduction;
            }
            $user->save();
            return response()->json($user);
        }
    }

    public function edit($id)
    {
        $currentUser = User::findOrFail($id);
        return view('users.edit', compact('currentUser'));
    }

    public function edit_avatar($id)
    {
        $currentUser = User::findOrFail($id);
        return view('users.edit_avatar', compact('currentUser'));
    }

    public function edit_email_notify($id)
    {

        return view('users.edit_email_notify');
    }

    public function edit_social_binding($id)
    {
        return view('users.edit_social_binding');
    }

    public function update_avatar($id)
    {
        $currentUser = User::findOrFail($id);
        $file = Input::file('avatar');
        $currentUser->updateAvatar($file);
        return redirect()->back();
    }

    public function edit_password($id)
    {
        return view('users.edit_password');
    }

    public function update_password($id, UpdatePasswordRequest $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });


        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect(route('users.edit_password', [$id]));
            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }

    }

    public function test()
    {
        return view('test');
    }

    public function userReleasedPosts($id)
    {
        $user = User::findOrFail($id);
        $posts = Post::where('user_id', $id)->orderBy('created_at', 'DESC')->simplePaginate(20);
        return view('users.user_center', compact('user', 'posts'));
    }

    public function postDetailsList($id)
    {
        $user = User::findOrFail($id);
        $posts = User::postsByUserId($id, 10);
//        $posts_with_apply_templates = array();
        foreach ($posts as $post){
            $applyTemplates = Post::applyTemplatesByPostId($post->id);
            $post->apply_templates = $applyTemplates;
//            $posts_with_apply_templates[] = $post;
        }
//        $posts = $posts_with_apply_templates;
        return view('users.user_center', compact('user', 'posts'));
    }

}
