@extends('app')

@section('title', 'Dashboard')

@section('content')
    <div class="card text-center" style="width: 100%;">
        <div class="card-header d-flex justify-content-center">
            <div class="h3">Game</div>
            <a href="{{route('dashboard.history', ['hash' => request()->route('hash')])}}" class="btn btn-primary ms-auto">History</a>
        </div>
        <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 400px;">
            @if (session('message'))
                <div style="position: absolute; min-width: 420px;"
                    class="align-self-start text-center alert alert-{{ session('message')['type'] }}"
                    role="alert">{{ session('message')['text'] }}</div>
            @endif
            @if (session('msg'))
                <div style="position: absolute; min-width: 420px;"
                     class="align-self-start text-center alert alert-success"
                     role="alert">

                </div>
            @endif
            <div>
                <h5 class="card-title">Press button to play</h5>
                <form method="post" action="{{ route('dashboard.play', ['hash' => request()->route('hash')]) }}">
                    @csrf
                    <button type="submit" class="btn btn-lg btn-primary">Imfeelinglucky</button>
                </form>
            </div>
        </div>
        <div class="card-footer text-body-secondary">
            <a href="{{route('dashboard.link.regenerate', ['hash' => request()->route('hash')])}}" class="btn btn-primary mr-4">Generate new link</a>
            <a href="{{route('dashboard.link.deactivate', ['hash' => request()->route('hash')])}}" class="btn btn-danger">Deactivate current link</a>
        </div>
    </div>
@endsection
