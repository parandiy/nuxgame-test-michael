@extends('app')

@section('title', 'Link expired')

@section('content')
    <div class="card text-center" style="width: 100%;">
        <div class="card-header">
            <div class="h3">Link Expired</div>
        </div>
        <div class="mt-4 mb-4"><a href="{{ route('registration.index') }}" class="btn btn-primary">Create new account</a></div>
    </div>
@endsection
