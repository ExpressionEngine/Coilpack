@extends('coilpack::blade/layouts/_contact-layout')

{{--
	404 Redirect
	============
	This is a single entry channel page, it only needs a second segment when the form has been successfully submitted. So we use the following code to make sure the page sends a 404 if someone types in an incorrect URL in the browser address bar. i.e. http://example.com/page/nothing
--}}
@if($segment_2 and $segment_2 != 'thanks')
    {{ redirect('404') }}
@endif


@php
// page vars (prefix p_)
$p_title="contact $global->site_name";
$p_description="contact $global->site_name";
$p_url='contact';
// channel vars (prefix ch_)
$ch='contact';
$ch_disable='categories|category_fields|member_data|pagination';

$entry = $exp->channel->entries(['channel' => $ch, 'disable' => $ch_disable, 'limit' => 1]);

/*
    no results redirect
    ===================
    If the page doesn't exist, we redirect to 404.
*/
if(!$entry) {
    return redirect(404);
}

@endphp

{{-- every template using the blog layout will set these which lets us use
	 shared markup with customizable details. --}}

{{-- layout vars, channel/page related --}}
@section('ch', $ch)
@section('p_url', $p_url)
@section('p_title', $p_title)
{{-- layout vars, dynamic, not output --}}
@section('title', $entry->seo_title . $global->gv_sep)
@section('description', $entry->seo_description)
{{-- OpenGraph meta output --}}
@section('og_title', $entry->seo_title)
@section('og_url', $exp->path($p_url))
@section('og_description', $entry->seo_description)

@section('contact_contents')
{{-- content output --}}
<h1>{{ $entry->title }} <span class="required">Required Fields &#10033;</span></h1>
{{-- page_content is a textarea with HTML output we don't need to wrap this tag with HTML as that is already included in it's output. --}}
{!! $entry->page_content !!}
{{-- /content output --}}


		<div class="alert issue hide"></div>
		{{-- only show this thank you message if segment_2 is thanks --}}
		@if($segment_2 == 'thanks')
			<div class="alert success">
				<h3>email sent</h3>
				<p>Thanks, your email was sent, we'll respond in 48 hours or less.</p>
				<a class="close" href="{path='{p_url}'}">&#10005; Close</a>
			</div>
		@endif
		{{-- email contact form --}}

		@php
        $form = $exp->email->contact_form->parameters([
            'form_class' => 'contact-form',
            'return' => "{$global->site_url}index.php/{$p_url}/thanks",
            'redirect' => '0'
        ]);
        @endphp
        {!! $form->open() !!}
			<fieldset class="row">
				<section class="w-4 instruct">
					<label>Name</label>
					<em>What do you want to be called?</em>
				</section>
				<section class="w-12 field">
					<input name="name" type="text" value="{{ $form->member_name }}">
				</section>
			</fieldset>
			<fieldset class="row">
				<section class="w-4 instruct">
					<label>Email <span class="required" title="required field">&#10033;</span></label>
					<em>How do we contact you?</em>
				</section>
				<section class="w-12 field">
					<input class="required" name="from" type="text" value="{{ $form->member_email }}">
				</section>
			</fieldset>
			<fieldset class="row">
				<section class="w-4 instruct">
					<label>Subject</label>
					<em>What did you want to discuss?</em>
				</section>
				<section class="w-12 field">
					<input name="subject" type="text" value="">
				</section>
			</fieldset>
			<fieldset class="row">
				<section class="w-4 instruct">
					<label>Message <span class="required" title="required field">&#10033;</span></label>
					<em>Please keep it kind, brief and courteous.</em>
				</section>
				<section class="w-12 field">
					<textarea class="required" name="message" cols="" rows=""></textarea>
				</section>
			</fieldset>
			<fieldset class="ctrls">
				<input class="btn" type="submit" value="Send e-mail">
			</fieldset>
        {!! $form->close() !!}
@endsection