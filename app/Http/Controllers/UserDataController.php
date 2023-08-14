<?php

namespace App\Http\Controllers;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Portfolio;
use App\Models\Document;
use App\Models\Team;
use App\Models\User;
use App\Models\UserJob;
use App\Models\ProSkill;
use App\Models\OtherSkill;
use App\Models\OnlineLink;
use App\Models\Certification;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use JWTAuth;

class UserDataController extends Controller
{

    public function addexperience(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'start_day' => 'required',
            // 'end_day' => 'required',
            'start' => 'required|date_format:Y-m-d',
            'end' => 'date_format:Y-m-d',
            'company_name' => 'required',
            'role' => 'required',
            'responsibities' => 'required',
            'is_current' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        // $start_day = 01;
		// $end_day = 01;
		// $start_month = $request->start_month;
		// $start_year = $request->start_year;
		// $end_month = $request->end_month;
		// $end_year = $request->end_year;

		// $start_duration = $start_year . '-' . $start_month . '-' . $start_day;
		// $end_duration = $end_year . '-' . $end_month . '-' . $end_day;
	 	// $start_DT = date('Y-m-d', strtotime("$start_duration"));
        $start_DT = date('Y-m-d', strtotime("$request->start"));
        if($request->is_current == true)
        {
            $end_DT = null;
        }
        else
        {
            $end_DT = date('Y-m-d', strtotime("$request->end"));
        }
        $role = $request->role;

        // $extracted_roles2 = json_decode($roles, true);

        // $extracted_roles = implode(',', array_map(function ($entry) {
        //     return $entry['role_name'];
        //   }, $extracted_roles2));

        $experience_id = 'EXP' . time();

        $experience = Experience::create([
            'user_id' => auth()->user()->user_id,
            'experience_id' => $experience_id,
            'start' => $start_DT,
            'end' => $end_DT,
            'company_name' => $request->company_name,
            'position' => $request->role,
            'roles' => $request->responsibities,
            'is_current' => $request->is_current
            
        ]);

  
        return response()->json(['status' => true, 'message' => 'Resume created successfully']);
       
    }

    public function updateexperience(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'start_day' => 'required',
            // 'end_day' => 'required',
            'start' => 'required|date_format:Y-m-d',
            'end' => 'date_format:Y-m-d',
            'company_name' => 'required',
            'role' => 'required',
            'responsibities' => 'required',
            'is_current' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

	 	$start_DT = date('Y-m-d', strtotime("$request->start"));
		$end_DT = date('Y-m-d', strtotime("$request->end"));

		
        // if(!empty($request->roles))
        // {

        //     $roles = $request->roles;

        //     $extracted_roles2 = json_decode($roles, true);

        //     $extracted_roles = implode(',', array_map(function ($entry) {
        //         return $entry['role_name'];
        //     }, $extracted_roles2));
   
        // }

        // if(!empty($request->roles))
        // {
        //     $data = [
        //         'roles' => $extracted_roles,   
        //     ];
        // }

        $data = [
            'start' => $start_DT,
            'end' => $end_DT,
            'company_name' => $request->company_name,
            'position' => $request->role,
            'roles' => $request->responsibities,
            'is_current' => $request->is_current
        ];

        $updated = Experience::where('experience_id', $id)->update($data);

  
        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Experience updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function deleteexperience(Request $request)
    {
        

        $deleted = Experience::where('experience_id', $request->id)->delete();

        // return response()->json(compact('deleted'));

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Experience deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }


    public function experience($id)
    {
        $experience = Experience::where('user_id', auth()->user()->user_id)->where('experience_id', $id)->orderBy('id', 'DESC')->first();
        return response()->json(compact('experience'));
    }


    public function experiences()
    {
        $experiences = Experience::where('user_id', auth()->user()->user_id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('experiences'));
    }

    public function addeducation(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'start_day' => 'required',
            // 'end_day' => 'required',
            'start' => 'required|date_format:Y-m-d',
            'end' => 'date_format:Y-m-d',
            'school' => 'required',
            'class_of_degree' => 'required',
            'is_current' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        // $start_day = 01;
		// $end_day = 01;
		// $start_month = $request->start_month;
		// $start_year = $request->start_year;
		// $end_month = $request->end_month;
		// $end_year = $request->end_year;

		// $start_duration = $start_year . '-' . $start_month . '-' . $start_day;
		// $end_duration = $end_year . '-' . $end_month . '-' . $end_day;
	 	$start_DT = date('Y-m-d', strtotime("$request->start"));
        if($request->is_current == true)
        {
            $end_DT = null;
        }
        else
        {
            $end_DT = date('Y-m-d', strtotime("$request->end"));
        }

		
        // $skills = $request->skills;

        // $extracted_skills2 = json_decode($skills, true);

        // $extracted_skills = implode(',', array_map(function ($entry) {
        //     return $entry['skill_name'];
        //   }, $extracted_skills2));



        $education_id = 'EDU' . time();

        $education = Education::create([
            'user_id' => auth()->user()->user_id,
            'education_id' => $education_id,
            'start' => $start_DT,
            'end' => $end_DT,
            'school' => $request->school,
             'course' => $request->course,
            'class_of_degree' => $request->class_of_degree,
            'is_current' => $request->is_current
            //'skills' => $extracted_skills,
        ]);

  
        return response()->json(['status' => true, 'message' => 'Education created successfully']);
       
    }


    public function updateeducation(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|date_format:Y-m-d',
            'end' => 'date_format:Y-m-d',
            'school' => 'required',
            'course' => 'required',
            'class_of_degree' => 'required',
            'is_current' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }
        
        $start_DT = date('Y-m-d', strtotime("$request->start"));
		$end_DT = date('Y-m-d', strtotime("$request->end"));

	

        $data = [
            'start' => $start_DT,
            'end' => $end_DT,
            'school' => $request->school,
            'course' => $request->course,
            'class_of_degree' => $request->class_of_degree,
            'is_current' => $request->is_current
        ];

        $updated = Education::where('education_id', $id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Education updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function deleteeducation(Request $request)
    {
        

        $deleted = Education::where('education_id', $request->id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Education deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }


    public function education($id)
    {
        $education = Education::where('user_id', auth()->user()->user_id)->where('education_id', $id)->orderBy('id', 'DESC')->first();
        return response()->json(compact('education'));
    }


    public function educations()
    {
        $educations = Education::where('user_id', auth()->user()->user_id)->get();
        if(empty($educations))
        {
            return response()->json(null);
        }
        else
        {
            return response()->json(compact('educations'));
        }
        
    }

    public function addcertification(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'start' => 'required|date_format:Y-m-d',
            'end' => 'date_format:Y-m-d',
            'school' => 'required',
            'course' => 'required',
            'class_of_degree' => 'required',
            'is_current' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        // $start_day = 01;
		// $end_day = 01;
		// $start_month = $request->start_month;
		// $start_year = $request->start_year;
		// $end_month = $request->end_month;
		// $end_year = $request->end_year;

		// $start_duration = $start_year . '-' . $start_month . '-' . $start_day;
		// $end_duration = $end_year . '-' . $end_month . '-' . $end_day;
	 	$start_DT = date('Y-m-d', strtotime("$request->start"));
         if($request->is_current == true)
         {
             $end_DT = null;
         }
         else
         {
             $end_DT = date('Y-m-d', strtotime("$request->end"));
         }

        // $skills = $request->skills;

        // $extracted_skills2 = json_decode($skills, true);

        // $extracted_skills = implode(',', array_map(function ($entry) {
        //     return $entry['skill_name'];
        //   }, $extracted_skills2));



        $certification_id = 'CER' . time();

        $certification = Certification::create([
            'user_id' => auth()->user()->user_id,
            'certification_id' => $certification_id,
            'start' => $start_DT,
            'end' => $end_DT,
            'school' => $request->school,
            'course' => $request->course,
            'class_of_degree' => $request->class_of_degree,
            'is_current' => $request->is_current
        ]);

  
        return response()->json(['status' => true, 'message' => 'Certification created successfully']);
       
    }


    public function updatecertification(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|date_format:Y-m-d',
            'end' => 'date_format:Y-m-d',
            'school' => 'required',
            'course' => 'required',
            'class_of_degree' => 'required',
            'is_current' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

	 	$start_DT = date('Y-m-d', strtotime("$request->start"));
		$end_DT = date('Y-m-d', strtotime("$request->end"));

        $data = [
            'start' => $start_DT,
            'end' => $end_DT,
            'school' => $request->school,
            'course' => $request->course,
            'class_of_degree' => $request->class_of_degree,
            'is_current' => $request->is_current
        ];

        $updated = Certification::where('certification_id', $id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Certification updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function deletecertification(Request $request)
    {
        
        $deleted = Certification::where('certification_id', $request->id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Certification deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function certifications()
    {
        $certifications = Certification::where('user_id', auth()->user()->user_id)->get();

        if(empty($certifications))
        {
            return response()->json(null);
        }
        else
        {
            return response()->json(compact('certifications'));
        }
        
    }

    public function addportfolio(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'portfolio'        =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'portfolio_title' => 'required',
            'year' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }


        if ($request->hasFile('portfolio')) 
        {

            $file = $request->file('portfolio');
            $portfolio_image_name = time().uniqid().'.'.$request->portfolio->extension();
            //$file->storeAs('userportfolios/images', $portfolio_image_name, 's3');
            $file->move(public_path('uploads/users/portfoliosimages'), $portfolio_image_name);
          
            $portfolio = new Portfolio();
            $portfolio->user_id = auth()->user()->user_id;
            $portfolio->portfolio_id = 'POR' . time();
            $portfolio->image = 'uploads/users/portfoliosimages/'.$portfolio_image_name;
            $portfolio->portfolio_title = $request->portfolio_title;
            $portfolio->date = $request->year;
            $portfolio->save();

            return response()->json([
                "success" => true,
                "message" => "Portfolio successfully uploaded",
            ]);
        }
    }


    public function updateportfolio(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_title' => 'required',
            'year' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $data = [
            'portfolio_title' => $request->portfolio_title,
            'date' => $request->year
        ];

        $updated = Portfolio::where('portfolio_id', $id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Portfolio updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }


    public function deleteportfolio(Request $request)
	{	

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'portfolio_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

		$portfolio_name = $request->portfolio_name;
		
		$deleted = Portfolio::where('portfolio_id', $request->id)->delete();
		
		// if($deleted > 0)
		// {
		// 	$PATH = getcwd();
		// 	unlink($PATH .'/public/portfoliopics/'.$image_name);
		// 	$response = [
		// 		'success' => true,
		// 		'data' => 'done',
		// 		'msg' => "Image deleted"
		// 	];
		// }


        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Portfolio deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function portfolios()
    {
        $portfolios = Portfolio::where('user_id', auth()->user()->user_id)->get();
        return response()->json(compact('portfolios'));
    }

    public function adddocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document'        =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document_title' => 'required',
            'year' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        if ($request->hasFile('document')) 
        {
            $file = $request->file('document');
            $document_name = time().uniqid().'.'.$request->document->extension();
            //$file->storeAs('userportfolios/documents', $document_name, 's3');
            $file->move(public_path('uploads/users/portfoliosdocuments'), $document_name);

            $doc = new Document();
            $doc->user_id = auth()->user()->user_id;
            $doc->doc_id = 'DOC' . time();
            $doc->doc = 'uploads/users/portfoliosdocuments/'.$document_name;
            $doc->document_title = $request->document_title;
            $doc->date = $request->year;
            $doc->save();

            return response()->json([
                "success" => true,
                "message" => "Document successfully uploaded",
            ]);
        }
    }

    public function updatedocument(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'document_title' => 'required',
            'year' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $data = [
            'document_title' => $request->document_title,
            'date' => $request->year
        ];

        $updated = Document::where('doc_id', $id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Document updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }


    public function deletedocument(Request $request)
	{	

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'document_name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

		$document_name = $request->document_name;
		
		$deleted = Document::where('doc_id', $request->id)->delete();
		
		// if($deleted > 0)
		// {
		// 	$PATH = getcwd();
		// 	unlink($PATH .'/public/portfoliopics/'.$image_name);
		// 	$response = [
		// 		'success' => true,
		// 		'data' => 'done',
		// 		'msg' => "Image deleted"
		// 	];
		// }

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Document deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function documents()
    {
        $documents = Document::where('user_id', auth()->user()->user_id)->get();
        return response()->json(compact('documents'));
    }

    public function addskill(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'skills' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }
        
        $skills = $request->skills;

        $extracted_skills2 = json_decode($skills, true);

        $extracted_skills = implode(',', array_map(function ($entry) {
            return $entry['skill_name'];
          }, $extracted_skills2));

          $user_skills_exists = Skill::where('user_id', auth()->user()->user_id)->first();

        if(is_null($user_skills_exists))
        {
            $skill = Skill::create([
                'user_id' => auth()->user()->user_id,
                'skills' => $extracted_skills,
            ]);
        }
        else
        {
            $data = [
                'skills' => $extracted_skills,   
            ];

             $updated = Skill::where( 'user_id', auth()->user()->user_id)->update($data);
        }

        

        return response()->json(['status' => true, 'message' => 'Skills added successfully']);


    }


    public function addproskill(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pro_skill' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $pro_skill_id = 'PRO' . time();

        $pro_skill = ProSkill::create([
            'user_id' => auth()->user()->user_id,
            'pro_skill_id' => $pro_skill_id,
            'pro_skill' => $request->pro_skill,
    
        ]);

        return response()->json(compact('pro_skill', 201));

    }

    public function updateproskill(Request $request, $id)
    {
        //$data = array_filter($request->all());

        $validator = Validator::make($request->all(), [
            'pro_skill' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $data = [
            'pro_skill' => $request->pro_skill,
        ];

        $updated = ProSkill::where('pro_skill_id', $id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Pro skill updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function deleteproskill(Request $request)
    {
        
        $deleted = ProSkill::where('pro_skill_id', $request->id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Pro Skill deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function proskills()
    {
        $proskills = ProSkill::where('user_id', auth()->user()->user_id)->get();
        return response()->json(compact('proskills'));
    }

    public function addotherskill(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'other_skill' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $other_skill_id = 'OTH' . time();
        $other_skill = OtherSkill::create([
            'user_id' => auth()->user()->user_id,
            'other_skill_id' => $other_skill_id,
            'other_skill' => $request->other_skill,
    
        ]);

        return response()->json(compact('other_skill', 201));

    }

    
    public function updateotherskill(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'other_skill' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $data = [
            'other_skill' => $request->other_skill,
        ];

        $updated = OtherSkill::where('other_skill_id', $id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Other skill updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function deleteotherskill(Request $request)
    {
        
        $deleted = OtherSkill::where('other_skill_id', $request->id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Other Skill deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function otherskills()
    {
        $otherskills = OtherSkill::where('user_id', auth()->user()->user_id)->get();
        return response()->json(compact('otherskills'));
    }

    public function addonlinelink(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'link_title' => 'required',
            'link_address' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $online_link_id = 'ONL' . time();

        $online_link = OnlineLink::create([
            'user_id' => auth()->user()->user_id,
            'online_link_id' => $online_link_id,
            'link_title' => $request->link_title,
            'link_address' => $request->link_address,
    
        ]);

        return response()->json(compact('online_link', 201));

    }

    public function updateonlinelink(Request $request, $id)
    {
        //$data = array_filter($request->all());

        $validator = Validator::make($request->all(), [
            'link_title' => 'required',
            'link_address' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $data = [
            'link_title' => $request->link_title,
            'link_address' => $request->link_address
        ];

        $updated = OnlineLink::where('online_link_id', $id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Social link updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function deleteonlinelink(Request $request)
    {
        
        $deleted = OnlineLink::where('online_link_id', $request->id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Social link deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }


    public function onlinelinks()
    {
        $onlinelinks = OnlineLink::where('user_id', auth()->user()->user_id)->get();
        return response()->json(compact('onlinelinks'));
    }


    public function createteam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_name' => 'required',
            'team_description' => 'required',
            'team_privacy' => 'required',
            'team_purpose' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        if ($request->hasFile('team_icon')) 
        {
            $file = $request->file('team_icon');
            $team_icon_name = time().uniqid().'.'.$request->team_icon->extension();
            //$file->storeAs('userteams/icons', $team_icon_name, 's3');
            $file->move(public_path('uploads/users/teamsicons'), $team_icon_name);
        }
        else
        {
            $team_icon_name = 'team_icon.png';
        }

        $team_members = $request->team_members;

        $extracted_team_members2 = json_decode($team_members, true);

        $extracted_tea_members = implode(',', array_map(function ($entry) {
            return $entry['user_id'];
          }, $extracted_team_members2));



        $team_id = 'TM' . time();
      
        $team = Team::create([
            'team_id' => $team_id,
            'team_name' => $request->team_name,
            'team_description' => $request->team_description,
            'team_privacy' => $request->team_privacy,
            'team_purpose' => $request->team_purpose,
            'team_icon' => 'uploads/users/teamsicons/'.$team_icon_name,
            'team_members' => $extracted_tea_members,
            'admin' => auth()->user()->user_id,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Team created successfully",
        ]);

    }

    public function teams()
    {
        $teams = Team::where('admin', auth()->user()->user_id)->get();
        return response()->json(compact('teams'));
    }

    public function createuserjob(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'job_title' => 'required',
            'job_description' => 'required',
            'salary' => 'required',
            'lga' => 'required',
            'state' => 'required',
            'job_description' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }


        $user_job_id = 'UJ' . time();
      
        $user_job = UserJob::create([
            
            'job_title' => $request->job_title,
			'job_id' => $user_job_id,
			'job_description' => $request->job_description,
			'salary' => $request->salary,
			'location' => $request->lga. ','. ' '. $request->state,
			'employment_type' => $request->employment_type,
			'languages' => 'English',
			'skills' => 'Cooking',
			'user_id' => auth()->user()->user_id
        ]);

        return response()->json(compact('user_job', 201));
    }

    public function userjobs()
    {
        $user_jobs = UserJob::where('user_id', auth()->user()->user_id)->get();
        return response()->json(compact('user_jobs'));
    }
}
