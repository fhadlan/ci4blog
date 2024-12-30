<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SubCategory;
use App\Models\Post;


class BlogController extends BaseController
{
    protected $helpers = ['form', 'url', 'CIMail', 'CIFunctions', 'text'];
    public function index()
    {
        $data = [
            'pageTitle' => get_settings()->blog_title
        ];
        return view('frontend/pages/home', $data);
    }

    public function readPost($slug)
    {
        $post = new Post();
        try {
            $post_data = $post->asObject()->where('slug', $slug)->first();
            if (empty($post_data)) {
                throw new \Exception('Post not found');
            }
            $data = [
                'pageTitle' => $post_data->title,
                'post' => $post_data
            ];
            return view('frontend/pages/single_post', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function categoryPosts($slug)
    {
        $subcategory = new SubCategory();
        $post = new Post();
        $subcategory_data = $subcategory->asObject()->where('slug', $slug)->first();
        $post_data = $post->asObject()->where('category_id', $subcategory_data->id)->where('visibility', 1)->paginate(6);
        $data = [
            'pageTitle' => $subcategory_data->name,
            'posts' => $post_data,
            'pager' => $post->pager

        ];
        return view('frontend/pages/category_posts', $data);
    }
    public function tagPosts($tag)
    {
        $post = new Post();
        $post_data = $post->asObject()->like('tags', '%' . urldecode($tag) . '%')->where('visibility', 1)->paginate(6);
        $data = [
            'pageTitle' => $tag,
            'posts' => $post_data,
            'pager' => $post->pager
        ];
        return view('frontend/pages/tag_posts', $data);
    }

    public function searchPosts()
    {
        $post = new Post();
        $s = $this->request->getVar('s');
        $searches = explode(' ', $s);
        $builder = $post->asObject();
        foreach ($searches as $search) {
            $builder->orLike('title', '%' . $search . '%');
            $builder->orLike('tags', '%' . $search . '%');
        }
        $builder->where('visibility', 1);
        $post_data = $builder->paginate(6);
        $data = [
            'pageTitle' => $s,
            'posts' => $post_data,
            'pager' => $post->pager,
            'search' => $s
        ];
        return view('frontend/pages/search_posts', $data);
    }
}
