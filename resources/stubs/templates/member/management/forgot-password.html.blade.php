@extends('ee::<?=$template_group?>._layout')
@section('title', 'Forgot Password')

@section('contents')

    @if($global->logged_in)
        <h2>You are already logged in as {{ $global->username }}.</h2>
    @endif

    <div class="result">
        @if($segment_3 == 'sent')
            <div class="info">
                <p>If this email address is associated with an account, instructions for resetting your password have just been emailed to you.</p>
                <p>For security reasons, we cannot confirm if this email address matches an existing account.</p>
            </div>
        @endif

        @php
            $form = $exp->member->forgot_password_form([
                'return' => "<?=$template_group?>/forgot-password/sent",
                'inline_errors' => "yes",
                'password_reset_url' => "<?=$template_group?>/reset-password",
                'password_reset_email_template' => "<?=$template_group?>/email-password-reset",
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
                <label>Your Email Address</label><br />
                <input type="email" name="email" value="@if($form->old()->has('email')){{ $form->old()->get('email') }}@endif" maxlength="120" size="40" />
            </p>

            <p><input type="submit" name="submit" value="Submit" /></p>

            <p><a href="{{ $exp->path('<?=$template_group?>/login') }}">Login</a> &nbsp; &nbsp; <a href="{{ $exp->path('<?=$template_group?>/registration') }}">Register</a></p>
        {!! $form->close() !!}
    </div>

@endsection