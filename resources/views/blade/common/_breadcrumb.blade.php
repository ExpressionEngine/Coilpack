		<section class="row pad breadcrumb">
			<section class="w-16">
				<ul>
					{{-- always show the homepage --}}
					<li><a href="{{ $global->homepage }}">{{ $global->site_name }}</a></li>
					{{-- check for channel, category --}}
					@if($entry_ch ?? null)
						<li><a href="{{ $exp->path($p_url) }}">{{ $p_title }}</a></li>
						<li>{{ $exp->channel->entries(['channel' => $entry_ch, 'limit' => 1])->title }}</li>
					@elseif($cat_ch ?? null)
						<li><a href="{{ $exp->path($p_url) }}">{{ $p_title }}</a></li>
						<li>{{ $exp->channel->category_heading(['channel' => $cat_ch])->category_name }}</li>
					@else
						{{-- check for search results --}}
						@if($search ?? null)
							<li><a href="{{ $exp->path($p_url) }}">{{ $p_title }}</a></li>
							@if($search == 'y')
								<li>{exp:search:total_results} search result{if '{exp:search:total_results}' != 1}s{/if} for <mark>{exp:search:keywords}</mark></li>
							@else
								<li>0 search results for <mark>{exp:search:keywords}</mark></li>
							@endif
						@else
							<li>{{ $p_title }}</li>
						@endif
					@endif
				</ul>
			</section>
		</section>