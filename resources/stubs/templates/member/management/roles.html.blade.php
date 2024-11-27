@extends('ee::<?=$template_group?>._layout')
@section('title', 'Roles')

@section('contents')

<a href="{{ $global->cp_url }}?/cp/design/template/edit/{{ $global->template_id }}" target="_blank">View Template</a>

<div class="result">
  <h2>Your member roles:</h2>
  <ul>
    @foreach($exp->member->roles() as $role)
      <li>{{ $role->name }} ({{ $role->role_id }}@if($role->is_primary_role), Primary Role@endif)</li>
    @endforeach
  </ul>
</div>

@endsection