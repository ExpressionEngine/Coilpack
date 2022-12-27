@extends('coilpack::blade/layouts/_html-wrapper')

{{-- embed for breadcrumb, needed to pass arguments (embeds aren't evil) --}}
@section('breadcrumbs')
	@include('coilpack::blade/common/_breadcrumb')
@endsection

@push('scripts')
	<script src="{{ $global->theme_user_folder_url }}site/default/asset/js/plugins/validate.min.js"></script>
@endpush

@section('contents')
		<section class="row reverse pad">
			<section class="w-12">
				@yield('contact_contents')
			</section>
			<section class="w-4">
				{{-- output contact info --}}
                @php
				    $entry = $exp->channel->entries(['channel' => $ch, 'disable' => $ch_disable, 'limit' => 1]);
                @endphp
					<address class="v-card">
						<strong class="org">{{ $global->site_name }}</strong>
						@if($entry->contact_address)
							@foreach($entry->contact_address as $contact_address)
								<span class="address">
									<span class="street">{{ $contact_address->street }}</span>, <span class="street-2">{{ $contact_address->street_2 }}</span><br>
									<span class="city">{{ $contact_address->city }}</span>, <span class="state">{{ $contact_address->state }}</span> <span class="zip">{{ $contact_address->zip }}</span>
								</span>
							@endforeach
						@endif
						@if($entry->contact_phone || $entry->contact_email)
							<span class="alternate">
								@if($entry->contact_phone) <span class="phone">{{ $entry->contact_phone }}</span>@endif
								@if($entry->contact_phone && $entry->contact_email)<br>@endif
								@if($entry->contact_email) <span class="e-mail">{{ $entry->contact_email }}</span>@endif
							</span>
						@endif
					</address>
			</section>
		</section>
@endsection
