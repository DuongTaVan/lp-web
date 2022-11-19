@foreach($data as $bank)
<div class="select__item f-w3 select-parent-item category-select @if((int)$bank->type === 0) bank-select @else branch-select @endif">{{$bank->name}}</div>
@endforeach
