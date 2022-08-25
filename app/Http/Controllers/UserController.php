<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Portfolio;
use App\Models\Skill;
use App\Models\Certification;
use App\Models\OnlineLink;
use App\Models\Language;
use App\Models\ProSkill;
use App\Models\OtherSkill;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Profession;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

         //validate credentials
         $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        try 
        {
        
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }

            return $this->createNewToken($token);
        
        } 
        catch (JWTException $e) 
        {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

    }


        public function register(Request $request)
        {
            $credentials = $request->only('email', 'password');
            
            //validate credentials
            $validator = Validator::make($credentials, [
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6|max:50'
            ]);

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 400);
            }

            $user_id = time();

            $user = User::create([
                    'user_id' => $user_id,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
            ]);


            return response()->json(compact('user'),201);


        }

        public function userdetails(Request $request)
        {
            // $user_details = DB::table('users')->where('users.user_id', auth()->user()->user_id)
            // ->leftJoin('educations', 'users.user_id', '=', 'educations.user_id')
            // // ->join('orders', 'users.id', '=', 'orders.user_id')
            // ->select('users.*', 'educations.*')
            // ->get();

            $user_details = User::where('user_id', auth()->user()->user_id)->first();

            return response()->json(compact('user_details'));
        }

        public function profile($user_id)
        {
            $user_details = User::where('user_id', $user_id)->first();

            if(is_null($user_details)) return response()->json(['errors' => 'User does not exist'], 404);

            $educations = Education::where('user_id', $user_id)->orderBy('id', 'DESC')->get();
            $certifications = Certification::where('user_id', $user_id)->orderBy('id', 'DESC')->get();
            $experiences = Experience::where('user_id', $user_id)->orderBy('id', 'DESC')->get();
            $portfolios = Portfolio::where('user_id', $user_id)->get();
            $proskills = ProSkill::where('user_id', $user_id)->get();
            $otherskills = OtherSkill::where('user_id', $user_id)->get();
            $onlinelinks = OnlineLink::where('user_id', $user_id)->orderBy('id', 'DESC')->get();

            return response()->json([
                'bio' => $user_details, 
                'certifications' => $certifications,
                'resumes' => $experiences,
                'educations' => $educations,
                'portfolios' => $portfolios,
                'proskills' => $proskills,
                'otherskills' => $otherskills,
                'social_links' => $onlinelinks

            ]);

        }

        public function updatebio(Request $request)
        {

            $data = [

                'gender' => $request->gender,
                'marital_status' => $request->marital_status,	
                'disabled' => $request->disabled,
                'educational_qualification' => $request->educational_qualification,	
                'other_professions1' => $request->other_professions1,
                'other_professions2' => $request->other_professions2,	
                'other_professions3' => $request->other_professions3,
                'other_professions4' => $request->other_professions4,	
                'languages1' => $request->languages1,
                'languages2' => $request->languages2,	
                'languages3' => $request->languages3,
                'languages4' => $request->languages4,	
                'languages5' => $request->languages5,
                'current_employer' => $request->current_employer,	
                'state' => $request->state,
                'lga' => $request->lga,	
                'employment_type' => $request->employment_type,
                'preferred_job' => $request->preferred_job,	
                'preferred_job_location_state' => $request->preferred_job_location_state,	
                'preferred_job_location_lga' => $request->preferred_job_location_lga,
                'availability_start_date' => $request->availability_start_date,
            ];
    
    
            $updated = User::where('user_id', auth()->user()->user_id)->update($data);

            return response()->json(compact('updated'));
        }

        public function profilesetup(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'date_format:Y-m-d'
            ]);
    
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()->getMessages()], 400);
            }
           
            $user_details = User::where('profile_id', strtolower($request->first_name. '.' . $request->last_name))->first();
            if(empty($user_details))
            {
                $profile_id = strtolower($request->first_name. '.' . $request->last_name);
    
            }
            else
            {
                //user ID already exists. Add 1 to it
                $id2 = $user_details['id'] + 3;
                $profile_id = $user_details['profile_id']. '.' . $id2;
                
            }

            $languages = $request->languages;

            $other_professions = $request->other_professions;

            // if(count($extracted_languages2) > 5) return response()->json(['errors' => 'Languages limit exceeded']);
            
            // if(count($extracted_other_professions2) > 4) return response()->json(['errors' => 'Other professions limit exceeded']);
            if ($request->hasFile('profilepic')) 
            {
                $file = $request->file('profilepic');
                $profilepic_name = time().uniqid().'.'.$request->profilepic->extension();
                $file->storeAs('userprofilepics', $profilepic_name, 's3');
           

                $data = [

                    'first_name'  => $request->first_name,
                    'last_name'  => $request->last_name,
                    'profile_id'  => $profile_id,
                    'phone'  => $request->user_phonenum,
                    'email_profile_setup'  => $request->user_email,
                    'marital_status' => $request->marital_status,	
                    'profession'  => $request->profession,
                    'employment_type'  => $request->employment_type,
                    'employment_status'  => $request->employment_status,
                    'educational_qualification'  => $request->educational_qualification,
                    'gender' => $request->gender,
                    'age_range' => $request->age_range,
                    'disabled' => $request->disabled,
                    'disability_details' => $request->disability_details,
                    'current_employer' => $request->current_employer,
                    'employers_address' => $request->employers_address,
                    'languages1' => $languages,
                    'other_professions1' => $other_professions,
                    'state'  => $request->selectedState,
                    'lga'  => $request->selectedLGA,
                    'preferred_job_location_state'  => $request->selectedState2,
                    'preferred_job_location_lga'  => $request->selectedLGA2,
                    'about' => $request->about,
                    'website' => $request->website,
                    'active'  => 1,
                    'profile_image' => $profilepic_name,
        
                    ];

            }
            else
            {
                $data = [

                    'first_name'  => $request->first_name,
                    'last_name'  => $request->last_name,
                    'profile_id'  => $profile_id,
                    'phone'  => $request->user_phonenum,
                    'email_profile_setup'  => $request->user_email,
                    'marital_status' => $request->marital_status,	
                    'profession'  => $request->profession,
                    'employment_type'  => $request->employment_type,
                    'employment_status'  => $request->employment_status,
                    'educational_qualification'  => $request->educational_qualification,
                    'gender' => $request->gender,
                    'age_range' => $request->age_range,
                    'disabled' => $request->disabled,
                    'disability_details' => $request->disability_details,
                    'current_employer' => $request->current_employer,
                    'employers_address' => $request->employers_address,
                    'languages1' => $languages,
                    'other_professions1' => $other_professions,
                    'state'  => $request->selectedState,
                    'lga'  => $request->selectedLGA,
                    'preferred_job_location_state'  => $request->selectedState2,
                    'preferred_job_location_lga'  => $request->selectedLGA2,
                    'about' => $request->about,
                    'website' => $request->website,
                    'active'  => 1,
        
                    ];
            }

            $updated = User::where('user_id', auth()->user()->user_id)->update($data);

            if($updated > 0)
            {
                return response()->json([
                    "success" => true,
                    "message" => "Profile updated successfully",
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "Error occurred",
            ]);

        }

        public function changeprofilepic(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'profilepic'        =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()->getMessages()], 400);
            }

            if ($request->hasFile('profilepic')) 
            {

                $file = $request->file('profilepic');
                $profilepic_name = time().uniqid().'.'.$request->profilepic->extension();
                $file->storeAs('userprofilepics', $profilepic_name, 's3');
    
                
                $data = [
                
                    'profile_image' => $profilepic_name,
                ];
    
            $uploaded = User::where('user_id', auth()->user()->user_id)->update($data);
    
                return response()->json([
                    "success" => true,
                    "message" => "Profile Image successfully uploaded",
                ]);
            }
        }

        public function changecoverimage(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'coverimage'        =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()->getMessages()], 400);
            }

            if ($request->hasFile('coverimage')) 
            {

                $file = $request->file('coverimage');
                $coverimage_name = time().uniqid().'.'.$request->coverimage->extension();
                $file->storeAs('usercoverimages', $coverimage_name, 's3');
    
                
                $data = [
                
                    'cover_image' => $coverimage_name,
                ];
    
            $uploaded = User::where('user_id', auth()->user()->user_id)->update($data);
    
                return response()->json([
                    "success" => true,
                    "message" => "Cover Image successfully uploaded",
                ]);
            }
        }

        public function searchprofessions($term)
        {
        
            $professions = Profession::where('name','LIKE','%'.$term.'%')->select('name')->where('parent_id', '!=', 0)->orderBy('name', 'ASC')->get();
    
            return response()->json($professions);

        }

        public function getrelatedprofessions($term)
        {
        
            $profession = Profession::where('name', $term)->select('parent_id', 'id')->where('parent_id', '!=', 0)->orderBy('name', 'ASC')->first();

            $related_professions = Profession::where('parent_id', $profession->parent_id)->where('id', '!=', $profession->id)->select('name')->orderBy('name', 'ASC')->get();
    
            return response()->json($related_professions);

        }


        public function professions()
        {
        
            $professions = Profession::select('name')->orderBy('name', 'ASC')->get();
            return response()->json($professions);

        }

        public function languages()
        {
            $languages = Language::all();
            return response()->json($languages);
        }

        public function addfollower(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'following' => 'required'
            ]);
    
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()->getMessages()], 400);
            }

            try 
            {

                $inserted = Follow::create([
                    'follower' => auth()->user()->user_id,
                    'following' => $request->following,
                ]);
    
                return response()->json(['status' => true, 'message' => 'Followed successfully']);
            
            } 
            catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                  // we have a duplicate entry problem
                  return response()->json(['status' => false, 'message' => 'Already followed']);
                }
            }

        }

        public function deletefollowing(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'following' => 'required'
            ]);
    
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()->getMessages()], 400);
            }
        
            $deleted = Follow::where('following', $request->following)->where('follower', auth()->user()->user_id)->delete();

            if($deleted > 0)
            {
                return response()->json(['status' => true, 'message' => 'Unfollow deleted successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred']);
       
        }

        public function followers($user_id)
        {
            $followers = Follow::where('following', $user_id)->select('follower')->get();
            return response()->json($followers);
        }

        public function usersearch($name)
        {
            $search_results = User::where('first_name','LIKE','%'.$name.'%')->orWhere('last_name','LIKE','%'.$name.'%')->get();
            return response()->json($search_results);
        }
    
        protected function createNewToken($token){
            return response()->json([
                'access_token' => $token,
                // 'token_type' => 'bearer',
                // 'expires_in' => auth()->factory()->getTTL() * 60 * 60 * 60,
                'active' => auth()->user()->active,
                'user_id' => auth()->user()->user_id
            ]);
        }

}
