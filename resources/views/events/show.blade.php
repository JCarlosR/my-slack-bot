@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('events') }}">Slack Events</a> / Event {{ $slackEvent->id }}
            </div>

            <div class="card-body">
                <p>Full content:</p>
                <pre>{{ $slackEvent->pretty_content }}</pre>

                <li>Event SubType: {{ $slackEvent->event_subtype }}</li>
                <li>Event Ts: {{ $slackEvent->event_ts }}</li>
                <li>Channel Type: {{ $slackEvent->event_channel_type }}</li>
                <li>Channel: {{ $slackEvent->event_channel }}</li>
                @if ($slackEvent->event_message_type)
                    <li>Event Message SubType: {{ $slackEvent->event_message_subtype }}</li>
                @endif
                @if ($slackEvent->previous_message_type)
                    <li>Previous Message SubType: {{ $slackEvent->previous_message_subtype }}</li>
                @endif

                <li>Created At: {{ $slackEvent->created_at }}</li>

                @if ($slackEvent->event_message_type)
                    <div>
                        <p><strong>Event Message</strong></p>
                        <ul>
                            <li><strong>Type:</strong> {{ $slackEvent->event_message_type }}</li>
                            <li><strong>SubType:</strong> {{ $slackEvent->event_message_subtype }}</li>
                            <li><strong>Username:</strong> {{ $slackEvent->event_message_username }}</li>
                            <li><strong>Bot Id:</strong> {{ $slackEvent->event_message_bot_id }}</li>
                        </ul>

                        <p><strong>Attachment</strong></p>
                        <ul>
                            <li><strong>Fallback:</strong> {{ $slackEvent->message_attachment_fallback }}</li>
                            <li><strong>Text:</strong> {{ $slackEvent->message_attachment_text }}</li>
                            <li><strong>Title:</strong> {{ $slackEvent->message_attachment_title }}</li>
                            <li><strong>Footer:</strong> {{ $slackEvent->message_attachment_footer }}</li>
                            <li><strong>Title Link:</strong> {{ $slackEvent->message_attachment_title_link }}</li>
                            <li>
                                <strong>Color:</strong>
                                <span style="color: '#{{ $slackEvent->message_attachment_color }}';">
                                        {{ $slackEvent->message_attachment_color }}
                                    </span>
                            </li>
                        </ul>
                    </div>
                @endif
                @if ($slackEvent->previous_message_type)
                    <div>
                        <p><strong>Event Previous Message</strong></p>
                        <ul>
                            <li><strong>Type:</strong> {{ $slackEvent->previous_message_type }}</li>
                            <li><strong>SubType:</strong> {{ $slackEvent->previous_message_subtype }}</li>
                            <li><strong>Username:</strong> {{ $slackEvent->previous_message_username }}</li>
                            <li><strong>Bot Id:</strong> {{ $slackEvent->previous_message_bot_id }}</li>
                        </ul>

                        <p><strong>Attachment</strong></p>
                        <ul>
                            <li><strong>Author Name:</strong> {{ $slackEvent->previous_attachment_author_name }}</li>
                            <li><strong>Fallback:</strong> {{ $slackEvent->previous_attachment_fallback }}</li>
                            <li><strong>Text:</strong> {{ $slackEvent->previous_attachment_text }}</li>
                            <li><strong>Title:</strong> {{ $slackEvent->previous_attachment_title }}</li>
                            <li><strong>Title Link:</strong> {{ $slackEvent->previous_attachment_title_link }}</li>
                            <li>
                                <strong>Color:</strong>
                                <span style="color: '#{{ $slackEvent->previous_attachment_color }}';">
                                        {{ $slackEvent->previous_attachment_color }}
                                    </span>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
