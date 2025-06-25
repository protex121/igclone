@extends('layouts.app')

@section('content')
    <div class="infinite-scroll">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <!-- Title -->
                                    <h5 class="h3 mb-0">{{ __('Profiles') }}</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Card body -->
                        <div class="card-body">
                            <!-- List group -->
                            <ul class="list-group list-group-flush list my-3">
                                @forelse($users as $user)
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <!-- Avatar -->
                                                <a href="{{ route('users.show', $user) }}"
                                                   data-pjax
                                                   class="avatar rounded-circle">
                                                    <img alt="{{ $user->name }}"
                                                         src="{{ $user->avatar }}">
                                                </a>
                                            </div>
                                            <div class="col ml--2">
                                                <h4 class="mb-0">
                                                    <a href="{{ route('users.show', $user) }}"
                                                       data-pjax>
                                                        {{ $user->username }}
                                                    </a>
                                                </h4>

                                                <p class="text-sm mb-0">
                                                    {{ Str::limit($user->name, 30) }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <div class="col">
                                        <h3 class="text-center text-muted">{{ __('No users to show!') }}}</h3>
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
