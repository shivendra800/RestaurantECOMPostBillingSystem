<?php

namespace App\Http\Controllers\Admin;


use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    public function index()
    {
        Session::put('page', 'banners');
        $banners = Slider::get()->toArray();
          return view('admin.sitesettings.slider.sliderlist')->with(compact('banners'));
    }

    public function DeleteBanner($id)
    {
        $bannerImage=  Slider::where('id', $id)->first();

        //Get Banner Image Path
        $bannner_image_path='front_assets/img/slider/';

        //Delete banner image from folder if it exist
        if(file_exists($bannner_image_path.$bannerImage->image)){
              unlink($bannner_image_path.$bannerImage->image);
        }
        //Delete Banner from Banner table
        Slider::where('id', $id)->delete();
        $message = "Banner Image has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    public function AddBannerImage(Request $request, $id = null)
    {
        Session::put('page', 'banners');
        if ($id == "") {
            $title = "Add Banner";
            $banner = new Slider;
            $message = "Banner Add Successfully!";
        } else {
            $title = "Edit banner";
            $banner = Slider::find($id);
            $message = "banner Update Successfully!";
        }


        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
                $rules = [

                    'image'=>   'required|mimetypes:image/jpeg,image/png,image/jpg',
                ];

                $this->validate($request, $rules);
            if($data['type']=="Slider"){
                $width="1366";
                $height="800";
             
            } elseif($data['type']=="Fix"){
                $width= "1700";
                $height="450";
            } elseif($data['type']=="About-us"){
                $width= "700";
                $height="621";
            }

            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {

                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front_assets/img/slider/' . $imageName;
                    //Upload The Image
                    Image::make($image_tmp)->resize($width,$height)->save($imagePath);
                }
            } else if (!empty($data['current_image'])) {
                $imageName = $data['current_image'];
            } else {
                $imageName = "";
            }

            $banner->type = $data['type'];
            $banner->title = $data['title'];
            $banner->link = $data['link'];
             $banner->image=$imageName;
            $banner->alt = $data['alt'];
            $banner->status = 1;
            $banner->save();



            return redirect('admin/slider')->with('success_message', $message);
        }
        //  echo "test"; die;
        return view('admin.sitesettings.slider.addslide')->with(compact('title', 'banner'));
    }


}
