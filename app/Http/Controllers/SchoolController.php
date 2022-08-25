<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\SchoolBranch;
use App\Models\SchoolEvent;
use App\Models\SchoolGallery;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function sregister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'founded' => 'required|date_format:Y-m-d',
            'school_name' => 'required',
            'school_email' => 'required',
            'school_number' => 'required',
            'school_type' => 'required',
            'school_size' => 'required',
            'school_address' => 'required',
            'school_state' => 'required',
            'school_lga' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $school_id2 = preg_replace('/\s+/', '.', $request->school_name);

        $school_details = School::where('school_id', strtolower($school_id2))->first();

        if(empty($school_details))
        {

            $school_id = strtolower($school_id2);

        }
        else
        {

            // //user ID already exists. Add 1 to it
            $id = $school_details->id;
            $id2 = rand(1, 100);
            $school_id = $school_details->school_id . '.' . $id2;
            //echo $school_details['school_name'];

        }

        if ($request->hasFile('logo')) 
        {
            $file = $request->file('logo');
            $logo_name = time().uniqid().'.'.$request->logo->extension();
            $file->storeAs('schools/logos', $logo_name, 's3');

            $school = School::create([
            'school_id' => $school_id,
            'school_name' => $request->school_name,
            'school_id' => $school_id,
            'school_email' => $request->school_email,
            'phone' => $request->school_number,
            'cac' => $request->cac,
            'school_director' => $request->school_director,
            'school_type' => $request->school_type,
            'school_size' => $request->school_size,
            'school_industry' => $request->school_industry,
            'school_industry2' => $request->school_industry2,
            'school_industry3' => $request->school_industry3,
            'logo' => $logo_name,
            'website' => $request->website,
            'school_address' => $request->school_address,
            'main_office_location_state' => $request->school_state,
            'main_office_location_lga' => $request->school_lga,
            'about' => $request->about,
            'founded_year' => $request->founded,
            'linkedin' => $request->linkedin,
			'facebook' => $request->facebook,
			'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'author' => auth()->user()->user_id,
            ]);
        }
        else
        {
            $school = School::create([
            'school_id' => $school_id,
            'school_name' => $request->school_name,
            'school_id' => $school_id,
            'school_email' => $request->school_email,
            'phone' => $request->school_number,
            'cac' => $request->cac,
            'school_director' => $request->school_director,
            'school_type' => $request->school_type,
            'school_size' => $request->school_size,
            'school_industry' => $request->school_industry,
            'school_industry2' => $request->school_industry2,
            'school_industry3' => $request->school_industry3,
            'website' => $request->website,
            'school_address' => $request->school_address,
            'main_office_location_state' => $request->school_state,
            'main_office_location_lga' => $request->school_lga,
            'about' => $request->about,
            'founded_year' => $request->founded,
            'linkedin' => $request->linkedin,
			'facebook' => $request->facebook,
			'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'author' => auth()->user()->user_id,
            ]);
        }

        return response()->json(['status' => true, 'message' => 'School created successfully']);

    }

    public function schools()
    {
        $schools = School::where('author', auth()->user()->user_id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('schools'));
    }

    public function schooldetails($id)
    {
        $schooldetails = School::where('school_id', $id)->orderBy('id', 'DESC')->first();
        return response()->json(compact('schooldetails'));
    }

    public function updateschoolinfo(Request $request, $id)
	{
		

		$data = [
	
			'founded_month' => $request->founded_month,
            'founded_year' => $request->founded_year,
			'field' => $request->field,
            
			];


			// $assoc = new schoolModel();
			// $updated = $assoc->update($id, $data);

            $updated =  School::where('school_id', $id)->update($data);

  
            return response()->json(compact('updated'));

	}

    public function updateschoolprofile(Request $request, $id)
	{
        $validator = Validator::make($request->all(), [
            'founded' => 'required|date_format:Y-m-d',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }
		
		$data = [

            'school_name' => $request->school_name,
            'school_email' => $request->school_email,
            'phone' => $request->school_number,
            'cac' => $request->cac,
            'school_type' => $request->school_type,
            'school_size' => $request->school_size,
            'school_industry' => $request->school_industry,
            'school_industry2' => $request->school_industry2,
            'school_industry3' => $request->school_industry3,
            'website' => $request->website,
            'school_address' => $request->school_address,
            'main_office_location_state' => $request->school_state,
            'main_office_location_lga' => $request->school_lga,
            'about' => $request->about,
            'founded_year' => $request->founded,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
			'field' => $request->field,
            'about' => $request->about,
            'school_director' => $request->school_director,
			];

            $updated =  school::where('school_id', $id)->update($data);

            if(!empty($updated))
            {
                return response()->json(['status' => true, 'message' => 'school profile updated successfully']);
            }
    
            return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function makeschooladmin(Request $request, $school_id)
	{
		
		
		$user_details = User::where('user_id', $request->sub_admin_id)->first();

		// var_dump($applicant_details);

        $school_admin = SchoolAdmin::create([
                
                's_no' => 'CA'. time(),
                'school_id' => $school_id,
                'sub_admin_id' => $request->sub_admin_id,
                'sub_admin_name' => $user_details->first_name. ' '. $user_details->last_name,
        
                ]);
					
				
        return response()->json(compact('school_admin'),201);
        //return response()->json($request->sub_admin_id);

	}


    public function removeschooladmin($id)
    {

        $deleted = SchoolAdmin::where('s_no', $id)->delete();

        return response()->json(compact('deleted'));
       
    }

    public function updateschoolabout(Request $request, $id)
	{
		
		$data = [

			'about' => $request->school_about,
			'phone' => $request->school_number,
			'cac' => $request->cac,
			'school_director' => $request->school_director,
			'website' => $request->website,
			'school_address' => $request->school_address,
			'main_office_location_state' => $request->about_state,
			'main_office_location_lga' => $request->about_lga,
		
            ];
            
	
            $updated =  School::where('school_id', $id)->update($data);

  
            return response()->json(compact('updated'));

            //return response()->json($data);
		
	}

    public function createschoolbranch(Request $request, $id)
	{
        $validator = Validator::make($request->all(), [
            'branch_name' => 'required',
            'branch_manager' => 'required',
            'branch_address' => 'required',
            'branch_state' => 'required',
            'branch_lga' => 'required',
            'branch_phone' => 'required',
            'opening_time' => 'required|date_format:H:i:s',
            'closing_time' => 'required|date_format:H:i:s|after:opening_time',
            'opening_week_day' => 'required',
            'closing_week_day' => 'required',
            
           
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        if($request->hasFile('branch_image'))
        {
            $file = $request->file('branch_image');
            $filename1 = time().uniqid(). '.' .$request->branch_image->extension();
            $file->storeAs('schools/branchimages', $filename1, 's3');
        }
        else
        {
            $filename1 = 'school_branch_image.jpg';
        }

        $inserted = SchoolBranch::create([
       
			'school_id' => $id,
            'branch_id' => 'BR' . time(),
			'branch_name' => $request->branch_name,
			'branch_manager' => $request->branch_manager,
			'branch_address' => $request->branch_address,
			'branch_state' => $request->branch_state,
            'branch_lga' => $request->branch_lga,
            'branch_phone' => $request->branch_phone,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'opening_week_day' => $request->opening_week_day,
            'closing_week_day' => $request->closing_week_day,
            'branch_image' => $filename1
            ]);

            if(!empty($inserted))
            {
                return response()->json(['status' => true, 'message' => 'School branch created successfully']);
            }
    
            return response()->json(['status' => false, 'message' => 'Error occurred']);
      
	}

    public function schoolbranches($id)
    {
        $schoolbranches = SchoolBranch::where('school_id', $id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('schoolbranches'));
    }

    public function schoolbranch($school_id, $branch_id)
    {
        $schoolbranchdetails = SchoolBranch::where('school_id', $school_id)->where('branch_id', $branch_id)->first();
        return response()->json(compact('schoolbranchdetails'));
    }


    public function updateschoolbranch(Request $request, $school_id, $branch_id)
	{

		$data = [
	
			'branch_name' => $request->branch_name,
			'branch_manager' => $request->branch_manager,
			'branch_address' => $request->branch_address,
			'branch_phone' => $request->branch_phone,
			'branch_state' => $request->branch_state,
            'branch_lga' => $request->branch_lga,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'opening_week_day' => $request->opening_week_day,
            'closing_week_day' => $request->closing_week_day,
            
			];

			$updated =  SchoolBranch::where('school_id', $school_id)->where('branch_id', $branch_id)->update($data);

            if($updated > 0)
            {
                return response()->json(['status' => true, 'message' => 'School branch updated successfully']);
            }
    
            return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function deleteschoolbranch(Request $request, $school_id, $branch_id)
	{

        $deleted =  SchoolBranch::where('school_id', $school_id)->where('branch_id', $branch_id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'School branch deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function updateschoolsocials(Request $request, $id)
	{
		//editbranchaction

		$data = [
	
			'linkedin' => $request->linkedin,
			'facebook' => $request->facebook,
			'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            
			];

			$updated =  School::where('school_id', $id)->update($data);

  
            return response()->json(compact('updated'));
	}

    public function createschoolevent(Request $request, $id)
	{
        $validator = Validator::make($request->all(), [
            'event_start_date' => 'required|date_format:Y-m-d',
            'event_end_date' => 'required|date_format:Y-m-d|after_or_equal:event_start_date',
            'event_start_time' => 'required|date_format:H:i:s',
            'event_end_time' => 'required|date_format:H:i:s|after_or_equal:event_start_time',
            'event_title' => 'required',
            'event_description' => 'required',
            'event_type' => 'required',
            'event_price1' => 'required',
            'event_price2' => 'required',
           
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

			if(!empty($request->hasFile('event_image')))
			{
                $file = $request->file('event_image');
                $filename1 = time().uniqid().'.'.$request->event_image->extension();
                $file->storeAs('schools/events/eventimages', $filename1, 's3');
			}
			else
			{
				$filename1 = 'event.jpg';
			}

			if(!empty($request->hasFile('event_logo')))
			{
                $file = $request->file('event_logo');
                $logoname = time().uniqid().'.'.$request->event_logo->extension();
                $file->storeAs('schools/events/eventlogos', $logoname, 's3');
			}
			else
			{
				$logoname = 'event_logo.jpg';
			}


			$event_start = $request->event_start_date . " " . $request->event_start_time;
            $event_end = $request->event_end_date . " " . $request->event_end_time;

            $start_DT = date('Y-m-d H:i:s', strtotime($event_start));
            $end_DT = date('Y-m-d H:i:s', strtotime($request->event_end));

            $inserted = SchoolEvent::create([
			
                'school_id' => $id,
                'event_id' => 'EV' . time(),
                'from' => $start_DT,
                'to' => $end_DT,
                'title' => $request->event_title,
                'event_link' => $request->event_link,
                'author' => auth()->user()->user_id,
                'description' => $request->event_description,
                'event_type' => $request->event_type,
                'event_industry' => $request->event_industry,
                'event_price1' => $request->event_price1,
                'event_price2' => $request->event_price2,
                'event_address' => $request->event_address,
                'event_state' => $request->event_state, 
                'event_lga' => $request->event_lga,
                'event_image1' => $filename1,
                'event_logo' => $logoname,

                ]);

                
            if(empty($inserted))
            {
                return response()->json(['status' => false, 'message' => 'Error occurred']);
            }

            return response()->json(['status' => true, 'message' => 'School event created successfully']);
  

	}
 
    public function schoolevents($id)
    {
        $schoolevents = SchoolEvent::where('school_id', $id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('schoolevents'));
    }

    public function addschoolgallery(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gallery' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_title' => 'required',
            'year' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }  

        if ($request->hasFile('gallery')) 
        {

            $file = $request->file('gallery');
            $gallery_image_name = time().uniqid().'.'.$request->gallery->extension();
            $file->storeAs('schoolgalleries', $gallery_image_name, 's3');

            $gallery = new SchoolGallery();
            $gallery->school_id = $id;
            $gallery->user_id = auth()->user()->user_id;
            $gallery->gallery_id = 'SGA' . time();
            $gallery->image = $gallery_image_name;
            $gallery->image_title = $request->image_title;
            $gallery->date = $request->year;
            $gallery->save();

            return response()->json([
                "success" => true,
                "message" => "Gallery successfully uploaded",
                "gallery_image_name" => $gallery_image_name,
            ]);
        }
    }


    public function updateschoolgallery(Request $request, $gallery_id)
    {
        $data = [
            
            "image_title" => $request->image_title,
            "date" => $request->year
        ];

        $updated = SchoolGallery::where('gallery_id', $gallery_id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'School gallery updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
    }

    public function deleteschoolgallery(Request $request)
    {
        
        $deleted = SchoolGallery::where('gallery_id', $request->id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'School gallery deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }


    public function schoolgalleries($id)
    {
        $schoolgalleries = SchoolGallery::where('school_id', $id)->get();
        return response()->json(compact('schoolgalleries'));
    }


    public function createschoolebroadcast(Request $request, $id)
	{


		$applicant_ids = ['1621129452', '1621179317', '1621179324', '1621179329', '1621179333'];


		$receivers = array();
		foreach ($applicant_ids as $user_id) 
		{
			$receivers[] = User::where('user_id', $user_id)->where('active', 1)->pluck('first_name', 'last_name')->first();
		}
	
		$message_id = 'MSG' . time();

		for($i=0; $i<count($applicant_ids); $i++)
		{
			$data[]=array(
                'author' => auth()->user()->user_id,
				'sender_id' => $id,
				//'sender_name' => $request->sender_name,
				'subject'=> $request->subject,
				'message'=> $request->message,
                'message_id'=> $message_id,
				'receiver_id'=>$applicant_ids[$i],
				// 'receiver_name'=> $receivers[$i],
				'is_broadcast' => 1,
			);
		}

			$message = Message::insert($data);

            return response()->json([
                "success" => true,
                "message" => "Broadcast created successfully",
    
            ]);


	}

    public function schoolebroadcasts($id)
    {
        $schoolebroadcasts = Message::where('sender_id', $id)->get();
        return response()->json(compact('schoolebroadcasts'));
    }

    public function schangelogo(Request $request, $school_id)
    {

        $validator = Validator::make($request->all(), [
            'logo' =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        if ($request->hasFile('logo')) 
        {

            $file = $request->file('logo');
            $logo_name = time().uniqid().'.'.$request->logo->extension();
            $file->storeAs('schools/logos', $logo_name, 's3');

            $data = [
            
                'logo' => $logo_name,
            ];

            $updated = School::where('school_id', $school_id)->update($data);

            if($updated > 0)
            {
                return response()->json(['status' => true, 'message' => 'Logo updated successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred']);
        }
        return response()->json(['status' => false, 'message' => 'No file selected']);
    }

    public function schangecoverimage(Request $request, $school_id)
    {
        $validator = Validator::make($request->all(), [
            'coverimage' =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        if ($request->hasFile('coverimage')) 
        {

            $file = $request->file('coverimage');
            $coverimage_name = time().uniqid().'.'.$request->coverimage->extension();
            $file->storeAs('schools/coverimages', $coverimage_name, 's3');
            
            $data = [
            
                'cover_image' => $coverimage_name,
            ];

            $updated = School::where('school_id', $school_id)->update($data);

            // return $updated;

            if($updated > 0)
            {
                return response()->json(['status' => true, 'message' => 'Cover Image updated successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred']);
        }

        return response()->json(['status' => false, 'message' => 'No file selected']);

    }

    public function profile($school_id)
    {
        $schooldetails = School::where('school_id', $school_id)->orderBy('id', 'DESC')->first();

        if(is_null($schooldetails)) return response()->json(['errors' => 'School does not exist'], 404);

        $schoolbranches = SchoolBranch::where('school_id', $school_id)->orderBy('id', 'DESC')->get();
        $schoolevents = SchoolEvent::where('school_id', $school_id)->orderBy('id', 'DESC')->get();
        $schoolgalleries = SchoolGallery::where('school_id', $school_id)->get();
        
        return response()->json([
            'schooldetails' => $schooldetails, 
            'schoolbranches' => $schoolbranches,
            'schoolevents' => $schoolevents,
            'schoolgalleries' => $schoolgalleries
        ]);
    }

    public function schoolsearch($name)
    {
        $search_results = School::where('school_name','LIKE','%'.$name.'%')->get();
        return response()->json($search_results);
    }

}
