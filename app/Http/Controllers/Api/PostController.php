<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $posts = Post::with('user')->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'seo_title' => $post->seo_title,
                'seo_description' => $post->seo_description,
                'seo_keywords' => $post->seo_keywords,
                'user' => $post->user->name ?? 'Bilinmeyen Kullanıcı',
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
        });

        return $this->successResponse($posts);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'seo_title' => 'nullable',
            'seo_description' => 'nullable',
            'seo_keywords' => 'nullable',
        ]);

        $data['user_id'] = auth()->id();

        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $data['slug'] = $slug;

        $post = Post::create($data);

        return $this->successResponse($post, 'Post başarıyla oluşturuldu', 201);
    }

    public function show($data)
    {
        $post = Post::with('user')
            ->where('id', $data)
            ->orWhere('slug', $data)
            ->first();

        if (!$post) {
            return $this->errorResponse('Post bulunamadı', 404);
        }

        $formattedPost = [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'content' => $post->content,
            'seo_title' => $post->seo_title,
            'seo_description' => $post->seo_description,
            'seo_keywords' => $post->seo_keywords,
            'user' => $post->user->name ?? 'Bilinmeyen Kullanıcı',
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ];

        return $this->successResponse($formattedPost, 'Post getirildi');
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->errorResponse('Post bulunamadı.', 404);
        }

        $data = $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
        ]);

        if (isset($data['title'])) {
            $baseSlug = Str::slug($data['title']);
            $slug = $baseSlug;
            $counter = 1;

            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $data['slug'] = $slug;
        }

        $post->update($data);

        return $this->successResponse($post, 'Post başarıyla güncellendi');
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->errorResponse('Post bulunamadı.', 404);
        }

        $post->delete();

        return $this->successResponse(null, 'Post silindi.');
    }
}
