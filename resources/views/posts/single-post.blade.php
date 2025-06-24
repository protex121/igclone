<div class="col-md-4 pb-4">
    <div class="owl-carousel border">
        @php $images = $post->getMedia('posts') @endphp
        @forelse($images as $image)
            <a href="#" data-bs-toggle="modal" data-bs-target="#post{{ $post->id }}">
                <img title="More {{ $images->count()-1 }} images.."
                    type="button"
                    class="w-100 rounded owl-lazy"
                    src="{{ $image->getUrl('square') }}"
                    data-toggle="modal"
                    data-target="#post{{ $post->id }}"
                    data-src="{{ $image->getUrl('square') }}" alt="{{ $post->caption }}">
                 </a>
            @break
        @empty

        @endforelse
    </div>

    {{-- Modal --}}
    <div class="modal fade"
         id="post{{ $post->id }}"
         tabindex="-1"
         aria-labelledby="post{{ $post->id }}Label"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title text-sm text-break text-justify" id="post{{ $post->id }}Label">
                        {{ $post->caption }}
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="owl-carousel">
                        @php $images = $post->getMedia('posts') @endphp
                        @forelse($images as $image)
                            <img class="w-100 rounded owl-lazy" src="{{ $image->getUrl('square') }}"
                                 data-src="{{ $image->getUrl('square') }}" alt="{{ $post->caption }}">
                        @empty

                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('posts.show', $post) }}"
                       class="btn btn-primary">
                        {{ __('Details') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>