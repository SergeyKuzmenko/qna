@extends('layouts.app')
@section('title', 'Задать вопрос')

@section('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://highlightjs.org/static/demo/styles/stackoverflow-dark.css" rel="stylesheet">
@endsection

@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Задать вопрос</h1>
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
                    <div class="card card-default">
                        <form method="post" action="{{ route('question.store') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Суть вопроса</label>
                                    <input type="text"
                                           name="title"
                                           class="form-control"
                                           id="title"
                                           value="{{ old('title') }}"
                                           placeholder="Сформулируйте вопрос так, чтобы сразу было понятно, о чём речь"
                                           required
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="tags">Теги вопроса</label>
                                    <select class="tags-select"
                                            multiple="multiple"
                                            data-placeholder="Выберите до 5 тегов"
                                            style="width: 100%;"
                                            name="tags[]"
                                            required
                                    >
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="body">Детали вопроса</label>
                                    <div class="editor-container"></div>
                                    <textarea name="body" style="display:none;" id="body">{{ old('body') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="tags">Сложность</label>
                                    <select class="complexity"
                                            data-placeholder="Выберите сложность вопроса"
                                            style="width: 100%;"
                                            name="complexity"
                                    >
                                        <option value="1" selected>Простой</option>
                                        <option value="2">Средний</option>
                                        <option value="3">Сложный</option>
                                    </select>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Опубликовать</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>

    <script>
        $(function () {

            $('.tags-select').select2({
                placeholder: "Укажите теги",
                language: "ru",
                theme: 'bootstrap4',
                maximumSelectionLength: 5,
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route('api.tags') }}',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                },
            });
            $('.complexity').select2({
                language: "ru",
                theme: 'bootstrap4',
            });

        });
    </script>
    <script>
        const editor = new Quill('.editor-container', {
            modules: {
                syntax: true,
                toolbar: [
                    ['bold', 'italic', 'underline', 'blockquote'],
                    ['link', 'image', 'code-block']
                ]
            },
            placeholder: 'Опишите в подробностях свой вопрос',
            theme: 'snow'
        });
        let HtmlContent = document.getElementById('body');
        editor.on('text-change', function () {
            HtmlContent.innerHTML = editor.root.innerHTML;
        });
    </script>
@endsection
