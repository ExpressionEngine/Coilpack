@extends('coilpack::blade/layouts/_html-wrapper')

@php
// page vars (prefix p_)
$p_url_cat = 'category';
@endphp

{{-- embed for breadcrumb, needed to pass arguments (embeds aren't evil) --}}
@section('breadcrumbs')
	@include('coilpack::blade/common/_breadcrumb')
@endsection

@push('scripts')
	<script src="{{ $global->theme_user_folder_url }}site/default/asset/js/plugins/validate.min.js"></script>
@endpush

@section('contents')
		<section class="row pad">
			<section class="w-12">
				@yield('blog_contents')
			</section>
			<section class="w-4">
				<div class="sidebar">
					{!!
                        $exp->search->simple_form([
                            'form_class' => 'search',
                            'channel' => $ch,
                            'search_in' => 'everywhere',
                            'where' => 'all',
                            'result_page' => "{$p_url}/search",
                            'no_result_page' => "{$p_url}/no-results",
                            'results' => '5',
                        ])
					!!}
						<input type="text" name="keywords" id="keywords" value="" placeholder="Type keywords, hit enter">
                    </form>
					<h2>Categories</h2>
					<ul class="list yes">
						@foreach($exp->channel->categories(['channel' => $ch, 'style' => 'linear']) as $category)
							<li><a href="{{ $exp->path("$p_url/$p_url_cat/$category->category_url_title") }}">{{ $category->category_name }}</a></li>
						@endforeach
					</ul>
					<h2>RSS Feed</h2>
					<ul class="list rss">
						<li><a href="{{ $exp->path("$p_url/rss") }}">Subscribe to {{ $p_title }}</a></li>
					</ul>
				</div>

			</section>
		</section>
@endsection