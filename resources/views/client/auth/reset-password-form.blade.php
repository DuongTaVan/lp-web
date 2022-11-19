@extends('client.base.base')

@section('content')
    <!-- CONTENT -->
    <div class="reset-password-form-wrap">
        <div class="reset-password-form">
            <div class="reset-title f-w6">{{ __('labels.auth.reset_password.title') }}</div>
            <div class="d-flex align-items-center user-info">
                <img src="{{ $user->profile_image ?? null }}" alt="">
                <div class="f-w6">
                    {{ $user->nickname ?? null }}
                </div>
            </div>
            <form action="{{ route('client.password-reset.reset') }}" method="post">
                @csrf
                <input type="hidden" value="{{ $token ?? null }}" name="token">
                <div class="title f-w6">{{ __('labels.auth.reset_password.new_password') }}</div>
                <input type="password" name="password" onblur="blurInput(this)" oninput="OnInput(this)" class="password @if ($errors->has('password')) border-error  @endif" id="new-password">
                <div class="message-error">
                    @error('password')
                    <script>
                        document.getElementById("new-password").focus();
                    </script>
                    {{ $message ?? null }}
                    @enderror
                </div>
                <div class="instruction">{{ __('labels.auth.reset_password.instruction') }}</div>

                <div class="title f-w6">{{ __('labels.auth.reset_password.confirm_password') }}</div>
                <input type="password" name="confirm_password" onblur="blurInput(this)" oninput="OnInput(this)" class="password @if ($errors->has('confirm_password')) border-error  @endif" id="confirm-password">
                @if(!isset($customerErrors['password']))
                    <?php $customerErrors = $errors->toArray() ?>
                    @error('confirm_password')
                        <div class="message-error">
                            {{ $message }}
                            <script>
                                document.getElementById("confirm-password").focus();
                            </script>
                        </div>
                    @enderror
                @endif
                <button type="submit" class="f-w6">{{ __('labels.button.send-email') }}</button>
            </form>
        </div>
    </div>
@endsection
<script>
    function OnInput(e) {
        e.classList.remove('border-error');
    }
    function blurInput(e) {
        $(e).val(e.value.trim());
        e.setAttribute("value", e.value.trim());
    }
</script>

