@extends('layouts.app')
@section('title', 'Мои ответы')
@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Мои ответы ({{ $answers->total() }})</h1>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 answers-box">
                    @if($answers->count() > 0)
                        @foreach( $answers->sortByDesc('created_at') as $answer )
                            <x-answer-list :answer="$answer"></x-answer-list>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="lead mt-2">
                                        У Вас еще нет ответов
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
                        {{ $answers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
