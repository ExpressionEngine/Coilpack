@extends('ee::<?=$template_group?>._layout')
@section('title', 'Role Groups')

@section('contents')

<a href="{{ $global->cp_url }}?/cp/design/template/edit/{{ $global->template_id }}" target="_blank">View Template</a>

<div class="result">
  <h2>Your member role groups:</h2>
  <ul>
    @foreach($exp->member->role_groups() as $group)
      <li>{{ $group->role_group_name }} ({{ $group->role_group_id }})</li>
    @endforeach
  </ul>
</div>

@endsection