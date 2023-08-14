<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyAdmin;
use App\Models\CompanyBranch;
use App\Models\CompanyEvent;
use App\Models\CompanyGallery;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{

    public function cregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'founded' => 'required|date_format:Y-m-d',
            'company_name' => 'required',
            'company_email' => 'required',
            'company_number' => 'required',
            'company_type' => 'required',
            'company_size' => 'required',
            'company_industry' => 'required',
            'company_industry2' => 'required',
            'company_industry3' => 'required',
            'company_address' => 'required',
            'company_state' => 'required',
            'company_lga' => 'required',
           
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

            $company_id2 = preg_replace('/\s+/', '.', $request->company_name);

		    $company_details = Company::where('company_id', strtolower($company_id2))->first();

            if(empty($company_details))
            {

                $company_id = strtolower($company_id2);

            }
            else
            {

                // //user ID already exists. Add 1 to it
                $id = $company_details->id;
                $id2 = rand(1, 100);
                $company_id = $company_details->company_id . '.' . $id2;
                //echo $company_details['company_name'];

            }

            if ($request->hasFile('logo')) 
            {
                $file = $request->file('logo');
                $logo_name = time().uniqid().'.'.$request->logo->extension();
                //$file->storeAs('companies/logos', $logo_name, 's3');
                $file->move(public_path('uploads/companies/logos'), $logo_name);

                $company = Company::create([
                'company_id' => $company_id,
                'company_name' => $request->company_name,
                'company_id' => $company_id,
                'company_email' => $request->company_email,
                'phone' => $request->company_number,
                'cac' => $request->cac,
                'company_director' => $request->company_director,
                'company_type' => $request->company_type,
                'company_size' => $request->company_size,
                'company_industry' => $request->company_industry,
                'company_industry2' => $request->company_industry2,
                'company_industry3' => $request->company_industry3,
                'logo' => 'uploads/companies/logos/'.$logo_name,
                'website' => $request->website,
                'company_address' => $request->company_address,
                'main_office_location_state' => $request->company_state,
                'main_office_location_lga' => $request->company_lga,
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
                $company = Company::create([
                'company_id' => $company_id,
                'company_name' => $request->company_name,
                'company_id' => $company_id,
                'company_email' => $request->company_email,
                'phone' => $request->company_number,
                'cac' => $request->cac,
                'company_director' => $request->company_director,
                'company_type' => $request->company_type,
                'company_size' => $request->company_size,
                'company_industry' => $request->company_industry,
                'company_industry2' => $request->company_industry2,
                'company_industry3' => $request->company_industry3,
                'website' => $request->website,
                'company_address' => $request->company_address,
                'main_office_location_state' => $request->company_state,
                'main_office_location_lga' => $request->company_lga,
                'about' => $request->about,
                'founded_year' => $request->founded,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'author' => auth()->user()->user_id,
                ]);
            }

           return response()->json(['status' => true, 'message' => 'Company created successfully']);

    }

    public function companies()
    {
        $companies = Company::where('author', auth()->user()->user_id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('companies'));
    }

    public function companydetails($id)
    {
        $companydetails = Company::where('company_id', $id)->orderBy('id', 'DESC')->first();
        return response()->json(compact('companydetails'));
    }

    public function updatecompanyinfo(Request $request, $id)
	{

		$data = [
	
			'founded_month' => $request->founded_month,
            'founded_year' => $request->founded_year,
			'field' => $request->field,
            
			];

            $updated =  Company::where('company_id', $id)->update($data);

  
            return response()->json(compact('updated'));

	}

    public function updatecompanyprofile(Request $request, $id)
	{

        $validator = Validator::make($request->all(), [
            'founded' => 'required|date_format:Y-m-d',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }
		
		$data = [

            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'phone' => $request->company_number,
            'cac' => $request->cac,
            'company_type' => $request->company_type,
            'company_size' => $request->company_size,
            'company_industry' => $request->company_industry,
            'company_industry2' => $request->company_industry2,
            'company_industry3' => $request->company_industry3,
            'company_director' => $request->company_director,
            'website' => $request->website,
            'company_address' => $request->company_address,
            'main_office_location_state' => $request->company_state,
            'main_office_location_lga' => $request->company_lga,
            'about' => $request->about,
            'founded_year' => $request->founded,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
			'field' => $request->field,
            'about' => $request->about,
            
			];


            $updated =  Company::where('company_id', $id)->update($data);

  
            if(!empty($updated))
            {
                return response()->json(['status' => true, 'message' => 'Company profile updated successfully']);
            }
    
            return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function makecompanyadmin(Request $request, $company_id)
	{
		
		
		$user_details = User::where('user_id', $request->sub_admin_id)->first();

		// var_dump($applicant_details);

        $company_admin = CompanyAdmin::create([
                
                's_no' => 'CA'. time(),
                'company_id' => $company_id,
                'sub_admin_id' => $request->sub_admin_id,
                'sub_admin_name' => $user_details->first_name. ' '. $user_details->last_name,
        
                ]);
					
				
        return response()->json(compact('company_admin'),201);
        //return response()->json($request->sub_admin_id);

	}


    public function removecompanyadmin($id)
    {

        $deleted = CompanyAdmin::where('s_no', $id)->delete();

        return response()->json(compact('deleted'));
       
    }

    public function updatecompanyabout(Request $request, $id)
	{
		
		$data = [

			'about' => $request->company_about,
			'phone' => $request->company_number,
			'cac' => $request->cac,
			'company_director' => $request->company_director,
			'website' => $request->website,
			'company_address' => $request->company_address,
			'main_office_location_state' => $request->about_state,
			'main_office_location_lga' => $request->about_lga,
		
            ];
            
	
            $updated =  Company::where('company_id', $id)->update($data);

  
            return response()->json(compact('updated'));

            //return response()->json($data);
		
	}

    public function createcompanybranch(Request $request, $id)
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
            //$file->storeAs('companies/branchimages', $filename1, 's3');
            $file->move(public_path('uploads/companies/branchimages'), $filename1);
        }
        else
        {
            $filename1 = 'company_branch_image.jpg';
        }

        
        $inserted = CompanyBranch::create([

            'company_id' => $id,
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
            'branch_image' => 'uploads/companies/branchimages/'.$filename1

            ]);

            if(!empty($inserted))
            {
                return response()->json(['status' => true, 'message' => 'Company branch created successfully']);
            }
    
            return response()->json(['status' => false, 'message' => 'Error occurred']);
        
	}

    public function companybranches($id)
    {
        $companybranches = CompanyBranch::where('company_id', $id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('companybranches'));
    }

    public function companybranch($company_id, $branch_id)
    {
        $companybranchdetails = CompanyBranch::where('company_id', $company_id)->where('branch_id', $branch_id)->first();
        return response()->json(compact('companybranchdetails'));
    }


    public function updatecompanybranch(Request $request, $company_id, $branch_id)
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

			$updated =  CompanyBranch::where('company_id', $company_id)->where('branch_id', $branch_id)->update($data);

            if($updated > 0)
            {
                return response()->json(['status' => true, 'message' => 'Company branch updated successfully']);
            }
    
            return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function deletecompanybranch(Request $request, $company_id, $branch_id)
	{

        $deleted =  CompanyBranch::where('company_id', $company_id)->where('branch_id', $branch_id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Company branch deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);

	}


    public function updatecompanysocials(Request $request, $id)
	{
		//editbranchaction

		$data = [
	
			'linkedin' => $request->linkedin,
			'facebook' => $request->facebook,
			'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            
			];

			$updated =  Company::where('company_id', $id)->update($data);

  
            return response()->json(compact('updated'));
	}

    public function createcompanyevent(Request $request, $id)
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
            $filename1 = time().uniqid(). '.' .$request->event_image->extension();
            //$file->storeAs('companies/events/eventimages', $filename1, 's3');
            $file->move(public_path('uploads/companies/eventimages'), $filename1);
        }
        else
        {
            $filename1 = 'event.jpg';
        }

        if(!empty($request->hasFile('event_logo')))
        {
            $file = $request->file('event_logo');
            $logoname = time().uniqid().'.'.$request->event_image->extension();
            //$file->storeAs('companies/events/eventlogos', $filename1, 's3');
            $file->move(public_path('uploads/companies/eventlogos'), $logoname);
        }
        else
        {
            $logoname = 'event_logo.jpg';
        }

        $event_start = $request->event_start_date . " " . $request->event_start_time;
        $event_end = $request->event_end_date . " " . $request->event_end_time;

        $start_DT = date('Y-m-d H:i:s', strtotime($event_start));
        $end_DT = date('Y-m-d H:i:s', strtotime($request->event_end));

        $inserted = CompanyEvent::create([
        
        'company_id' => $id,
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
        'event_image1' => 'uploads/companies/eventimages/'.$filename1,
        'event_logo' => 'uploads/companies/eventlogos/'.$logoname,

        ]);

        
        if(!empty($inserted))
        {
            return response()->json(['status' => true, 'message' => 'Company event created successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function updatecompanyevent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'event_start' => 'required|date_format:Y-m-d',
            'event_end' => 'required|date_format:Y-m-d',
            'event_title' => 'required',
            'event_description' => 'required',
            'event_type' => 'required',
            'event_price1' => 'required',
            'event_price2' => 'required',
           
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $start_DT = date('Y-m-d H:i:s', strtotime($request->event_start));
		$end_DT = date('Y-m-d H:i:s', strtotime($request->event_end));
		
        $data = [
			
			'from' => $start_DT,
			'to' => $end_DT,
			'title' => $request->event_title,
			'event_link' => $request->event_link,
			'description' => $request->event_description,
			'event_type' => $request->event_type,
			'event_industry' => $request->event_industry,
			'event_price1' => $request->event_price1,
			'event_price2' => $request->event_price2,
			'event_address' => $request->event_address,
			'event_state' => $request->event_state, 
			'event_lga' => $request->event_lga

            ];

        $updated =  CompanyEvent::where('event_id', $id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Company event updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
	}


	public function deletecompanyevent(Request $request)
    {
        
        $deleted = CompanyEvent::where('event_id', $request->id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Company event deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }
 
    public function companyevents($id)
    {
        $companyevents = CompanyEvent::where('company_id', $id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('companyevents'));
    }

    public function addcompanygallery(Request $request, $id)
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
            //$file->storeAs('companygalleries', $gallery_image_name, 's3');
            $file->move(public_path('uploads/companies/galleries'), $gallery_image_name);

            $gallery = new CompanyGallery();
            $gallery->company_id = $id;
            $gallery->user_id = auth()->user()->user_id;
            $gallery->gallery_id = 'CGA' . time();
            $gallery->image = 'uploads/companies/galleries/'.$gallery_image_name;
            $gallery->image_title = $request->image_title;
            $gallery->date = $request->year;
            $gallery->save();

            return response()->json([
                "success" => true,
                "message" => "Gallery successfully uploaded",
                "gallery_image_name" => $gallery_image_name,
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "Error occurred",

        ]);
    }

    public function updatecompanygallery(Request $request, $gallery_id)
    {
        $data = [
            
            "image_title" => $request->image_title,
            "date" => $request->year
        ];

        $updated = CompanyGallery::where('gallery_id', $gallery_id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Company gallery updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
    }

    public function deletecompanygallery(Request $request)
    {
        
        $deleted = CompanyGallery::where('gallery_id', $request->id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Company gallery deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }

    public function companygalleries($id)
    {
        $companygalleries = CompanyGallery::where('company_id', $id)->get();
        return response()->json(compact('companygalleries'));
    }

    public function createcompanyebroadcast(Request $request, $id)
	{
        $applicant_ids = $request->user_ids;

		// $receivers = array();
		// foreach ($applicant_ids as $user_id) 
		// {
		// 	$receivers[] = User::where('user_id', $user_id)->where('active', 1)->pluck('first_name', 'last_name')->first();
		// }
	
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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
			);
		}

			$inserted = Message::insert($data);

            if($inserted > 0)
            {
                return response()->json(['status' => true, 'message' => 'Broadcast created successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function companyebroadcasts($id)
    {
        $companyebroadcasts = Message::where('sender_id', $id)->get();
        return response()->json(compact('companyebroadcasts'));
    }

    public function cchangelogo(Request $request, $company_id)
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
            //$file->storeAs('companies/logos', $logo_name, 's3');
             $file->move(public_path('uploads/companies/logos'), $logo_name);

            $data = [
            
                'logo' => 'uploads/companies/logos/'.$logo_name,
            ];

            $updated = Company::where('company_id', $company_id)->update($data);

            if($updated > 0)
            {
                return response()->json(['status' => true, 'message' => 'Logo updated successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred']);
        }
        return response()->json(['status' => false, 'message' => 'No file selected']);
    }

    public function cchangecoverimage(Request $request, $company_id)
    {
        $validator = Validator::make($request->all(), [
            'coverimage'        =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        if ($request->hasFile('coverimage')) 
        {

            $file = $request->file('coverimage');
            $coverimage_name = time().uniqid().'.'.$request->coverimage->extension();
            //$file->storeAs('companies/coverimages', $coverimage_name, 's3');
            $file->move(public_path('uploads/companies/coverimages'), $coverimage_name);
            //return response()->json($coverimage_name);
            
            $data = [
            
                'cover_image' => 'uploads/companies/coverimages/'.$coverimage_name,
            ];

            $updated = Company::where('company_id', $company_id)->update($data);

            // return $updated;

            if($updated > 0)
            {
                return response()->json(['status' => true, 'message' => 'Cover Image updated successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred']);
        }

        return response()->json(['status' => false, 'message' => 'No file selected']);
        //return response()->json($request->hasFile('coverimage'));
    }

    public function profile($company_id)
    {
        $companydetails = Company::where('company_id', $company_id)->orderBy('id', 'DESC')->first();

        if(is_null($companydetails)) return response()->json(['errors' => 'Company does not exist'], 404);

        $companybranches = CompanyBranch::where('company_id', $company_id)->orderBy('id', 'DESC')->get();
        $companyevents = CompanyEvent::where('company_id', $company_id)->orderBy('id', 'DESC')->get();
        $companygalleries = CompanyGallery::where('company_id', $company_id)->get();
        
        return response()->json([
            'companydetails' => $companydetails, 
            'companybranches' => $companybranches,
            'companyevents' => $companyevents,
            'companygalleries' => $companygalleries
        ]);
    }

    public function companysearch($name)
    {
        $search_results = Company::where('company_name','LIKE','%'.$name.'%')->get();
        return response()->json($search_results);
    }
}
