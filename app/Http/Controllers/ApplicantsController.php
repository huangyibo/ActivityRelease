<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 2017/3/24
 * Time: 23:52
 */

namespace App\Http\Controllers;

use App\Models\ApplicantDetail;
use App\Models\ApplicantPhase;
use App\Models\ApplyTemplate;
use App\Models\Post;
use App\Models\Applicant;
use Auth;
use Validator;
use Mail;

use App\Http\Requests\StoreApplicantRequest;

class ApplicantsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['store']]);
    }

    public function store(StoreApplicantRequest $request)
    {

        /*$validator = Validator::make($request->all(), []);

        // 验证邮箱是否已报名该post_id活动
        $email = $data['email'];
        $applicant = Applicant::where('post_id', $data['post_id'])->where('email', $email)->first();
        if ($applicant){
            $validator->errors()->add('email', 'Email邮箱已报名该活动！');
            return $validator->errors()->all();
        }

        // 验证phone手机号是否已报名该post_id活动
        $applicant = Applicant::where('post_id', $data['post_id'])->where('phone', $data['phone'])->first();
        if ($applicant){
            $validator->errors()->add('phone', '您的手机号已报名该活动！');
            return $validator->errors()->all();
        }*/
        $data = $request->only('post_id', 'post_phases', 'apply_attrs');
        $applicant = $this->insertApplicants($data);
        $applicant_phases = $this->insertSelectedPostPhases($data, $applicant->id);
        $applicant_details = $this->insertApplicantDetails($data, $applicant->id);

        $applyTemplates = $this->getApplyTemplatesWithAttrsByPostId($data['post_id']);
        $applyAttr = $this->parseEmailFromData($data);
        if (!is_null($applyAttr)){
            $postPhases = Post::postPhasesByPostId($data['post_id']);
            $post = Post::findOrFail($data['post_id']);

            $applicantDetails = Applicant::applicantDetailsByApplicantId($applicant->id);
            $result = ApplicantDetail::transformHashIndex($applicantDetails);
            $applicant->applicant_details = $result;
            $applicantPhases = Applicant::applicantPhasesByApplicantId($applicant->id);
            $applicant->applicant_phases = $applicantPhases;

            $email = $applyAttr->apply_attr_value;
            $flag = Mail::send('emails.post_apply_success',
                ['post' => $post, 'applicant' => $applicant, 'applicantPhases' => $applicant_phases,
                    'applicantDetails' => $applicant_details, 'applyTemplates' =>$applyTemplates,
                    'postPhases' => $postPhases ],
                function ($message) use ($post, $email) {
                    $to = $email;
                    $message->to($to)->subject('[活动发布平台]您已成功报名 ' . $post->title . '!');
                });
            $response = array('status' => 'ok', 'applicant' => $applicant,
                'applyTemplates' => $applyTemplates,
                'postPhases' => $postPhases,
                'flag' => $flag);
            return response()->json($response);
        }else{
            $response = array('status' => 'ok', 'applicant' => $applicant,
                'applicant_phases' => $applicant_phases,
                'applicant_details' => $applicant_details);
            return response()->json($response);
        }

//        $this->sendMail($applicant, $post);
//        return redirect()->back()->withInput(['apply_status' => true]);
    }

    public function listByPostId($post_id)
    {
        $user = Auth::user();
        $post = Post::where('id', $post_id)->with('user', 'category')->first();
        $applicants = $this->getApplicantsWithDetailsAndPhasesByPostId($post_id);
        $applyTemplates = $this->getApplyTemplatesWithAttrsByPostId($post_id);
        $postPhases = Post::postPhasesByPostId($post_id);
//        $applicantDetails = Post::applicantsByPostId($post_id, 30);

        return view('users.user_center',
            compact('applicants', 'post', 'user', 'applyTemplates', 'postPhases'));
    }

    private function sendMail(Applicant $applicant, Post $post)
    {
        $flag = Mail::send('emails.post_apply_success',
            ['applicant' => $applicant, 'post' => $post],
            function ($message) use ($applicant, $post) {
                $message->to($applicant->email)->subject('[活动发布平台]您已成功报名 ' . $post->title . '!');
            });
        return $flag;
    }

    private function insertApplicants($data)
    {
        $applicant = new Applicant;
        $applicant->post_id = $data['post_id'];
        $applicant->save();
        $post = Post::where('id', $data['post_id'])->first();
        $apply_num = $post->apply_num + 1;
        $post->update(['apply_num' => $apply_num]);
        return $applicant;
    }

    private function insertSelectedPostPhases($data, $applicant_id)
    {
        $applicant_phases = $this->parsePostPhasesFromData($data, $applicant_id);
        if (!is_null($applicant_phases)) {
            $applicant_phases = ApplicantPhase::batchInsert($applicant_phases);
        }
        return $applicant_phases;
    }

    private function insertApplicantDetails($data, $applicant_id)
    {
        $applicant_details = $this->parseApplyAttrsFromData($data, $applicant_id);
        if (!is_null($applicant_details)) {
            $applicant_details = ApplicantDetail::batchInsert($applicant_details);
        }
        return $applicant_details;
    }

    private function parsePostPhasesFromData($data, $applicant_id)
    {
        if (isset($data) && isset($data['post_phases'])
            && count($data['post_phases']) > 0
        ) {
            $post_phases = json_decode($data['post_phases'], true);
            $applicantPhases = array();
            foreach ($post_phases as $post_phase) {
                $applicantPhase = new ApplicantPhase;
                $applicantPhase->applicant_id = $applicant_id;
                $applicantPhase->post_phase_id = $post_phase['id'];
                $applicantPhases[] = $applicantPhase;
            }
            return $applicantPhases;
        }
        return null;
    }

    private function parseApplyAttrsFromData($data, $applicant_id)
    {
        if (isset($data) && isset($data['apply_attrs'])
            && count($data['apply_attrs']) > 0
        ) {
            $apply_attrs = json_decode($data['apply_attrs'], true);
            $applicantDetails = array();
            foreach ($apply_attrs as $apply_attr) {
                $applicantDetail = new ApplicantDetail;
                $applicantDetail->applicant_id = $applicant_id;
                $applicantDetail->apply_attr_id = $apply_attr['id'];
                $applicantDetail->apply_attr_value = $apply_attr['value'];
                $applicantDetails[] = $applicantDetail;
            }
            return $applicantDetails;
        }
        return null;
    }

    private function getApplicantsWithDetailsAndPhasesByPostId($post_id)
    {
        $applicants = Post::applicantsByPostId($post_id, 20);
//        $applicantsWithDetails = array();
        foreach ($applicants as $applicant) {
            $applicantDetails = Applicant::applicantDetailsByApplicantId($applicant->id);
            $result = ApplicantDetail::transformHashIndex($applicantDetails);
            $applicant->applicant_details = $result;

            $applicantPhases = Applicant::applicantPhasesByApplicantId($applicant->id);
            $applicant->applicant_phases = $applicantPhases;
//            $applicantsWithDetails[] = $applicant;
        }
        return $applicants;
    }

    private function getApplyTemplatesWithAttrsByPostId($post_id)
    {
        $applyTemplates = Post::applyTemplatesByPostId($post_id);
        return $applyTemplates;
    }

    private function parseEmailFromData($data){
        if (isset($data) && isset($data['apply_attrs'])
            && count($data['apply_attrs']) > 0
        ) {
            $apply_attrs = json_decode($data['apply_attrs'], true);
            foreach ($apply_attrs as $apply_attr) {
                if ($apply_attr['name'] == 'email'){
                    $applicantDetail = new ApplicantDetail;
                    $applicantDetail->apply_attr_id = $apply_attr['id'];
                    $applicantDetail->apply_attr_value = $apply_attr['value'];
                    return $applicantDetail;
                }
            }
            return null;
        }
        return null;
    }

}