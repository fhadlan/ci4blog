<?php

use App\Libraries\CIAuth;
use App\Models\User;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Models\Post;
use Carbon\Carbon;

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

/**
 * Get parent categories
 */
if (!function_exists('get_parent_categories')) {
    function get_parent_categories()
    {
        $category = new \App\Models\Category();
        $parent_categories = $category->asObject()->orderBy('name', 'asc')->findAll();
        return $parent_categories;
    }
}

/**
 * Get sub categories by parent id
 */
if (!function_exists('get_sub_categories')) {
    function get_sub_categories($parent_id)
    {
        $subcategory = new \App\Models\SubCategory();
        $sub_categories = $subcategory->asObject()->where('parent_cat', $parent_id)->orderBy('name', 'asc')->findAll();
        return $sub_categories;
    }
}

/**
 * Get dependant sub categories
 */
if (!function_exists('get_dependant_sub_categories')) {
    function get_dependant_sub_categories()
    {
        $subcategory = new \App\Models\SubCategory();
        $sub_categories = $subcategory->asObject()->where('parent_cat =', 0)->orderBy('name', 'asc')->findAll();
        return $sub_categories;
    }
}

/** Date format JAN 12, 2022 */
if (!function_exists('date_formatter')) {
    function date_formatter($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->isoFormat('ll');
    }
}

/** calculate reading time */
if (!function_exists('get_reading_time')) {
    function get_reading_time($content)
    {
        $words = str_word_count(strip_tags($content));
        $minutes = ceil($words / 200);
        return $minutes;
    }
}

if (!function_exists('limit_words')) {
    function limit_words($content = null, $limit = 20)
    {
        return word_limiter(strip_tags($content), $limit);
    }
}

if (!function_exists('get_home_main_latest_posts')) {
    function get_home_main_latest_posts()
    {
        $post = new Post();
        $latest_posts = $post->asObject()->where('visibility', 1)->orderBy('created_at', 'desc')->first();
        return $latest_posts;
    }
}

if (!function_exists('get_6_home_latest_posts')) {
    function get_6_home_latest_posts()
    {
        $post = new Post();
        $latest_posts = $post->asObject()->where('visibility', 1)->orderBy('created_at', 'desc')->limit(6, 1)->get()->getResult();
        return $latest_posts;
    }
}

if (!function_exists('get_sidebar_random_posts')) {
    function get_sidebar_random_posts()
    {
        $post = new Post();
        $random_posts = $post->asObject()->where('visibility', 1)->orderBy('rand()')->limit(4)->get()->getResult();
        return $random_posts;
    }
}

if (!function_exists('get_sidebar_sub_categories')) {
    function get_sidebar_sub_categories()
    {
        $sub_category = new \App\Models\SubCategory();
        $sub_categories = $sub_category->select('sub_categories.slug,name,count(posts.category_id) as number_of_posts')->join('posts', 'posts.category_id=sub_categories.id', 'left')->where('posts.visibility=1')->groupBy('sub_categories.id')->asObject()->orderBy('name', 'asc')->findAll();
        return $sub_categories;
    }
}

if (!function_exists('get_sidebar_latest_posts')) {
    function get_sidebar_latest_posts($except = null)
    {
        $post = new Post();
        $latest_post = $post->asObject()->where('id !=', $except)->orderBy('created_at', 'desc')->findAll(4);
        return $latest_post;
    }
}

if (!function_exists('get_sidebar_tags')) {
    function get_sidebar_tags()
    {
        $post = new Post();
        $tags_array = [];
        $posts = $post->asObject()->where('visibility', 1)->where('tags !=', '')->orderBy('created_at', 'desc')->findAll();
        foreach ($posts as $post) {
            $tags = explode(',', $post->tags);
            foreach ($tags as $tag) {
                $tags_array[] = $tag;
            }
        }
        $tags_array = array_unique($tags_array);
        return $tags_array;
    }
}

if (!function_exists('get_related_posts')) {
    function get_related_posts($post_id, $tags)
    {
        $post = new Post();
        $tags_arr = explode(',', $tags);
        if (count($tags_arr) > 0) {
            $builder = $post->asObject();
            foreach ($tags_arr as $tag) {
                $builder->orLike('tags', $tag, 'both');
                $builder->where('id !=', $post_id);
            }
            $builder->where('visibility', 1);
            $builder->orderBy('rand()');
            $builder->limit(3);
            $related_posts = $builder->get()->getResult();
        } else {
            $related_posts = [];
        }

        return $related_posts;
    }
}

if (!function_exists('get_prev_post')) {
    function get_prev_post($post_id)
    {
        $post = new Post();
        $prev_post = $post->select('title,slug')->asObject()->where('id <', $post_id)->where('visibility', 1)->orderBy('created_at', 'desc')->first();
        return $prev_post;
    }
}

if (!function_exists('get_next_post')) {
    function get_next_post($post_id)
    {
        $post = new Post();
        $next_post = $post->select('title,slug')->asObject()->where('id >', $post_id)->where('visibility', 1)->orderBy('created_at', 'desc')->first();
        return $next_post;
    }
}
