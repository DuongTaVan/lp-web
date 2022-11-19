<div class="select" onclick="select()">
    <input type="text" class="select__value f-w3" readonly name="year" value="{{ old('year') ?? (isset($user) ? formatTime($user->date_of_birth, 'Y') : "") }}"/>
    <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}" class="arrow-down" alt="">
    <div class="select__options">
        @for($i = \App\Enums\Constant::TIME_POINT; $i <= now()->format('Y'); $i ++)
            <div class="select__item f-w3" onclick="setValueSelect(this)">{{ $i }}</div>
        @endfor
    </div>
</div>
<script>
    function select() {
        let parentSelect = document.querySelector(".select");
        let valueSelected = document.querySelector(".select__value");
        let valueOptions = document.querySelectorAll(".select__item");
        for (let i = 0; i < valueOptions.length; i++) {
            valueOptions[i].classList.remove('item-active');
            if (valueSelected.value == valueOptions[i].textContent) {
                valueOptions[i].classList.add('item-active');
                // valueOptions[i].scrollIntoView();
            }
        }
        parentSelect.classList.toggle("active");
    }
    function setValueSelect(e) {
        document.querySelector(".select__value").value = e.textContent;
        $(".select__value").trigger("input");
    }
    document.body.addEventListener('mouseup', function (e) {
        if (e.target.closest('.select') === null) {
            let selectBox = document.querySelectorAll('.select')
            for (let i = 0; i < selectBox.length; i++) {
                selectBox[i].classList.remove('active');
            }
        }
    });
</script>
