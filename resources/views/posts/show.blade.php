@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="owl-carousel">
                    @php $images = $post->getMedia('posts') @endphp
                    @forelse($images as $image)
                        <img class="card-img owl-lazy" src="{{ $image->getUrl('square') }}"
                             data-src="{{ $image->getUrl('square') }}" alt="{{ $post->caption }}">
                    @empty

                    @endforelse
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mr-2">
                                <a href="{{ route('users.show', $post->user) }}"
                                   data-pjax>
                                    <img src="{{ $post->user->avatar }}" class="avatar rounded-circle"
                                         alt="{{ $post->user->username }}">
                                </a>
                            </div>
                            <div>
                                <div class="font-weight-bold">
                                    <a href="{{ route('users.show', $post->user) }}"
                                       data-pjax>
                                        <span class="text-dark">{{ $post->user->username }}</span>
                                    </a>
                                </div>
                                <div class="text-muted">
                                    <span title="{{ $post->created_at }}">
                                        {{ $post->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if(auth()->user() != $post->user)
                        <div>
                            <a href="{{ route('users.show', $post->user) }}"
                               data-pjax
                               class="btn btn-primary btn-sm ml-3">
                                {{ __('View Profile') }}
                            </a>
                        </div>
                        @endif

                        @can('update', $post->user)
                            <form action="{{ route('posts.destroy', $post) }}" method="post" class="ml-3"
                                  onsubmit="return confirm('Are you sure to delete the post?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2 px-1">
                        <div>
                            <span class="font-weight-bold">
                                <a href="{{ route('users.show', $post->user) }}"
                                   data-pjax>
                                    <span class="text-dark">{{ $post->user->username }}</span>
                                </a>
                            </span>
                        </div>
                        @include('likes.create')
                    </div>

                    <p class="text-sm text-break text-justify">{{ $post->caption }}</p>
                </div>

                <!-- New Comment Box -->
                @include('comments.create')
                <!-- New Comment Box End -->

                <!-- Comments -->
                @include('comments.index')
                <!-- Comments End -->
            </div>
        </div>
    </div>
@endsection
