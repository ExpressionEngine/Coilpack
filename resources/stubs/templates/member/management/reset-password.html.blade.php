@extends('ee::<?=$template_group?>._layout')
@section('title', 'Reset Password')

@section('contents')

    <a href="{{ $global->cp_url }}?/cp/design/template/edit/{{ $global->template_id }}" target="_blank">View Template</a>

    @if($global->logged_in)
        <h2>You are already logged in as {{ $global->username }}.</h2>
    @endif

    <div class="result">
        @php
            $form = $exp->member->reset_password_form([
                'return' => "<?=$template_group?>/login/success",
                'inline_errors' => "yes"
            ])
        @endphp
        {!! $form->open() !!}

            @unless($form->errors()->isEmpty())
                <fieldset class="error">
                    <legend>Errors</legend>
                    @foreach($form->errors() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </fieldset>
            @endunless

            <p>
                <label>Your New Password</label><br />
                <input type="password" name="password" value="" maxlength="50" size="40" />
                @if($form->errors->has('password'))
                    <span class="error">{{ $form->errors->get('password') }}</span>
                @endif
            </p>

            <p>
                <label>Confirm New Password</label><br />
                <input type="password" name="password_confirm" value="" maxlength="50" size="40" />
                @if($form->errors->has('password_confirm'))
                    <span class="error">{{ $form->errors->get('password_confirm') }}</span>
                @endif
            </p>

            <p><input type="submit" name="submit" value="Submit" /></p>

            <p><a href="{{ $exp->path('<?=$template_group?>/login') }}">Login</a> &nbsp; &nbsp; <a href="{{ $exp->path('<?=$template_group?>/registration') }}">Register</a></p>
        {!! $form->close() !!}
    </div>

@endsection