{{-- comments --}}
<div id="comments" class="comments">
	<h2>Commentary</h2>
	{{-- comment entries --}}
	@forelse($exp->comment->entries(['channel' => $ch, 'url_title' => $segment_3]) as $comment)
		<div class="comment @if($comment->author_id == $entry->author_id) author @endif" @if($loop->last) id="last-comment"@endif>
			<section class="row">
				<section class="w-12">
					{{-- change the comment text output if the commenter is being ignored by the logged in user. --}}
					@if($comment->is_ignored)
						<div class="alert warn">
							<p>{{ $global->gv_comment_ignore }} <b>{{ $comment->name }}</b>.</p>
						</div>
					@else
						{!! $comment->comment !!}
					@endif
				</section>
				<section class="w-4">
					{{-- mark the author of the post, and ignored differently than other commenters --}}
					<h3 @if($comment->author_id == $entry->author_id) class="author" title="Author of Entry" @elseif($comment->is_ignored) class="ignored" title="Troll"@endif>
						@if($comment->url)
							<a href="{{ $comment->url }}" rel="external">{{ $comment->name }}</a>
						@else
							{{ $comment->url_as_author }}
						@endif
					</h3>
					<p>on {{ \Carbon\Carbon::createFromTimestamp($comment->comment_date)->format('n/j/y') }} @if($comment->location)<br>from {{ $comment->location }}@endif</p>
				</section>
			</section>
		</div>
		{{--
			no results output
			===================
			If there are no comments, show this message.
		--}}
    @empty
        <div class="alert warn no-results">
            <p>{!! $global->gv_comment_none !!}</p>
        </div>
	@endforelse

    {{-- comment form --}}
	<div class="alert issue hide"></div>
	{{
        $exp->comment->form([
            'channel' => $ch,
            'form_class' => 'comment-form',
            'return' => "${segment_1}/${segment_2}/${segment_3}#last-comment"
        ])
    }}
		{{-- if the user is logged out show more fields for commenting --}}
		{{-- @if($logged_out) --}}
			<h2>Comment as a guest <span class="required">Required Fields &#10033;</span></h2>
			<fieldset class="row">
				<section class="w-4 instruct">
					<label>Name <span class="required" title="required field">&#10033;</span></label>
					<em>What do you want to be called?</em>
				</section>
				<section class="w-12 field">
					<input class="required" name="name" type="text" value="{name}">
				</section>
			</fieldset>
			<fieldset class="row">
				<section class="w-4 instruct">
					<label>e-mail <span class="required" title="required field">&#10033;</span></label>
					<em>How do we contact you?</em>
				</section>
				<section class="w-12 field">
					<input class="required" name="email" type="text" value="{email}">
				</section>
			</fieldset>
			<fieldset class="row">
				<section class="w-4 instruct">
					<label>Location</label>
					<em>Where are you commenting from?</em>
				</section>
				<section class="w-12 field">
					<input name="location" type="text" value="{location}">
				</section>
			</fieldset>
			<fieldset class="row">
				<section class="w-4 instruct">
					<label><abbr title="Unified Resource Locator">URL</abbr></label>
					<em>Do you have a website to share?</em>
				</section>
				<section class="w-12 field">
					<input name="url" type="text" value="{url}">
				</section>
			</fieldset>
		{{-- @else
			<h2>Comment as <b>{screen_name}</b> <span class="required">&#10033; Required Fields</span></h2>
		@endif --}}
		<fieldset class="row">
			<section class="w-4 instruct">
				<label>Comment? <span class="required" title="required field">&#10033;</span></label>
				<em>Please keep it kind, brief and courteous.</em>
			</section>
			<section class="w-12 field">
				<textarea class="required" name="comment" cols="" rows=""></textarea>
			</section>
		</fieldset>
		<fieldset class="row">
			<section class="w-4 instruct">
				<label>Options</label>
				<em>Extra stuff we can do!</em>
			</section>
			<section class="w-12 field checks">
				<label><input type="checkbox" name="save_info" value="yes" {save_info}> Remember Me?</label>
				<label><input type="checkbox" name="notify_me" value="yes" {notify_me}> Notify Me?</label>
			</section>
		</fieldset>
		<fieldset class="ctrls">
			<input class="btn" type="submit" value="Comment">
		</fieldset>
	</form>
</div>
