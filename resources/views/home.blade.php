@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <meetups-finder find-meetups-url={{ route('find-meetups') }}
                            get-regions-url={{ route('get-regions') }} priv-message-url={{ route('priv-message') }}
                            get-priv-talk-url={{ route('get-priv-talk') }}
                            get-priv-messages-url={{ route('get-priv-messages') }}>
                        </meetups-finder>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
