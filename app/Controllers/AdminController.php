<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Post;
use Config\Services;
use Mberecall\CodeIgniter\Library\Slugify;

class AdminController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];

    public function index()
    {
        $post = new Post();
        $subcategory = new SubCategory();
        $category = new Category();
        $npost = $post->where('visibility', 1)->countAllResults();
        $latest = $post->select('title,posts.slug,name')->asObject()->join('sub_categories', 'sub_categories.id = posts.category_id', 'left')->where('visibility', 1)->orderBy('posts.created_at', 'DESC')->findAll(5);
        $nsub = $subcategory->countAllResults();
        $categories = $category->select('name')->asObject()->findAll();
        $data = [
            'pageTitle' => 'Dashboard',
            'numberOfPosts' => $npost,
            'numberOfSubCategories' => $nsub,
            'categories' => $categories,
            'latestPosts' => $latest
        ];
        return view('backend/pages/home', $data);
    }

    public function logoutHandler()
    {
        CIAuth::forget();
        return redirect()->route('admin.login.form')->with('fail', 'You are logged out');
    }

    //Profile view
    public function profile()
    {
        $data = array(
            'pageTitle' => 'Profile Page',
        );
        return view('/backend/pages/profile', $data);
    }

    public function updatePersonalDetails()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $user_id = CIAuth::id();


        $this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Name is required'
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[4]|is_unique[users.username,id,' . $user_id . ']',
                'errors' => [
                    'required' => 'username is required',
                    'min_length' => 'must at least 4 character',
                    'is_unique' => 'username is taken'

                ]
            ]
        ]);

        if ($validation->run() == FALSE) {
            $errors = $validation->getErrors();
            return json_encode(['status' => 0, 'error' => $errors]);
        } else {
            $user = new User();
            $update = $user->where('id', $user_id)
                ->set(['name' => $request->getVar('name'), 'username' => $request->getVar('username'), 'bio' => $request->getVar('bio')])
                ->update();
            if ($update) {
                $user_info = $user->find($user_id);
                return json_encode(['status' => 1, 'user_info' => $user_info, 'msg' => 'update sukses']);
            } else {
                return json_encode(['status' => 0, 'msg' => 'update gagal']);
            }
        }
    }

    // upload dan update picture database
    public function updateProfilePicture()
    {
        $request = \Config\Services::request();
        $user_id = CIAuth::id();
        $user = new User();
        $user_info = $user->asObject()->where('id', $user_id)->first();

        $path = 'images/users/';
        $file = $request->getFile('user_profile_file');
        $old_picture = $user_info->picture;
        $new_filename = 'UIMG_' . $user_id . $file->getRandomName();

        if ($file->move($path, $new_filename)) {
            if ($old_picture != null && file_exists($path . $old_picture)) {
                unlink($path . $old_picture);
            }
            $user->where('id', $user_id)
                ->set(['picture' => $new_filename])->update();

            echo json_encode(['status' => 1, 'msg' => 'sukses']);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'something went wrong']);
        }
    }

    // method update password
    public function changePassword()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $user_id = CIAuth::id();
        $user = new User();
        $user_info = $user->asObject()->where('id', $user_id)->first();

        $this->validate([
            'current_password' => [
                'rules' => 'required|min_length[8]|check_current_password[current_password]',
                'errors' => [
                    'required' => 'Required',
                    'min_length' => 'need at leas 8 character',
                    'check_current_password' => 'password is wrong'
                ]
            ],
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
                    'required' => 'required',
                    'matches' => 'new password do not match'
                ]
            ]
        ]);

        if ($validation->run() == FALSE) {
            //jika validasi error, kirim error ke front end
            $errors = $validation->getErrors();
            return json_encode(['status' => 0, 'error' => $errors]);
            // return $this->response->setJSON(['status' => 0, 'error' => $errors]);
        } else {
            //update database
            $user->where('id', $user_id)
                ->set(['password' => Hash::make($request->getVar('new_password'))])
                ->update();

            //kirim email notifikasi
            $mail_data = array( //data untuk dikirim ke mail temlate
                'user' => $user_info,
                'new_password' => $request->getVar('new_password'),
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

            sendEmail($mailConfig);
            return $this->response->setJSON(['status' => 1, 'msg' => 'your password has been changed']);
        }
    }

    //view page setting
    public function settings()
    {
        $data = [
            'pageTitle' => 'Settings'
        ];

        return view('/backend/pages/settings', $data);
    }

    //function update general setting
    public function updateGeneralSettings()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $settings_id = get_settings()->id;

        $this->validate([
            'blog_title' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'cannot be empty'
                ]
            ],
            'blog_email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'cannot be empty',
                    'valid_email' => 'email is not valid'
                ]
            ]
        ]);

        if ($validation->run() == FALSE) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['status' => 0, 'error' => $errors]);
        } else {
            $settings = new Setting();
            $settings_id = $settings->asObject()->first()->id;
            $update =   $settings->where('id', $settings_id)
                ->set([
                    'blog_title' => $request->getVar('blog_title'),
                    'blog_email' => $request->getVar('blog_email'),
                    'blog_phone' => $request->getVar('blog_phone'),
                    'blog_meta_keywords' => $request->getVar('blog_meta_keywords'),
                    'blog_meta_description' => $request->getVar('blog_meta_description'),
                ])
                ->update();

            if ($update) {
                return $this->response->setJSON(['status' => 1, 'msg' => 'update success']);
            } else {
                return json_encode(['status' => 0, 'msg' => 'something went wrong']);
            }
        }
    }

    // update blog logo 
    public function updateBlogLogo()
    {
        $request = \Config\Services::request();
        $settings = new Setting();

        $path = 'images/blog/';
        $file = $request->getFile('blog_logo');
        $settings_data = $settings->asObject()->first();

        $old_blog_logo = $settings_data->blog_logo;
        $new_blog_logo = 'logo' . $file->getRandomName();

        if ($file->move($path, $new_blog_logo)) {
            if ($old_blog_logo != null && file_exists($path . $old_blog_logo)) {
                unlink($path . $old_blog_logo);
            }
            $update = $settings->where('id', $settings_data->id)->set(['blog_logo' => $new_blog_logo])->update();
            if ($update) {
                echo json_encode(['status' => 1, 'msg' => 'logo diganti']);
            } else {
                echo json_encode(['status' => 1, 'msg' => 'logo error']);
            }
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'something went wrong']);
        }
    }

    //update favicon
    public function updateBlogFavicon()
    {
        $request = \Config\Services::request();
        $settings = new Setting();

        $path = 'images/blog/';
        $file = $request->getFile('blog_favicon');
        $settings_data = $settings->asObject()->first();

        $old_blog_favicon = $settings_data->blog_favicon;
        $new_blog_favicon = 'favicon' . $file->getRandomName();

        if ($file->move($path, $new_blog_favicon)) {
            if ($old_blog_favicon != null && file_exists($path . $old_blog_favicon)) {
                unlink($path . $old_blog_favicon);
            }
            $update = $settings->where('id', $settings_data->id)->set(['blog_favicon' => $new_blog_favicon])->update();
            if ($update) {
                echo json_encode(['status' => 1, 'msg' => 'favicon diganti']);
            } else {
                echo json_encode(['status' => 1, 'msg' => 'favicon error']);
            }
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'something went wrong']);
        }
    }

    //function update social media
    public function updateSocialMedia()
    {
        $request = $this->request;
        $validation = \Config\Services::validation();

        if ($request->isAJAX()) {
            $this->validate([
                'facebook_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Entered URL is not valid'
                    ]
                ],
                'twitter_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Entered URL is not valid'
                    ]
                ],
                'instagram_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Entered URL is not valid'
                    ]
                ],
                'youtube_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Entered URL is not valid'
                    ]
                ],
                'github_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Entered URL is not valid'
                    ]
                ],
                'linkedin_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Entered URL is not valid'
                    ]
                ]
            ]);
        }

        if ($validation->run() == FALSE) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['status' => 0, 'error' => $errors]);
        } else {
            $social_media = new SocialMedia(); //declare model
            $social_media_id = $social_media->asObject()->first()->id;

            $update = $social_media->where('id', $social_media_id)
                ->set([
                    'facebook_url' => $request->getVar('facebook_url'),
                    'twitter_url' => $request->getVar('twitter_url'),
                    'instagram_url' => $request->getVar('instagram_url'),
                    'youtube_url' => $request->getVar('youtube_url'),
                    'github_url' => $request->getVar('github_url'),
                    'linkedin_url' => $request->getVar('linkedin_url'),
                ])->update();
            if ($update) {
                return $this->response->setJSON(['status' => 1, 'msg' => 'updated']);
            } else {
                return $this->response->setJSON(['status' => 0, 'msg' => 'something went wrong']);
            }
        }
    }

    // view categories page
    public function categories()
    {
        $data = [
            'pageTitle' => 'Categories'
        ];
        return view('/backend/pages/categories', $data);
    }

    //insert category
    public function addCategory()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $this->validate([
            'category_name' => [
                'rules' => 'required|is_unique[categories.name]',
                'errors' => [
                    'required' => 'required',
                    'is_unique' => 'This category already exist'
                ]
            ]
        ]);

        if ($validation->run() == FALSE) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['status' => 0, 'error' => $errors]);
        } else {
            $category = new Category();
            if ($request->getVar('category_id') != "") {
                $save = $category->where('id', $request->getVar('category_id'))->set(['name' => $request->getVar('category_name')])->update();
                $msg = "Edit Success";
            } else {
                $save = $category->save(['name' => $request->getVar('category_name')]);
                $msg = "Add Success";
            }

            if ($save) {
                return $this->response->setJSON(['status' => 1, 'msg' => $msg]);
            } else {
                return $this->response->setJSON(['status' => 1, 'msg' => 'something went wrong']);
            }
        }
    }

    //get categories untuk datatabel
    public function getCategories()
    {
        $request = \Config\Services::request();
        //print_r($request->getGet());
        $length = $request->getGet('length');
        $start = $request->getGet('start');
        $search = $request->getGet('search')['value'];
        $orderDir = $request->getGet('order')[0]['dir'];
        $order = $request->getGet('order')[0]['column'];
        switch ($order) {
            case 0:
                $order = 'categories.id';
                break;
            case 1:
                $order = 'categories.name';
                break;
        }

        $category = new Category();
        $subcategory = new SubCategory();
        $countSubCategory = $subcategory->findAll();
        $category_length = $category->countAllResults();
        if ($search != '') {
            $category_data = $category->select('categories.id,categories.name,count(sub_categories.parent_cat) as subcategory')->join('sub_categories', 'sub_categories.parent_cat=categories.id', 'left')->orLike(['categories.name' => $search, 'categories.id' => $search])->asArray()->orderBy($order, $orderDir)->groupBy('categories.id')->findAll($length, $start);
            $category_filtered = count($category_data);
        } else {
            $category_data = $category->select('categories.id,categories.name,count(sub_categories.parent_cat) as subcategory')->join('sub_categories', 'sub_categories.parent_cat=categories.id', 'left')->asArray()->orderBy($order, $orderDir)->groupBy('categories.id')->findAll($length, $start);
            $category_filtered = $category_length;
        }
        return $this->response->setJSON([
            "recordsTotal" => $category_length,
            "recordsFiltered" => $category_filtered,
            'data' => $category_data
        ]);
    }

    //delete categories
    public function deleteCategory($id)
    {
        $category = new Category();
        $subcategory = new SubCategory();
        if ($subcategory->where('parent_cat', $id)->countAllResults() > 0) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Gagal Menghapus Data, Category Tidak Kosong']);
        } else {
            $delete = $category->delete(['id' => $id]);
            if ($delete) {
                return $this->response->setJSON(['status' => 1, 'msg' => 'Data Dihapus']);
            } else {
                return $this->response->setJSON(['status' => 0, 'msg' => 'Gagal Hapus Data']);
            }
        }
    }

    public function getCategoryName()
    {
        $id = $this->request->getVar('id');
        $category = new Category();
        $get_name = $category->asObject()->find($id);
        return $this->response->setJSON(['name' => $get_name->name]);
    }

    public function getParentCategories()
    {
        $options = '<option value="0">Uncategorized</option>';
        $category = new Category();
        $parent_categories = $category->findAll();

        if ($parent_categories) {
            $added_options = "";
            foreach ($parent_categories as $parent_category) {
                $added_options = '<option value="' . $parent_category['id'] . '">' . $parent_category['name'] . '</option>';
                $options = $options . $added_options;
            }
            return $this->response->setJSON(['status' => 1, 'data' => $options]);
        }
    }

    public function addSubCategory()
    {
        $validation = \Config\Services::validation();
        if ($this->request->isAJAX()) {
            $this->validate([
                'sub_category_id' => [
                    'rules' => 'permit_empty'
                ],
                'sub_category_name' => [
                    'rules' => 'required|is_unique[sub_categories.name,id,{sub_category_id}]',
                    'errors' => [
                        'required' => 'required',
                        'is_unique' => 'This category already exist'
                    ]
                ]
            ]);
        }

        if ($validation->run() == FALSE) {
            $error = $validation->getErrors();
            return $this->response->setJSON(['status' => 0, 'error' => $error]);
        } else {
            $subcategory = new SubCategory();
            $request = $this->request;
            if ($request->getVar('sub_category_id') != '') {
                $save = $subcategory->where(['id' => $request->getVar('sub_category_id')])
                    ->set([
                        'name' => $request->getVar('sub_category_name'),
                        'slug' => Slugify::model(SubCategory::class)->make($request->getVar('sub_category_name')),
                        'parent_cat' => $request->getVar('parent_cat'),
                        'description' => $request->getVar('sub_category_description')
                    ])->update();
                $msg = 'Sub category edited';
            } else {
                $save = $subcategory->save([
                    'name' => $request->getVar('sub_category_name'),
                    'slug' => Slugify::model(SubCategory::class)->make($request->getVar('sub_category_name')),
                    'parent_cat' => $request->getVar('parent_cat'),
                    'description' => $request->getVar('sub_category_description')
                ]);
                $msg = 'sub category added';
            }
            if ($save) {
                return $this->response->setJSON(['status' => 1, 'msg' => $msg]);
            } else {
                return $this->response->setJSON(['status' => 1, 'msg' => $msg]);
            }
        }
    }

    public function getSubCategories()
    {
        $request = \Config\Services::request();
        //print_r($request->getGet());
        $length = $request->getGet('length');
        $start = $request->getGet('start');
        $search = $request->getGet('search')['value'];
        $orderDir = $request->getGet('order')[0]['dir'];
        $order = $request->getGet('order')[0]['column'];
        switch ($order) {
            case 0:
                $order = 'sub_categories.id';
                break;
            case 1:
                $order = 'sub_categories.name';
                break;
            case 2:
                $order = 'categories.name';
                break;
            case 3:
                $order = 'posts';
                break;
        }

        $subcategory = new SubCategory();
        $subcategory_length = $subcategory->countAllResults();
        if ($search != '') {
            $subcategory_data = $subcategory->select('sub_categories.id,sub_categories.name as sbname,categories.name, count(posts.category_id) as posts')->orLike(['sub_categories.name' => $search, 'categories.name' => $search, 'sub_categories.id' => $search])->join('categories', 'categories.id=sub_categories.parent_cat', 'right')->join('posts', 'posts.category_id=sub_categories.id', 'left')->groupBy('sub_categories.id')->asArray()->orderBy($order, $orderDir)->findAll($length, $start);
            $subcategory_filtered = count($subcategory_data);
        } else {
            $subcategory_data = $subcategory->select('sub_categories.id,sub_categories.name as sbname,categories.name,count(posts.category_id) as posts')->asArray()->orderBy($order, $orderDir)->join('categories', 'categories.id=sub_categories.parent_cat', 'left')->join('posts', 'posts.category_id=sub_categories.id', 'left')->groupBy('sub_categories.id')->findAll($length, $start);
            $subcategory_filtered = $subcategory_length;
        }
        return $this->response->setJSON([
            "recordsTotal" => $subcategory_length,
            "recordsFiltered" => $subcategory_filtered,
            'data' => $subcategory_data
        ]);
    }

    public function getSubCategoryEdit()
    {
        $id = $this->request->getVar('id');
        $subcategory = new SubCategory();
        $get_data = $subcategory->asObject()->find($id);
        return $this->response->setJSON($get_data);
    }

    public function deleteSubCategory()
    {
        $id = $this->request->getVar('id');
        $post = new Post();
        if ($post->where('category_id', $id)->countAllResults() > 0) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Tidak bisa dihapus karena ada post dengan kategori ini']);
        } else {
            $subcategory = new SubCategory();
            $delete = $subcategory->delete(['id' => $id]);
            if ($delete) {
                return $this->response->setJSON(['status' => 1, 'msg' => 'Data Dihapus']);
            } else {
                return $this->response->setJSON(['status' => 0, 'msg' => 'Gagal Hapus Data']);
            }
        }
    }

    public function addPost()
    {
        $subcategories = new SubCategory();
        $data = [
            'pageTitle' => 'New Post',
            'categories' => $subcategories->asObject()->findAll()
        ];
        return view('backend/pages/new-post', $data);
    }

    public function createPost()
    {
        $request = \Config\Services::request();
        $validation =  \Config\Services::validation();
        if ($this->request->isAJAX()) {
            $this->validate([
                'title' => [
                    'rules' => 'required|is_unique[posts.title]',
                    'errors' => [
                        'required' => 'Title is required',
                        'is_unique' => 'Title already exist'
                    ]
                ],
                'content' => [
                    'rules' => 'required|min_length[20]',
                    'errors' => [
                        'required' => 'Content is required',
                        'min_length' => 'Content must be at least 20 characters long'
                    ]
                ],
                'category' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Category is required'
                    ]
                ],
                'image' => [
                    'rules' => 'uploaded[image]|max_size[image,2048]|is_image[image]',
                    'errors' => [
                        'uploaded' => 'Please select an image',
                        'max_size' => 'Image size should not exceed 2 MB',
                        'is_image' => 'Please select a valid image file'
                    ]
                ]
            ]);
        }

        if ($validation->run() == FALSE) {
            $error = $validation->getErrors();
            return $this->response->setJSON(['status' => 0, 'error' => $error]);
        } else {
            //return $this->response->setJSON(['status' => 1, 'msg' => 'success']);
            $user_id = CIAuth::id();
            $path = 'images/posts/';
            $file = $request->getFile('image');
            $filename = $file->getFilename();

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            if ($file->move($path, $filename)) {
                //create thumbail img
                \Config\Services::image()
                    ->withFile($path . $filename)
                    ->fit(150, 150, 'center')
                    ->save($path . 'thumb_' . $filename);

                //create resized image 450x300
                \Config\Services::image()
                    ->withFile($path . $filename)
                    ->fit(450, 300, 'center')
                    ->save($path . 'resized_' . $filename);

                $post = new Post();
                $data = [
                    'title' => $this->request->getVar('title'),
                    'content' => $this->request->getVar('content'),
                    'meta_keywords' => $this->request->getVar('meta_keywords'),
                    'meta_description' => $this->request->getVar('meta_description'),
                    'category_id' => $this->request->getVar('category'),
                    'image' => $filename,
                    'author_id' => $user_id,
                    'visibility' => $this->request->getVar('visibility'),
                    'slug' => Slugify::model(Post::class)->make($this->request->getVar('title')),
                    'tags' => $this->request->getVar('tags')
                ];

                $save = $post->insert($data);
                $last_id = $post->getInsertID();

                if ($save) {
                    return $this->response->setJSON(['status' => 1, 'msg' => 'success']);
                } else {
                    return $this->response->setJSON(['status' => 0, 'msg' => 'something went wrong']);
                }
            } else {
                //return error
                return $this->response->setJSON(['status' => 0, 'msg' => 'something went wrong']);
            }
        }
    }

    public function posts()
    {
        $data = [
            'pageTitle' => 'Posts'

        ];
        return view('backend/pages/posts', $data);
    }

    public function getPosts()
    {
        $request = \Config\Services::request();
        //print_r($request->getGet());
        $length = $request->getGet('length');
        $start = $request->getGet('start');
        $search = $request->getGet('search')['value'];
        $orderDir = $request->getGet('order')[0]['dir'];
        $order = $request->getGet('order')[0]['column'];
        switch ($order) {
            case 0:
                $order = 'id';
                break;
            case 2:
                $order = 'title';
                break;
            case 3:
                $order = 'category_id';
                break;
            case 4:
                $order = 'visibility';
                break;
            default:
                $order = 'id';
        }

        $posts = new Post();
        $post_length = $posts->countAllResults();
        $posts_filtered = $post_length;
        if ($search != '') {
            $posts_data = $posts->select('posts.id, title, image, sub_categories.name as category, visibility')->join('sub_categories', 'sub_categories.id=posts.category_id', 'left')->orLike(['title' => $search, 'id' => $search])->asArray()->orderBy($order, $orderDir)->findAll($length, $start);
            $posts_filtered = count($posts_data);
        } else {
            $posts_data = $posts->select('posts.id, title, image, sub_categories.name as category, visibility')->join('sub_categories', 'sub_categories.id=posts.category_id', 'left')->asArray()->orderBy($order, $orderDir)->findAll($length, $start);
            $posts_filtered = $post_length;
        }
        //print_r($posts_data);
        return $this->response->setJSON(['data' => $posts_data, 'recordsTotal' => $post_length, 'recordsFiltered' => $posts_filtered]);
    }

    public function editPost($id)
    {
        $post = new Post();
        $category = new SubCategory();
        $data = [
            'pageTitle' => 'Edit Post',
            'post' => $post->where('id', $id)->first(),
            'categories' => $category->asObject()->findAll()
        ];
        return view('backend/pages/edit-post', $data);
    }

    public function updatePost()
    {
        $post = new Post();
        $user_id = CIAuth::id();
        $id = $this->request->getVar('id');
        $request = \Config\Services::request();
        $validation =  \Config\Services::validation();
        if ($this->request->isAJAX()) {
            $this->validate([
                'title' => [
                    'rules' => 'required|is_unique[posts.title,id,' . $id . ']',
                    'errors' => [
                        'required' => 'Title is required',
                        'is_unique' => 'Title already exist'
                    ]
                ],
                'content' => [
                    'rules' => 'required|min_length[20]',
                    'errors' => [
                        'required' => 'Content is required',
                        'min_length' => 'Content must be at least 20 characters long'
                    ]
                ],
                'category' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Category is required'
                    ]
                ],
                'image' => [
                    'rules' => 'max_size[image,2048]|is_image[image]|is_unique[posts.image]',
                    'errors' => [
                        'max_size' => 'Image size should not exceed 2 MB',
                        'is_image' => 'Please select a valid image file',
                        'is_unique' => 'Image already exist'
                    ]
                ]
            ]);
        }

        if ($validation->run() == FALSE) {
            $error = $validation->getErrors();
            return $this->response->setJSON(['status' => 0, 'error' => $error]);
        } else {

            $data = [
                'title' => $this->request->getVar('title'),
                'content' => $this->request->getVar('content'),
                'meta_keywords' => $this->request->getVar('meta_keywords'),
                'meta_description' => $this->request->getVar('meta_description'),
                'category_id' => $this->request->getVar('category'),
                'author_id' => $user_id,
                'visibility' => $this->request->getVar('visibility'),
                'slug' => Slugify::model(Post::class)->make($this->request->getVar('title')),
                'tags' => $this->request->getVar('tags')
            ];

            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                $path = 'images/posts/';
                $file = $request->getFile('image');
                $filename = $file->getFilename();
                $oldfile = $post->asObject()->find($id)->image;

                if ($oldfile != null && file_exists($path . $oldfile)) {
                    unlink($path . $oldfile);
                    unlink($path . 'thumb_' . $oldfile);
                    unlink($path . 'resized_' . $oldfile);
                }

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                if ($file->move($path, $filename)) {
                    //create thumbail img
                    \Config\Services::image()
                        ->withFile($path . $filename)
                        ->fit(150, 150, 'center')
                        ->save($path . 'thumb_' . $filename);

                    //create resized image 450x300
                    \Config\Services::image()
                        ->withFile($path . $filename)
                        ->fit(450, 300, 'center')
                        ->save($path . 'resized_' . $filename);
                }

                $data['image'] = $filename;
            }

            $save = $post->update($id, $data);
            if ($save) {
                return $this->response->setJSON(['status' => 1, 'msg' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 0, 'msg' => 'something went wrong']);
            }
        }
    }


    public function deletePost()
    {
        $id = $this->request->getVar('id');
        $post = new Post();
        $path = 'images/posts/';
        $oldfile = $post->asObject()->find($id)->image;
        if ($oldfile != null && file_exists($path . $oldfile)) {
            unlink($path . $oldfile);
            unlink($path . 'thumb_' . $oldfile);
            unlink($path . 'resized_' . $oldfile);
        }
        $delete = $post->delete($id);
        if ($delete) {
            return $this->response->setJSON(['status' => 1, 'msg' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'something went wrong']);
        }
    }
}
