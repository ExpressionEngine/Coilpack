@extends('ee::<?=$template_group?>._layout')
@section('title', 'Logout')

@section('contents')

    @if($global->logged_out)
        {{ $exp->redirect("<?=$template_group?>/login") }}
    @endif

    <a href="{{ $global->cp_url }}?/cp/design/template/edit/{{ $global->template_id }}" target="_blank">View Template</a>

    @php $form = $exp->member->logout_form(['return' => "<?=$template_group?>/login"]) @endphp
    {!! $form->open() !!}
        <input type="submit" value="Logout">
    {!! $form->close() !!}

@endsection