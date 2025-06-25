<div class="likeButton d-flex align-items-center"
     data-post-slug="{{ $post->slug }}">
    <span class="me-1 fs-6" id="likeCount-{{ $post->slug }}">
        {{ $post->likers_count }}
    </span>
    <i class="{{ $post->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger likeBtn fs-4' : 'far fa-heart text-danger likeBtn'}}"
       data-toggle="tooltip"
       title="{{ __('Like') }}"
       id="likeIcon-{{ $post->slug }}"></i>
</div>
