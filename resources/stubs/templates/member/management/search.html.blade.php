@extends('ee::<?=$template_group?>._layout')
@section('title', 'Member Search')

@section('contents')

<a href="{{ $global->cp_url }}?/cp/design/template/edit/{{ $global->template_id }}" target="_blank">View Template</a>

<div class="result">

    @php $form = $exp->member->member_search(['return' => "<?=$template_group?>/index", 'inline_errors' => "yes"]); @endphp

    {!! $form->open() !!}
        @unless($form->errors()->isEmpty())
            <fieldset class="error">
                <legend>Errors</legend>
                @foreach($form->errors() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </fieldset>
        @endunless
        <input type="text" name="search_keywords_1" />
        <select name='search_field_1' class='select' >
            <option value='screen_name'>Search Field</option>
            <option value='screen_name'>Screen Name</option>
            <option value='email'>Email Address</option>
            {!! $form->options['custom_profile_field_options'] !!}
        </select>

        @if(!empty($form->options->group_id_options))
        <select name='search_group_id' class='select' >
            {!! $form->options['group_id_options'] !!}
        </select>
        @endif

        <div class="itempadbig">&nbsp; <input type='submit' value='search' class='submit' /></div>

    {!! $form->close() !!}
</div>

@endsection