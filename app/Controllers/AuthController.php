<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;
use App\Models\PasswordResetToken;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];

    //tampilkan page auth login
    public function loginForm()
    {
        $data = [
            'pageTitle' => 'Login',
            'validation' => 'null'
        ];
        return view('backend/pages/auth/login', $data);
    }

    //logic untuk login
    public function loginHandler()
    {
        $fieldType = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL) ? "email" : "username";

        //validasi email
        if ($fieldType == 'email') {
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|valid_email|is_not_unique[users.email]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Email is not valid',
                        'is_not_unique' => 'Email is not registered'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[4]|max_length[45]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password is at least 5 characters',
                        'max_length' => 'Password cannot be more that 45 characters'
                    ]
                ]
            ]);
        } else { //validasi username
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|is_not_unique[users.username]',
                    'errors' => [
                        'required' => 'Username is required',
                        'is_not_unique' => 'Username is not registered'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[45]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password is at least 5 characters',
                        'max_length' => 'Password cannot be more that 45 characters'
                    ]
                ]
            ]);
        }

        //jika validasi error trigger, balik ke login page dengan error
        if (!$isValid) {
            return view('/backend/pages/auth/login', [
                'pageTitle' => 'Login',
                'validation' => $this->validator
            ]);
        } else {
            //jika validasi ok, gonakan model untun ambil data user damin
            $user = new User(); //deklarasi model user
            $userInfo = $user->where($fieldType, $this->request->getVar('login_id'))->first(); //ambil data pertama
            $checkPassword = Hash::check($this->request->getVar('password'), $userInfo['password']); //gunakan librari hash untuk bandingkan password

            //jika checkpassword tidak true redirect ke login form dengan error
            if (!$checkPassword) {
                return redirect()->route('admin.login.form')->with('fail', 'wrong password')->withInput();
            } else { //jika password sama 
                CIAuth::setAuth($userInfo);
                return redirect()->route('admin.home');
            }
        }
    }

    //FORGOT FORM START HERE

    public function forgotForm()
    {
        $data = [
            'pageTitle' => 'Forgot Password',
            'validation' => 'null'
        ];
        return view('/backend/pages/auth/forgot', $data);
    }

    public function sendPasswordResetLink()
    {
        $isValid = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email is not valid',
                    'is_not_unique' => 'Email is not registered'
                ]
            ]
        ]);

        if (!$isValid) {
            return view('/backend/pages/auth/forgot', [
                'pageTitle' => 'Forgot Password',
                'validation' => $this->validator
            ]);
        } else {
            //jika validasi email ok
            //ambil data email dari user
            $user = new User(); //declare user model
            $user_info = $user->asObject()->where('email', $this->request->getVar('email'))->first();

            //generate token dengan 
            $token = bin2hex(openssl_random_pseudo_bytes(65));

            //cek jika token sudah ada
            $password_reset_token = new PasswordResetToken(); //declare model/data password reset token
            $isOldTokenExist = $password_reset_token->asObject()->where('email', $user_info->email)->first();

            if ($isOldTokenExist) {
                //update token terbaru
                $password_reset_token->where('email', $user_info->email)
                    ->set(['token' => $token, 'created_at' => Carbon::now()])
                    ->update();
            } else { //jika tidak ada maka insert token
                $password_reset_token->insert([
                    'email' => $user_info->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
            }

            //buat action link
            //$actionLink = route_to('admin.reset-password',$token);
            $actionLink = base_url(route_to('admin.reset-password', $token));

            $mail_data = array(
                'actionLink' => $actionLink,
                'user' => $user_info,
            );

            $view = \Config\Services::renderer();
            $mail_body = $view->setVar('mail_data', $mail_data)->render('mail-templates/forgot-mail-template');

            //set config untuk phpmailer
            $mailConfig = array(
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => $user_info->email,
                'mail_recipient_name' => $user_info->name,
                'mail_subject' => 'Reset Password',
                'mail_body' => $mail_body
            );

            //kirim email dengan function sendEMail
            if (sendEmail($mailConfig)) {
                return redirect()->route('admin.forgot.form')->with('success', 'Check your email for reset link');
            } else {
                return redirect()->route('admin.forgot.form')->with('fail', 'Oops, something went wrong');
            }
        }
    }

    //RESET PASSWORD START HERE

    public function resetPassword($token)
    {
        $passwordResetPassword = new PasswordResetToken();
        $check_token = $passwordResetPassword->asObject()->where('token', $token)->first();
        if (!$check_token) {
            return redirect()->route('admin.forgot.form')->with('fail', 'Token is invalid, please request a new one');
        } else {
            //cek expired token 15 menit 
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            //jika token sudah 15 menit
            if ($diffMins > 15) {
                return redirect()->route('admin.forgot.form')->with('fail', 'Token Expired');
            } else {
                return view('backend/pages/auth/reset', [
                    'pageTitle' => 'Reset Password',
                    'validation' => null,
                    'token' => $token
                ]);
            }
        }
    }

    public function resetPasswordHandler($token)
    {
        $isValid = $this->validate([
            'new_password' => [
                'rules' => 'required|min_length[8]|max_length[20]|is_password_strong[new_password]',
                'errors' => [
                    'required' => 'Please fill the new password',
                    'min_length' => 'Password must be minimal 8 characters long',
                    'max_length' => 'Maximum is 20 characters',
                    'is_password_strong' => 'Password must have at least 1 Uppercase and Lowercase letter,1 Digit and 1 Special character'
                ]
            ],
            'confirm_new_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Required',
                    'matches' => 'Password do not match'
                ]
            ]
        ]);

        if (!$isValid) {
            return view('/backend/pages/auth/reset', [
                'pageTitle' => "Reset Password",
                'validation' => null,
                'token' => $token
            ]);
        } else {
            //ambil info email dari tabel token
            $passwordResetPassword = new PasswordResetToken();
            $get_tokens = $passwordResetPassword->asObject()->where('token', $token)->first();

            //ambil info admin dengan email dari token
            $user = new User(); //declare user
            $user_info = $user->asObject()->where('email', $get_tokens->email)->first();

            if (!$get_tokens) {
                return redirect()->back()->with('fail', 'Token is invalid');
            } else {
                //update admin password di database
                $user->where('email', $user_info->email)
                    ->set(['password' => Hash::make($this->request->getVar('new_password'))])
                    ->update();

                //kirim email notifikasi
                $mail_data = array( //data untuk dikirim ke mail temlate
                    'user' => $user_info,
                    'new_password' => $this->request->getVar('new_password'),
                );

                $view = \Config\Services::renderer();
                $mail_body = $view->setVar('mail_data', $mail_data)->render('mail-templates/password-changed-email-template');

                //set config untuk phpmailer
                $mailConfig = array(
                    'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name' => env('EMAIL_FROM_NAME'),
                    'mail_recipient_email' => $user_info->email,
                    'mail_recipient_name' => $user_info->name,
                    'mail_subject' => 'Reset Password',
                    'mail_body' => $mail_body
                );

                //send email dan cek result
                if (sendEmail($mailConfig)) {
                    //hapus token dari db
                    $passwordResetPassword->where('email', $user_info->email)->delete();

                    //kembali ke login page
                    return redirect()->route('admin.login.form')->with('success', 'Your password has been changed');
                } else {
                    return redirect()->back()->with('fail', 'Oops, something went wrong')->withInput();
                }
            }
        }
    }
}
