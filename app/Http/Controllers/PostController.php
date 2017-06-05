<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Applicant;
use App\Models\ApplyAttr;
use App\Models\ApplyTemplate;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostPhase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Auth;
use Input;
use Image;
use Validator;

use App\Http\Requests\StorePostRequest;

//use League\HTMLToMarkdown\HtmlConverter;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function create(Request $request)
    {
        $category = Category::find($request->input('category_id'));
        $categories = Category::all();
        $applyAttrs = ApplyAttr::all();

        return view('posts.create_edit_modified', compact('categories', 'category', 'applyAttrs'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->only('title', 'body_original', 'category_id', 'cover', 'excerpt', 'post_phases', 'apply_templates');
        $data['user_id'] = Auth::id();

        // 如果不是http image url, 上传图片
        $cover = $data['cover'];
        if (!is_http_url($cover)) {
            $file = Input::file('cover_image');
            if ($file) {
                $cover = $this->uploadImage($file);
                $data['cover'] = $cover;
            }
        }

        $post = $this->insertPost($data);
        $post_phases = $this->insertPostPhases($data, $post->id);
        $apply_templates = $this->insertApplyTemplates($data, $post->id);
        /*$post = $this->parsePostFromData($data);
        $post_phases = $this->parsePostPhasesFromData($data, 540);
        $apply_templates =$this->parseApplyTemplateFromData($data, 540);*/

        $response = array('status' => 'ok', 'post' => $post,
            'post_phases' => $post_phases, 'apply_templates' => $apply_templates);
        return response()->json($response);
//        return redirect(route('posts.show', $post->id));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $category = $post->category;
        $applyAttrs = ApplyAttr::all();
        $applyTemplates = Post::applyTemplatesByPostId($id);
        $postPhases = Post::postPhasesByPostId($id);

        return view('posts.create_edit_modified',
            compact('post', 'postPhases', 'categories', 'category', 'applyAttrs', 'applyTemplates'));
    }

    public function update($id, StorePostRequest $request)
    {
        $post = Post::findOrFail($id);
        $file = Input::file('cover_image');
        $data = $request->only('title', 'body_original', 'cover', 'category_id', 'excerpt');
        if ($file) {
            $cover = $this->uploadImage($file);
            $data['cover'] = $cover;
            $post->update($data);
        } else {
            $cover = $data['cover'];
            if (strpos($cover, 'http') !== false && $cover !== $post->cover) {
                $post->update($data);
            } else {
                $post->update($request->only('title', 'body_original', 'category_id', 'excerpt'));
            }
        }

        $data = $request->all();
        $post_phases = $this->updatePostPhases($data, $post->id);
        $apply_templates = $this->updateApplyTemplates($data, $post->id);
        $response = array('status' => 'ok', 'post' => $post,
            'post_phases' => $post_phases, 'apply_templates' => $apply_templates);

        return response()->json($response);
//        return redirect(route('posts.show', $post->id));
    }

    public function index()
    {
        $posts = Post::recent()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::where('id', $id)->with('user', 'category')->first();
        $posts = Post::recent()->paginate(3);
        $post_applicants_counts = Applicant::where('post_id', $id)->count();
        $applyTemplates = ApplyTemplate::listApplyTemplatesByPostId($id);
        $postPhases = PostPhase::listPostPhasesByPostId($id);

        return view('posts.show',
            compact('post', 'posts', 'post_applicants_counts', 'applyTemplates', 'postPhases'));
    }

    public function uploadCover()
    {
        $file = Input::file('cover_image');
        $input = array('cover_image' => $file);
        $rules = array('cover_image' => 'image');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $destinationPath = 'uploads/covers';
        $filename = time() . $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension() ?: 'png';
        $file->move($destinationPath, $filename);
        Image::make($destinationPath . $filename)->resize(1024, 546)->save();

        return Response::json(
            [
                'success' => true,
                'cover' => $destinationPath . $filename
            ]
        );
    }

    /*public function postsApplicantsList($user_id)
    {
        $posts = Post::where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(20);

        return view('posts.posts_applicants_list',compact( 'posts'));
    }*/

    private function uploadImage($file)
    {
        $input = array('cover_image' => $file);
        $rules = array('cover_image' => 'image');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $destinationPath = 'uploads/covers/';
        //. '.' . $file->getClientOriginalExtension()
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        Image::make($destinationPath . $filename)->resize(1024, 546)->save();
        return '/' . $destinationPath . '/' . $filename;
    }

    private function ajaxStore(StorePostRequest $request)
    {
        $post = json_decode($request->getContent(), true);
        $result = $this->invalidateStorePost($post);
        if (!$result['status']) {
            return response()->json($result);
        }

    }

    private function formDataStore(StorePostRequest $request)
    {
        $data = $request->only('title', 'body_original', 'category_id', 'cover', 'excerpt');
        $data['user_id'] = Auth::id();

        $file = Input::file('cover_image');
        if ($file) {
            $cover = $this->uploadImage($file);
            $data['cover'] = $cover;
        }
        $post = Post::create($data);
        return redirect(route('posts.show', $post->id));
    }

    private function invalidateStorePost($data)
    {
        $status = true;
        if (is_null($data['category_id'])) {
            $status = false;
            $result['category_id'] = ['The category id field is required.'];
        }
        if (is_null($data['title'])) {
            $status = false;
            $result['title'] = ['The title field is required.'];
        }
        if (is_null($data['excerpt'])) {
            $status = false;
            $result['excerpt'] = ['The excerpt field is required.'];
        }
        if (is_null($data['body_original'])) {
            $status = false;
            $result['body_original'] = ['The body original field is required.'];
        }
        $result['status'] = $status;
        if ($status) {
            $result['msg'] = 'Submit Post Successfully!';
        }
        return $result;
    }

    private function parsePostFromData($data)
    {
        if (isset($data)) {
            $post = new Post;
            $post->user_id = $data['user_id'];
            $post->title = $data['title'];
            $post->body_original = $data['body_original'];
            $post->category_id = $data['category_id'];
            $post->cover = $data['cover'];
            $post->excerpt = $data['excerpt'];

            return $post;
        }
        return null;
    }

    private function parseApplyTemplateFromData($data, $post_id)
    {
        if (isset($data) && isset($data['apply_templates'])
            && count($data['apply_templates']) > 0
        ) {
            $apply_templates = array();
            $apply_attrs = json_decode($data['apply_templates'], true);
            foreach ($apply_attrs as $apply_attr) {
                $apply_template = new ApplyTemplate;
                $apply_template->apply_attr_id = $apply_attr['id'];
                $apply_template->is_required = true;
                $apply_template->post_id = $post_id;

                $apply_templates[] = $apply_template;
            }
            return $apply_templates;
        }
        return null;
    }

    private function parsePostPhasesFromData($data, $post_id)
    {
        if (isset($data) && isset($data['post_phases'])
            && count($data['post_phases']) > 0
        ) {
            $post_phases = $data['post_phases'];
            $post_phases = json_decode($post_phases, true);
            $post_phases_data = array();
            foreach ($post_phases as $value) {
                if (isset($value['id'])) {
                    $post_phase = PostPhase::find($value['id']);
                    $post_phase->post_id = $post_id;
                    $post_phase->serial_num = $value['serial_num'];
                    $post_phase->phase_name = $value['phase_name'];
                    $post_phase->register_limit = $value['register_limit'];
                    $post_phase->registration_fee = $value['registration_fee'];
                    $post_phase->start_time = $value['start_time'];
                    $post_phase->end_time = $value['end_time'];
                    $post_phase->save();
                    continue;
                }
                $post_phase = new PostPhase;
                $post_phase->post_id = $post_id;
                $post_phase->serial_num = $value['serial_num'];
                $post_phase->phase_name = $value['phase_name'];
                $post_phase->register_limit = $value['register_limit'];
                $post_phase->registration_fee = $value['registration_fee'];
                $post_phase->start_time = $value['start_time'];
                $post_phase->end_time = $value['end_time'];

                $post_phases_data[] = $post_phase;
            }
            return $post_phases_data;
        }
        return null;
    }



    private function insertPost($data)
    {
        $post = $this->parsePostFromData($data);
        $post->save();
        return $post;
    }

    private function insertPostPhases($data, $post_id)
    {
        $post_phases_data = $this->parsePostPhasesFromData($data, $post_id);
        if (!is_null($post_phases_data)) {
            $post_phases = PostPhase::batchInsert($post_phases_data);
        }
        return $post_phases;
    }

    private function insertApplyTemplates($data, $post_id)
    {
        $apply_templates_data = $this->parseApplyTemplateFromData($data, $post_id);
        $apply_templates = ApplyTemplate::batchInsert($apply_templates_data);
        return $apply_templates;
    }

    private function parseApplyTemplateFromDataForUpdate($data, $post_id)
    {
        if (isset($data) && isset($data['apply_templates'])) {
            $apply_templates_data = json_decode($data['apply_templates'], true);
            $addApplyAttrs = $apply_templates_data['addApplyAttrs'];
            $deleteApplyTemplates = $apply_templates_data['deleteApplyTemplates'];
            $newApplyTemplates = array();
            $existedApplyTemplateIds = array();
            if (count($addApplyAttrs) > 0) {
                foreach ($addApplyAttrs as $applyAttr) {
                    $applyTemplate = new ApplyTemplate;
                    $applyTemplate->apply_attr_id = $applyAttr['id'];
                    $applyTemplate->is_required = true;
                    $applyTemplate->post_id = $post_id;

                    $newApplyTemplates[] = $applyTemplate;
                }
            }
            if (count($deleteApplyTemplates) > 0) {
                foreach ($deleteApplyTemplates as $applyTemplate) {
                    $existedApplyTemplateIds[] = $applyTemplate['id'];
                }
            }
            return array('newApplyTemplates' => $newApplyTemplates,
                'existedApplyTemplateIds' => $existedApplyTemplateIds);

        }
        return null;
    }

    private function updatePostPhases($data, $post_id)
    {
        $post_phases_data = $this->parsePostPhasesFromData($data, $post_id);
        if (!is_null($post_phases_data)) {
            $post_phases = PostPhase::batchInsert($post_phases_data);
        }
        return $post_phases;
    }

    private function updateApplyTemplates($data, $post_id)
    {
        $apply_templates_data = $this->parseApplyTemplateFromDataForUpdate($data, $post_id);
        $apply_templates = ApplyTemplate::batchInsert($apply_templates_data['newApplyTemplates']);
        ApplyTemplate::destroy($apply_templates_data['existedApplyTemplateIds']);
        return $apply_templates;
    }

}
