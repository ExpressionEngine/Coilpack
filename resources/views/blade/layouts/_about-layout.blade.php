@extends('coilpack::blade/layouts/_html-wrapper')

{{-- embed for breadcrumb, needed to pass arguments (embeds aren't evil) --}}
@section('breadcrumbs')
    @include('coilpack::blade/common/_breadcrumb')
    {{-- $p_url, $p_title, $entry_ch? --}}
@endsection

@section('contents')
<section class="row reverse pad">
    <section class="w-12">
        @yield('about.contents')
    </section>
    <section class="w-4">
        <div class="sidebar">
            <ul class="list">
                {{--
                    sub navigation
                    ==============
                    This is a dynamic way to create sub navigation for this section. I use the parameter dynamic='no' to prevent the URL from changing the output of a channel entries tag. I also use a status of 'Default Page' to determine the, well default page.
                    NOTE: A channel should only have one Default Page.
                --}}
                @php
                $entries = $exp->channel->entries(['channel' => $ch, 'status' => $ch_status, 'orderby' => 'status']);
                @endphp

                @foreach($entries as $entry)
                    {{-- we need to treat the default page link a little differently so we check for the 'Default Page' status and output it, then all other page links output below that. We use the orderby='status' and sort='asc' parameters to accomplish this. --}}
                    @if($entry->status == 'Default Page')
                        <li><a @if($segment_1 == $p_url && $segment_2 == '') class="act" @endif href="{{ $exp->path($p_url) }}">{{ $entry->title }}</a></li>
                    @else
                        <li><a @if($segment_2 == $entry->url_title) class="act" @endif href="{{ $exp->path("$p_url/{$entry->url_title}") }}">{{ $entry->title }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </section>
</section>
@endsection