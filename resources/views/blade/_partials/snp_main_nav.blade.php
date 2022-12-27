					<ul class="main-nav">
						<li><a @if($segment_1 == '') class="act" @endif href="{{ $global->homepage }}">Home</a></li>
						<li><a @if($segment_1 == 'about') class="act" @endif href="{{ $exp->path('about') }}">About</a></li>
						<li><a @if($segment_1 == 'blog') class="act" @endif href="{{ $exp->path('blog') }}">Blog</a></li>
						<li><a @if($segment_1 == 'contact') class="act" @endif href="{{ $exp->path('contact') }}">Contact</a></li>
					</ul>