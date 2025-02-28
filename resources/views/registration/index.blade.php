@extends('app')

@section('title', 'Registration')

@section('content')
    <div class="card" style="width: 320px;">
        <div class="card-header d-flex justify-content-center">
            <div class="h3">Registration @if (session('link')) success @endif</div>
        </div>
        <div class="card-body">
            @if (session('link'))
                <div class="mt-3">
                    <label for="link-input" class="form-label">Your unique link</label>
                    <input type="text" disabled value="{{ session('link') }}" class="form-control" id="link-input">
                    <div class="form-text">Copy link or press button below.</div>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ session('link') }}" class="btn btn-lg btn-primary">Go to link</a>
                </div>
            @else
                <form method="post" action="{{ route('registration.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputUsername1" class="form-label">Username</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @if($errors->has('name')) is-invalid @endif"
                               id="exampleInputUsername1">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputphonenumber1" class="form-label">Phone number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="form-control @if($errors->has('phone')) is-invalid @endif"
                               id="exampleInputphonenumber1">
                        @if($errors->has('phone'))
                            <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            @endif
        </div>
    </div>
@endsection
