<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Association;
use App\Models\AssociationAdmin;
use App\Models\AssociationBranch;
use App\Models\AssociationEvent;
use App\Models\AssociationGallery;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AssociationController extends Controller
{
    
    public function aregister(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'founded' => 'required|date_format:Y-m-d',
                'association_name' => 'required',
                'association_contact_email' => 'required',
                'association_phone' => 'required',
                'association_type' => 'required',
                'association_size' => 'required',
                'association_address' => 'required',
                'association_cac' => 'required',
                'association_website' => 'required',
                'association_state' => 'required',
                'association_lga' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()->getMessages()], 400);
            }

            $association_id2 = preg_replace('/\s+/', '.', $request->association_name);

		    $association_details = association::where('association_id', strtolower($association_id2))->first();

            if(empty($association_details))
            {

                $association_id = strtolower($association_id2);

            }
            else
            {

                // //user ID already exists. Add 1 to it
                $id = $association_details->id;
                $id2 = rand(1, 100);
                $association_id = $association_details->association_id . '.' . $id2;
                //echo $association_details['association_name'];

            }


            if ($request->hasFile('logo')) 
            {
                $file = $request->file('logo');
                $logo_name = time().uniqid().'.'.$request->logo->extension();
                $file->storeAs('associations/logos', $logo_name, 's3');

                $association = Association::create([
                'association_id' => $association_id,
                'association_name' => $request->association_name,
                'association_id' => $association_id,
                'association_email' => $request->association_email,
                'phone' => $request->association_phone,
                'about' => $request->about,
                'cac' => $request->association_cac,
                'association_type' => $request->association_type,
                'association_size' => $request->association_size,
                'logo' => $logo_name,
                'website' => $request->association_website,
                'association_director' => $request->association_director,
                'association_contact_email' => $request->association_contact_email,
                'association_address' => $request->association_address,
                'main_office_location_state' => $request->association_state,
                'main_office_location_lga' => $request->association_lga,
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
                $association = Association::create([
                'association_id' => $association_id,
                'association_name' => $request->association_name,
                'association_id' => $association_id,
                'association_email' => $request->association_email,
                'phone' => $request->association_phone,
                'about' => $request->about,
                'cac' => $request->association_cac,
                'association_type' => $request->association_type,
                'association_size' => $request->association_size,
                'website' => $request->association_website,
                'association_director' => $request->association_director,
                'association_contact_email' => $request->association_contact_email,
                'association_address' => $request->association_address,
                'main_office_location_state' => $request->association_state,
                'main_office_location_lga' => $request->association_lga,
                'founded_year' => $request->founded,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'author' => auth()->user()->user_id,
                ]);
            }   


            return response()->json(['status' => true, 'message' => 'Association created successfully']);

    }

    public function associations()
    {
        $associations = Association::where('author', auth()->user()->user_id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('associations'));
    }

    public function associationdetails($id)
    {
        $associationdetails = Association::where('association_id', $id)->orderBy('id', 'DESC')->first();
        return response()->json(compact('associationdetails'));
    }

    public function updateassociationinfo(Request $request, $id)
	{
		//editbranchaction

		$data = [
	
			'founded_month' => $request->founded_month,
            'founded_year' => $request->founded_year,
			'field' => $request->field,
            
			];


			// $assoc = new associationModel();
			// $updated = $assoc->update($id, $data);

            $updated =  Association::where('association_id', $id)->update($data);

            if ($updated) {
                return response()->json(compact('updated'));
            }

	}

    public function updateassociationprofile(Request $request, $id)
	{
        $validator = Validator::make($request->all(), [
            'founded' => 'required|date_format:Y-m-d',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

		$data = [

            'association_name' => $request->association_name,
            'association_email' => $request->association_email,
            'phone' => $request->association_phone,
            'cac' => $request->association_cac,
            'association_director' => $request->association_director,
            'association_type' => $request->association_type,
            'association_size' => $request->association_size,
            'association_industry' => $request->association_industry,
            'association_industry2' => $request->association_industry2,
            'association_industry3' => $request->association_industry3,
            'website' => $request->association_website,
            'association_address' => $request->association_address,
            'main_office_location_state' => $request->main_office_location_state,
            'main_office_location_lga' => $request->main_office_location_lga,
            'about' => $request->about,
            'founded_year' => $request->founded,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
			'field' => $request->field,
            'about' => $request->about,
			];

            $updated =  association::where('association_id', $id)->update($data);

            if(!empty($updated))
            {
                return response()->json(['status' => true, 'message' => 'association profile updated successfully']);
            }
    
            return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function makeassociationadmin(Request $request, $association_id)
	{
		
		
		$user_details = User::where('user_id', $request->sub_admin_id)->first();

		// var_dump($applicant_details);

        $association_admin = AssociationAdmin::create([
                
                's_no' => 'AA'. time(),
                'association_id' => $association_id,
                'sub_admin_id' => $request->sub_admin_id,
                'sub_admin_name' => $user_details->first_name. ' '. $user_details->last_name,
        
                ]);
					
				
        return response()->json(compact('association_admin'),201);

	}


    public function removeassociationadmin($id)
    {

        $deleted = AssociationAdmin::where('s_no', $id)->delete();

        return response()->json(compact('deleted'));
       
    }

    public function updateassociationabout(Request $request, $id)
	{
		
		$data = [

			'about' => $request->association_about,
			'phone' => $request->association_phone,
			'cac' => $request->association_cac,
			'association_director' => $request->association_director,
			'website' => $request->website,
			'association_address' => $request->association_address,
			'main_office_location_state' => $request->about_state,
			'main_office_location_lga' => $request->about_lga,
		
            ];
            
	
            $updated =  Association::where('association_id', $id)->update($data);

  
            return response()->json(compact('updated'));

            //return response()->json($data);
		
	}

    public function createassociationbranch(Request $request, $id)
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
            $file->storeAs('associations/branchimages', $filename1, 's3');
        }
        else
        {
            $filename1 = 'association_branch_image.jpg';
        }

        $inserted = AssociationBranch::create([
       
			'association_id' => $id,
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
            return response()->json(['status' => true, 'message' => 'Association branch created successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
      
	}

    public function associationbranches($id)
    {
        $associationbranches = AssociationBranch::where('association_id', $id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('associationbranches'));
    }

    public function associationbranch($association_id, $branch_id)
    {
        $associationbranchdetails = AssociationBranch::where('association_id', $association_id)->where('branch_id', $branch_id)->first();
        return response()->json(compact('associationbranchdetails'));
    }

    public function updateassociationbranch(Request $request, $association_id, $branch_id)
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

			$updated =  AssociationBranch::where('association_id', $association_id)->where('branch_id', $branch_id)->update($data);

            if($updated > 0)
            {
                return response()->json(['status' => true, 'message' => 'Association branch updated successfully']);
            }
    
            return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function deleteassociationbranch(Request $request, $association_id, $branch_id)
	{

        $deleted =  AssociationBranch::where('association_id', $association_id)->where('branch_id', $branch_id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Association branch deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);

	}

    public function updateassociationsocials(Request $request, $id)
	{
		//editbranchaction

		$data = [
	
			'linkedin' => $request->linkedin,
			'facebook' => $request->facebook,
			'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            
			];

			$updated =  Association::where('association_id', $id)->update($data);

  
            return response()->json(compact('updated'));
	}

    public function createassociationevent(Request $request, $id)
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
                $file->storeAs('associations/events/eventimages', $filename1, 's3');
			}
			else
			{
				$filename1 = 'event.jpg';
			}

			if(!empty($request->hasFile('event_logo')))
			{
				$file = $request->file('event_logo');
                $logoname = time().uniqid().'.'.$request->event_logo->extension();
                $file->storeAs('associations/events/eventlogos', $logoname, 's3');
			}
			else
			{
				$logoname = 'event_logo.jpg';
			}


			$event_start = $request->event_start_date . " " . $request->event_start_time;
            $event_end = $request->event_end_date . " " . $request->event_end_time;

            $start_DT = date('Y-m-d H:i:s', strtotime($event_start));
            $end_DT = date('Y-m-d H:i:s', strtotime($request->event_end));

            $inserted = AssociationEvent::create([
			
            'association_id' => $id,
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

            
            if(!empty($inserted))
            {
                return response()->json(['status' => true, 'message' => 'Association event created successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred']);


	}
 
    public function associationevents($id)
    {
        $associationevents = AssociationEvent::where('association_id', $id)->orderBy('id', 'DESC')->get();
        return response()->json(compact('associationevents'));
    }

    public function addassociationgallery(Request $request, $id)
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
            // $gallery_image_name = time().uniqid().'.'.$request->gallery->extension();
            // // $fileSize = $request->atm_card_file_name->getClientSize();
            // $request->gallery->move(public_path('uploads/associationgalleries'), $gallery_image_name);

            $file = $request->file('gallery');
            $gallery_image_name = time().uniqid().'.'.$request->gallery->extension();
            $file->storeAs('associationgalleries', $gallery_image_name, 's3');

            $gallery = new AssociationGallery();
            $gallery->association_id = $id;
            $gallery->user_id = auth()->user()->user_id;
            $gallery->gallery_id = 'AGA' . time();
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

    public function updateassociationgallery(Request $request, $gallery_id)
    {
        $data = [
            
            "image_title" => $request->image_title,
            "date" => $request->year
        ];

        $updated = AssociationGallery::where('gallery_id', $gallery_id)->update($data);

        if($updated > 0)
        {
            return response()->json(['status' => true, 'message' => 'Association gallery updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
    }

    public function deleteassociationgallery(Request $request)
    {
        
        $deleted = AssociationGallery::where('gallery_id', $request->id)->delete();

        if($deleted > 0)
        {
            return response()->json(['status' => true, 'message' => 'Association gallery deleted successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Error occurred']);
       
    }


    public function associationgalleries($id)
    {
        $associationgalleries = AssociationGallery::where('association_id', $id)->get();
        return response()->json(compact('associationgalleries'));
    }


    public function createassociationebroadcast(Request $request, $id)
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

            return response()->json(compact('message'),201);


	}


    public function associationebroadcasts($id)
    {
        $associationebroadcasts = Message::where('sender_id', $id)->get();
        return response()->json(compact('associationebroadcasts'));
    }

    public function achangelogo(Request $request, $association_id)
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
            $file->storeAs('associations/logos', $logo_name, 's3');

            $data = [
            
                'logo' => $logo_name,
            ];

            $updated = Association::where('association_id', $association_id)->update($data);

            if($updated > 0)
            {
                return response()->json(['status' => true, 'message' => 'Logo updated successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred']);
        }
        return response()->json(['status' => false, 'message' => 'No file selected']);
    }

    public function achangecoverimage(Request $request, $association_id)
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
            $file->storeAs('associations/coverimages', $coverimage_name, 's3');
            
            $data = [
            
                'cover_image' => $coverimage_name,
            ];

            $updated = Association::where('association_id', $association_id)->update($data);

            // return $updated;

            if($updated > 0)
            {
                return response()->json(['status' => true, 'message' => 'Cover Image updated successfully']);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred']);
        }

        return response()->json(['status' => false, 'message' => 'No file selected']);

    }

    public function profile($association_id)
    {
        $associationdetails = Association::where('association_id', $association_id)->orderBy('id', 'DESC')->first();

        if(is_null($associationdetails)) return response()->json(['errors' => 'Association does not exist'], 404);

        $associationbranches = AssociationBranch::where('association_id', $association_id)->orderBy('id', 'DESC')->get();
        $associationevents = AssociationEvent::where('association_id', $association_id)->orderBy('id', 'DESC')->get();
        $associationgalleries = AssociationGallery::where('association_id', $association_id)->get();
        
        return response()->json([
            'associationdetails' => $associationdetails, 
            'associationbranches' => $associationbranches,
            'associationevents' => $associationevents,
            'associationgalleries' => $associationgalleries
        ]);
    }

    public function associationsearch($name)
    {
        $search_results = Association::where('association_name','LIKE','%'.$name.'%')->get();
        return response()->json($search_results);
    }

}
