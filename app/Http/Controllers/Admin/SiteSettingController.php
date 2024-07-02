<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SiteSettingController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::first();
        return view('admin.sitesettings.create',compact('setting'));
    }

    public function store(Request $request)
    {
       $setting = SiteSetting::first();

       $validated = $request->validate([

        'about_image1' => 'mimetypes:image/jpeg,image/png,image/jpg',
        'about_image2' => 'mimetypes:image/jpeg,image/png,image/jpg',
        'about_image3' => 'mimetypes:image/jpeg,image/png,image/jpg',
        'about_image4' => 'mimetypes:image/jpeg,image/png,image/jpg',
                                 
   ]);

       if ($request->hasFile('about_image1')) {
        $image_tmp = $request->file('about_image1');
        if ($image_tmp->isValid()) {
            $extension = $image_tmp->getClientOriginalExtension();
            $imageName = rand(111, 99999) . '.' . $extension;
            $imagePath = 'front_assets/aboutus_image/' . $imageName;
            Image::make($image_tmp)->save($imagePath);
          
        }
    } elseif (!empty($request->current_aboutus_image1)) {
        $imageName = $request->current_aboutus_image1;
    } else {
        $imageName = "";
    }

    if ($request->hasFile('about_image2')) {
        $image_tmp = $request->file('about_image2');
        if ($image_tmp->isValid()) {
            $extension = $image_tmp->getClientOriginalExtension();
            $imageName2 = rand(111, 99999) . '.' . $extension;
            $imagePath2 = 'front_assets/aboutus_image/' . $imageName2;
            Image::make($image_tmp)->save($imagePath2);
          
        }
    } elseif (!empty($request->current_aboutus_image2)) {
        $imageName2 = $request->current_aboutus_image2;
    } else {
        $imageName2 = "";
    }

    if ($request->hasFile('about_image3')) {
        $image_tmp = $request->file('about_image3');
        if ($image_tmp->isValid()) {
            $extension = $image_tmp->getClientOriginalExtension();
            $imageName3 = rand(111, 99999) . '.' . $extension;
            $imagePath3 = 'front_assets/aboutus_image/' . $imageName3;
            Image::make($image_tmp)->save($imagePath3);
          
        }
    } elseif (!empty($request->current_aboutus_image3)) {
        $imageName3 = $request->current_aboutus_image3;
    } else {
        $imageName3 = "";
    }

    if ($request->hasFile('about_image4')) {
        $image_tmp = $request->file('about_image4');
        if ($image_tmp->isValid()) {
            $extension = $image_tmp->getClientOriginalExtension();
            $imageName4 = rand(111, 99999) . '.' . $extension;
            $imagePath4 = 'front_assets/aboutus_image/' . $imageName4;
            Image::make($image_tmp)->save($imagePath4);
          
        }
    } elseif (!empty($request->current_aboutus_image4)) {
        $imageName4 = $request->current_aboutus_image4;
    } else {
        $imageName4 = "";
    }




       if($setting)
       {
           $setting->update([
            'about_image1' => $imageName,
            'about_image2' => $imageName2,
            'about_image3' => $imageName3,
            'about_image4' => $imageName4,
            'total_exp' => $request->total_exp,
            'master_chefs' => $request->master_chefs,
            'about_description' => $request->about_description,
            'privacy_policy' => $request->privacy_policy,
            'term_condition' => $request->term_condition,

            'monday_saturday' => $request->monday_saturday,
            'sunday' => $request->sunday,


            'website_name' => $request->website_name,
            'website_url' => $request->website_url,
            'email' => $request->email,
            'phone' => $request->phone,
           
            'addresss' => $request->addresss,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,



         


           ]);
           return redirect()->back()->with('message','Setting Updated');
       }
       else
       {

        SiteSetting::create([

            'about_image1' => $imageName,
            'about_image2' => $imageName2,
            'about_image3' => $imageName3,
            'about_image4' => $imageName4,
            'total_exp' => $request->total_exp,
            'master_chefs' => $request->master_chefs,
            'about_description' => $request->about_description,
            'privacy_policy' => $request->privacy_policy,
            'term_condition' => $request->term_condition,

            'website_name' => $request->website_name,
            'website_url' => $request->website_url,
            'email' => $request->email,
            'phone' => $request->phone,
            'addresss' => $request->addresss,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube
        ]);

        return redirect()->back()->with('message','Setting Created');

       }
    }
}
