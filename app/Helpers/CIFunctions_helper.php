<?php

use App\Libraries\CIAuth;
use App\Models\User;
use App\Models\Setting;
use App\Models\SocialMedia;

if (!function_exists('get_user')) {
    function get_user()
    {
        if (CIAuth::check()) {
            $user = new User();
            return $user->asObject()->where('id', CIAuth::id())->first();
        } else {
            return null;
        }
    }
}

if (!function_exists('get_settings')) {
    function get_settings()
    {
        $settings = new Setting();
        $settings_data = $settings->asObject()->first();

        if (!$settings_data) {
            $data = array(
                'blog_title' => 'fadlan blog',
                'blog_email' => 'admin@localhost.com',
                'blog_phone' => null,
                'blog_meta_keywords' => null,
                'blog_meta_description' => null,
                'blog_logo' => null,
                'blog_favicon' => null
            );
            $settings->save($data);
            $new_settings_data = $settings->asObject()->first();
            return $new_settings_data;
        } else {
            return $settings_data;
        }
    }
}

if (!function_exists('get_social_media')) {
    function get_social_media()
    {
        $result = null;
        $social_media = new SocialMedia(); //declare model to use
        $social_media_data = $social_media->asObject()->first();

        if (!$social_media_data) {
            $data = array(
                'facebook_url' => null,
                'twitter_url' => null,
                'instagram_url' => null,
                'youtube_url' => null,
                'github_url' => null,
                'linkedin_url' => null,
            );
            $social_media->save($data);
            $new_social_media_data = $social_media->asObject()->first();
            $result = $new_social_media_data;
        } else {
            $result = $social_media_data;
        }
        return $result;
    }
}

if (!function_exists('current_route_name')) {
    function current_route_name()
    {
        $route = \CodeIgniter\Config\Services::router();
        $route_name = $route->getMatchedRouteOptions()['as'];
        return $route_name;
    }
}

/**
 * FRONTEND FUNCTIONS
 */

if (!function_exists('get_parent_categories')) {
    function get_parent_categories()
    {
        $category = new \App\Models\Category();
        $parent_categories = $category->asObject()->orderBy('name', 'asc')->findAll();
        return $parent_categories;
    }
}

if (!function_exists('get_sub_categories')) {
    function get_sub_categories($parent_id)
    {
        $subcategory = new \App\Models\SubCategory();
        $sub_categories = $subcategory->asObject()->where('parent_cat', $parent_id)->orderBy('name', 'asc')->findAll();
        return $sub_categories;
    }
}

if (!function_exists('get_dependant_sub_categories')) {
    function get_dependant_sub_categories()
    {
        $subcategory = new \App\Models\SubCategory();
        $sub_categories = $subcategory->asObject()->where('parent_cat =', 0)->orderBy('name', 'asc')->findAll();
        return $sub_categories;
    }
}
