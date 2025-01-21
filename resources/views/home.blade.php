@extends('layouts.main')

<style>
    img {
  opacity: 0.95;
}
</style>
@section('content')

<div class="d-flex align-items-center">
    <div class="d-flex align-items-center">
        {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div> --}}
        {{-- <img src="img/logo_new.png" style="width:100%"> --}}
    </div>
</div>
@endsection