@extends('layouts.app')
@section('title', 'Мои вопросы')
@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Мои вопросы ({{ $questions->total() }})</h1>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if($questions->count() > 0)
                        @foreach($questions->sortByDesc('created_at') as $question)
                            <x-question :question="$question"></x-question>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="lead mt-2">
                                        Вы еще не задавали вопросов
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="float-lg-right">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
