<!doctype html>
<html dir="ltr" lang="{{ $global->lang }}">
	<head>
		<meta charset="utf-8">
		<title>{{ $title ?? '' }}{{ $global->site_name }}</title>
		<meta name="viewport" content="initial-scale=1">

		<!-- meta data -->
		@if($meta_author ?? null)<meta name="author" content="{{ $meta_author }}">@endif
		@if($meta_description ?? null)<meta name="description" content="{{ $meta_description }}">@endif

		<!-- open graph common -->
		<meta property="og:site_name" content="{{ $global->site_name }}">
		<meta property="og:type" content="website">
		<meta property="og:image" content="{{ $global->theme_user_folder_url}}site/default/asset/img/og/default.jpg"> {{-- square, 50*50 min --}}

		@if($og_title ?? null)
			<!-- open graph per page -->
			<meta property="og:title" content="{{ $og_title }}">
			<meta property="og:url" content="{{ $og_url }}">
			<meta property="og:description" content="{{ $og_description }}">
		@endif

		<link href="{{ $global->theme_user_folder_url }}site/default/asset/style/default.min.css" title="common-styles" rel="stylesheet">
		<!-- <link href="{{ $global->theme_user_folder_url }}site/default/asset/style/debug.min.css" title="common-styles" rel="stylesheet"> -->
	</head>
	<body>
		<header class="full">
			<section class="row pad">
				<section class="w-8">
					<h1><a href="{{ $global->homepage }}"><b>{{ $global->site_name }}</b> Website</a></h1>
				</section>
				<section class="w-8">
					{{-- creates a small menu link on smaller devices --}}
					<a class="small-menu" href="#"></a>
					{{-- appears in both header and footer, so a snippet is used to keep it DRY --}}
					{{-- {!! $snp_main_nav !!} --}}
                    @include('coilpack::blade/_partials/snp_main_nav')
				</section>
			</section>
		</header>

		@yield('breadcrumbs')

		<div class="content">
			@yield('contents')
		</div>

		<footer class="full">
			<section class="footer-content">
				{{-- appears in both header and footer, so a snippet is used to keep it DRY --}}
				{{-- {!! $snp_main_nav !!} --}}
                @include('coilpack::blade/_partials/snp_main_nav')
				<p>&copy;{{ $global->current_time->format('Y') }}, all rights reserved. Built with <a href="https://expressionengine.com/" rel="external">ExpressionEngine&reg;</a></p>
			</section>
		</footer>
		</section>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" ></script>
		<script src="{{ $global->theme_user_folder_url }}site/default/asset/js/default.min.js" ></script>
		<script src="{{ $global->theme_user_folder_url }}site/default/asset/js/plugins/cycle2.min.js"></script>
		@yield('scripts')
	</body>
</html>
