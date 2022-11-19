<div class="{{ isset($className) ? $className : '' }}">
    <div class="select">
        @php
            $valueInput = '';
            if (old($name)) {
                $valueInput = $value[old($name)] ?? '';
            } elseif (isset($valueDefault)) {
                $valueInput = $value[$valueDefault] ?? '';
            }
        @endphp
        @if (isset($courseSession['minutes_required']))
            <input type="text" class="select__value-item f-w3" readonly placeholder="{{ $placeholder ?? '' }}"
                value="{{ $courseSession['minutes_required'] . ' 分' }}"/>
            <input type="hidden"
                value="{{ $courseSession['minutes_required'] }}"
                name="{{ $name }}"
                class="hidden_input">
        @else
            <input type="text" class="select__value-item f-w3 preview-input-select" readonly placeholder="{{ $placeholder ?? '' }}"
                value="{{ $valueInput }}"/>
            <input type="hidden"
                value="{{ old($name) ?? $valueDefault }}"
                name="{{ $name }}"
                class="hidden_input">
        @endif
        <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}" class="arrow-down"
             alt=""/>
        <div class="select__options">
            @foreach ($value as $key => $data)
                <div class="select__item f-w3 select-parent-item @if($valueInput === $data) item-active @endif" data-minute="{{ $key }}">{!! $data !!}</div>
            @endforeach
        </div>
    </div>
</div>
