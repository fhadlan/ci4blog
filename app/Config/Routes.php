<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'BlogController::index');
$routes->get('post/(:any)', 'BlogController::readPost/$1', ['as' => 'read-post']);
$routes->get('category/(:any)', 'BlogController::categoryPosts/$1', ['as' => 'category-posts']);
$routes->get('/tag/(:any)', 'BlogController::tagPosts/$1', ['as' => 'tag-posts']);
$routes->get('/search', 'BlogController::searchPosts', ['as' => 'search-posts']);
$routes->get('/contact-us', 'BlogController::contactUs', ['as' => 'contact-us']);
$routes->post('/contact-us', 'BlogController::contactUsSend', ['as' => 'contact-us-send']);
$routes->get('about', 'BlogController::about', ['as' => 'about']);

$routes->group('admin', static function ($routes) {
    // All the routes below are for the authenticated user
    $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {
        //$routes->view('example-page','example-page');
        $routes->get('home', 'AdminController::index', ['as' => 'admin.home']);
        $routes->get('logout', 'AdminController::logoutHandler', ['as' => 'admin.logout']);

        // Profile
        $routes->get('profile', 'AdminController::profile', ['as' => 'admin.profile']);
        $routes->post('update-personal-details', 'AdminController::updatePersonalDetails', ['as' => 'update-personal-details']);
        $routes->post('update-profile-picture', 'AdminController::updateProfilePicture', ['as' => 'update-profile-picture']);
        $routes->post('change-password', 'AdminController::changePassword', ['as' => 'change-password']);

        // Settings
        $routes->get('settings', 'AdminController::settings', ['as' => 'settings']);
        $routes->post('update-general-settings', 'AdminController::updateGeneralSettings', ['as' => 'update-general-settings']);
        $routes->post('update-blog-logo', 'AdminController::updateBlogLogo', ['as' => 'update-blog-logo']);
        $routes->post('update-blog-favicon', 'AdminController::updateBlogFavicon', ['as' => 'update-blog-favicon']);
        $routes->post('update-social-media', 'AdminController::updateSocialMedia', ['as' => 'update-social-media']);

        // Categories
        $routes->get('categories', 'AdminController::categories', ['as' => 'categories']);
        $routes->post('add-category', 'AdminController::addCategory', ['as' => 'add-category']);
        $routes->get('get-categories', 'AdminController::getCategories', ['as' => 'get-categories']);
        $routes->get('delete-category/(:any)', 'AdminController::deleteCategory/$1', ['as' => 'delete-category']);
        $routes->get('get-category-name', 'AdminController::getCategoryName', ['as' => 'get-category-name']);
        $routes->get('get-parent-categories', 'AdminController::getParentCategories', ['as' => 'get-parent-categories']);
        $routes->post('add-sub-category', 'AdminController::addSubCategory', ['as' => 'add-sub-category']);
        $routes->get('get-sub-categories', 'AdminController::getSubCategories', ['as' => 'get-sub-categories']);
        $routes->get('get-sub-category-edit', 'AdminController::getSubCategoryEdit', ['as' => 'get-sub-category-edit']);
        $routes->get('delete-subcategory', 'AdminController::deleteSubCategory', ['as' => 'delete-subcategory']);

        // Posts
        $routes->group('posts', static function ($routes) {
            $routes->get('new-post', 'AdminController::addPost', ['as' => 'new-post']);
            $routes->post('create-post', 'AdminController::createPost', ['as' => 'create-post']);
            $routes->get('/', 'AdminController::posts', ['as' => 'all-posts']);
            $routes->get('get-posts', 'AdminController::getPosts', ['as' => 'get-posts']);
            $routes->get('edit-post/(:any)', 'AdminController::editPost/$1', ['as' => 'edit-post']);
            $routes->post('update-post', 'AdminController::updatePost', ['as' => 'update-post']);
            $routes->post('delete-post', 'AdminController::deletePost', ['as' => 'delete-post']);
        });
    });

    $routes->group('', ['filter' => 'cifilter:guest'], static function ($routes) {
        //$routes->view('example-auth','example-auth');
        $routes->get('login', 'AuthController::loginForm', ['as' => 'admin.login.form']);
        $routes->post('login', 'AuthController::loginHandler', ['as' => 'admin.login.handler']);
        $routes->get('forgot-password', 'AuthController::forgotForm', ['as' => 'admin.forgot.form']);
        $routes->post('send-password-reset-link', 'AuthController::sendPasswordResetLink', ['as' => 'send_password_reset_link']);
        $routes->get('password/reset/(:any)', 'AuthController::resetPassword/$1', ['as' => 'admin.reset-password']);
        $routes->post('reset-password-handler/(:any)', 'AuthController::resetPasswordHandler/$1', ['as' => 'reset-password-handler']);
    });
});
