@extends('app')

@section('title', 'History')

@section('content')
    <div class="card text-center" style="width: 100%;">
        <div class="card-header d-flex justify-content-center">
            <div class="h3">History</div>
            <a href="{{route('dashboard.index', ['hash' => request()->route('hash')])}}" class="btn btn-primary ms-auto">Back to game</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Number</th>
                    <th scope="col">Result</th>
                    <th scope="col">Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$item->number}}</td>
                    <td><span class="badge text-bg-{{($item->result === \App\UseCases\Game::WIN) ? 'success' : 'danger'}}">{{strtoupper($item->result)}}</span></td>
                    <td>{{$item->amount}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
