<?php

use App\Livewire\Concerns\RendersSitePage;
use App\Models\BlogPost;
use Livewire\Component;

new class extends Component
{
    use RendersSitePage;

    public BlogPost $post;

    public function mount(string $slug): void
    {
        $this->post = BlogPost::query()
            ->with('seoMeta')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $this->seoable = $this->post;
        $this->fallbackTitle = $this->post->title;
        $this->fallbackDescription = $this->post->excerpt;
    }
};
