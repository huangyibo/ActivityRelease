<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ApplicantPhase;
use App\Models\Issue;
use App\Models\Post;
use App\Models\PostPhase;
use Illuminate\Http\Request;

use Auth;

class PostPhaseController extends Controller
{

    public function destroy($id)
    {
	    $postPhase = PostPhase::where('id', $id)->first();
	    if (isset($postPhase)){
            ApplicantPhase::where('post_phase_id', $id)->delete();
            PostPhase::destroy($id);
        }
        $response = array('status' => 'ok');
	    return response()->json($response);
    }
}
