<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')){
           
            $data = $request->all();

            $validated = $request->validate([
                'email' => 'required|exists:admins|max:255',
                'password' => 'required',
            ]);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']]))
            {
                return redirect('admin/dashboard');
            }else{
                
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }

            }
       return view('admin.adminlogin');

    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function CheckAdminPassword(Request $request)
    {

        $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // die;
        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }

    public function ChangePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //check If Current Password enterted by admin is correct
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                //Check if New Password is matching with conifrm Password
                if ($data['confirm_pasword'] == $data['new_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Your  Password Is Updated Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Your New Password is Not Match With Confirm Password');
                }
            } else
                return redirect()->back()->with('error_message', 'Your Current Password Is Incorrect');
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
       return view('admin.change_password')->with(compact('adminDetails'));
    }
     public function forgetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data= $request->all();
        //   echo"<pre>"; print_r($data); die;
          

                $validated = $request->validate([
                    'email' => 'required|exists:admins|max:255',
                    
                ]);

              
                    // gerenter new password
                    $new_password = Str::random(16);
                    //update password
                    Admin::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);
                    // Get user Details
                    $userDetails = Admin::where('email',$data['email'])->first()->toArray();
                    //send email to user
                     $email = $data['email'];
                     $messageData = ['name'=>$userDetails['name'],'mobile'=>$userDetails['mobile'],'email'=>$email,'password'=>$new_password];
                     Mail::send('admin.emails.forgot_password',$messageData,function($message)use($email){
                      $message->to($email)->subject('PasswordReset');
                  });

                    $to = 'info@dunkelbeverage.com';
                    //  $to = 'bit16cs51@bit.ac.in';
            
            
                    $subject = 'PasswordReset';
                    $message = "";
                    $message .= '
                  <html>
                  <head>
                    <title>Dunkel Deverage</title>
                  </head>
                  <body>
                    <p><b>Welcome to Dunkel Deverage  </b><br><br></p>
                    <table>
                     <tr>
                        <td><b>Eamil :</b></td>
                        <td> ' .$email. ' </td>
                      </tr>
                      <tr>
                        <td><b>Password :</b></td>
                        <td> ' .$new_password. ' </td>
                      </tr>
                     
                    </table>
                  </body>
                  </html>
                  ';
                  
                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                  
                    // More headers
                    $headers .= 'From: <' .$data['email']. '>' . "\r\n";
            if (mail($to, $subject, $message, $headers)) {
                return redirect()->back()->with('success_message', 'New Password Sent To Your Register Email');

            }else{
                return redirect()->back()->with('success_message', 'New Password Not Send To Your Register Email');

            }
                   


                }


 
            // return view('admin.forget_password');
    


    }
}
