<div class="row mb-3 filter-menu">
    <div class="col-3">
        <a href="{{ request()->fullUrlWithQuery(['by' => 'new']) }} " type="button" class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'new' || request()->input('by') == null) ? 'active' : '' }}">Новые</a>
    </div>
    <div class="col-3">
        <a href="{{ request()->fullUrlWithQuery(['by' => 'interesting']) }} " type="button" class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'interesting') ? 'active' : '' }}">Интересные</a>
    </div>
    <div class="col-3">
        <a href="{{ request()->fullUrlWithQuery(['by' => 'without_answers']) }} " type="button" class="btn btn-block btn-outline-secondary btn-sm {{ (request()->input('by') == 'without_answers') ? 'active' : '' }}">Без ответа</a>
    </div>
    <div class="col-3">
        <div class="dropdown">
            <button class="btn btn-block btn-outline-secondary btn-sm dropdown-toggle" type="button" id="ordersBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Сложность
            </button>
            <div class="dropdown-menu" aria-labelledby="ordersBtn">
                <a class="dropdown-item" href="#">Простой</a>
                <a class="dropdown-item" href="#">По ответам</a>
                <a class="dropdown-item" href="#">По рейтингу</a>
                <div class="dropdown-divider"></div>
                <a type="button" class="btn btn-block btn-flat bg-success">Success</a>
            </div>
        </div>
    </div>
</div>
