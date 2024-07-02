@extends('admin.layouts.layout')

@section('title','Site Setting')

@section('content')
<div class="row">
    <div class="col-md-12 grid margin">

        @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{Session::get('error_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success:</strong> {{Session::get('success_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <form action="{{ url('admin/settings') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">Website</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Website Name</label>
                            <input type="text" name="website_name" value="{{ $setting->website_name ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Website Url</label>
                            <input type="text" name="website_url" value="{{ $setting->website_url ?? ''}}" class="form-control" />
                        </div>
                       

                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">Website-Information</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Website Email </label>
                            <input type="email" name="email" value="{{ $setting->email ?? '' }}" class="form-control" />
                        </div>
                    
                        <div class="col-md-6 mb-3">
                            <label>Website Phone </label>
                            <input type="number" name="phone" value="{{ $setting->phone ?? ''}}" class="form-control" />
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label>Opening Time Monday - Saturday (like - 10:00 AM- 11:00PM) </label>
                            <input type="text" name="monday_saturday" value="{{ $setting->monday_saturday ?? ''}}" class="form-control" />
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label>Opening Time Sunday  (like - 10:00 AM- 11:00PM) </label>
                            <input type="text" name="sunday" value="{{ $setting->sunday ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Address</label>
                            <textarea name="addresss"  class="form-control" rows="3">{{ $setting->addresss ?? ''}}</textarea>
                        </div>



                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">About Us</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>About Us Image 1 </label>
                            <input type="file" name="about_image1"  class="form-control" />
                            @if (!empty($setting->about_image1))
                            <a target="_blank"
                                href="{{ url('front_assets/aboutus_image/' . $setting->about_image1) }}">View
                                Image</a>&nbsp;&nbsp;
                            <div><img style="width: 60px; height:60px;"s
                                    src="{{ url('front_assets/aboutus_image/' . $setting->about_image1) }}"
                                    alt=""></div>

                            <input type="hidden" name="current_aboutus_image1"
                                value="{{ $setting->about_image1 }}">
                        @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>About Us Image 2 </label>
                            <input type="file" name="about_image2"  class="form-control" />
                            @if (!empty($setting->about_image2))
                            <a target="_blank"
                                href="{{ url('front_assets/aboutus_image/' . $setting->about_image2) }}">View
                                Image</a>&nbsp;&nbsp;
                            <div><img style="width: 60px; height:60px;"s
                                    src="{{ url('front_assets/aboutus_image/' . $setting->about_image2) }}"
                                    alt=""></div>

                            <input type="hidden" name="current_aboutus_image2"
                                value="{{ $setting->about_image2 }}">
                        @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>About Us Image 3 </label>
                            <input type="file" name="about_image3"  class="form-control" />
                            @if (!empty($setting->about_image3))
                            <a target="_blank"
                                href="{{ url('front_assets/aboutus_image/' . $setting->about_image3) }}">View
                                Image</a>&nbsp;&nbsp;
                            <div><img style="width: 60px; height:60px;"s
                                    src="{{ url('front_assets/aboutus_image/' . $setting->about_image3) }}"
                                    alt=""></div>

                            <input type="hidden" name="current_aboutus_image3"
                                value="{{ $setting->about_image3 }}">
                        @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>About Us Image 4 </label>
                            <input type="file" name="about_image4" value="{{ $setting->about_image4 ?? '' }}" class="form-control" />
                            @if (!empty($setting->about_image4))
                            <a target="_blank"
                                href="{{ url('front_assets/aboutus_image/' . $setting->about_image4) }}">View
                                Image</a>&nbsp;&nbsp;
                            <div><img style="width: 60px; height:60px;"s
                                    src="{{ url('front_assets/aboutus_image/' . $setting->about_image4) }}"
                                    alt=""></div>

                            <input type="hidden" name="current_aboutus_image4"
                                value="{{ $setting->about_image4 }}">
                        @endif
                        </div>
                    
                        <div class="col-md-6 mb-3">
                            <label>Total EXPERIENCE</label>
                            <input type="number" name="total_exp" value="{{ $setting->total_exp ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>MASTER CHEFS</label>
                            <input type="number" name="master_chefs" value="{{ $setting->master_chefs ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>About Us Description</label>
                            <textarea name="about_description"  class="form-control" rows="5">{{ $setting->about_description ?? ''}}</textarea>
                        </div>



                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">Privacy Policy </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <textarea name="privacy_policy"  class="form-control" rows="5">{{ $setting->privacy_policy ?? ''}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">Terms and Conditions </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <textarea name="term_condition"  class="form-control" rows="5">{{ $setting->term_condition ?? ''}}</textarea>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">Website- Social Media</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Facebook (Optional)</label>
                            <input type="text" name="facebook"  value="{{ $setting->facebook ?? '' }}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Twitter (Optional)</label>
                            <input type="text" name="twitter" value="{{ $setting->twitter ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Instagram (Optional)</label>
                            <input type="text" name="instagram"  value="{{ $setting->instagram ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>YouTube (Optional)</label>
                            <input type="text" name="youtube"  value="{{ $setting->youtube ?? ''}}" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">Website- About Us</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>About Us Title</label>
                            <input type="text" name="about_us_title"  value="{{ $setting->about_us_title ?? '' }}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>About Us Description</label>
                            <input type="text" name="about_us_description" value="{{ $setting->about_us_description ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Company Total Exp</label>
                            <input type="text" name="company_exp"  value="{{ $setting->company_exp ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Total Happy Paitent </label>
                            <input type="text" name="happy_paitent"  value="{{ $setting->happy_paitent }}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Total Doctors </label>
                            <input type="text" name="specialist_doctors"  value="{{ $setting->specialist_doctors }}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Total Hospital</label>
                            <input type="text" name="specialist_hospital"  value="{{ $setting->specialist_hospital }}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Total Pathology </label>
                            <input type="text" name="specialist_pathology"  value="{{ $setting->specialist_pathology }}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Total Ambulance </label>
                            <input type="text" name="ambulance"  value="{{ $setting->ambulance }}" class="form-control" />
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary text-white ">Save Setting</button>
            </div>
        </form>
    </div>
</div>

@endsection