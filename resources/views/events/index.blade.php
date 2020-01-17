@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">Slack Events</div>

            <div class="card-body">
                <p>Total captured events: {{ $rows->total() }}</p>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Event Type</th>
                            <th>Event SubType</th>
                            <th>Event Ts</th>
                            <th>Channel</th>
                            <th>Event Message SubType</th>
                            <th>Previous Message SubType</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($rows as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->type }}</td>
                                <td>{{ $row->event_type }}</td>
                                <td>{{ $row->event_subtype }}</td>
                                <td>{{ $row->event_ts }}</td>
                                <td title="Channel Type: {{ $row->event_channel_type }}">
                                    {{ $row->event_channel }}
                                </td>
                                @if ($row->event_message_type)
                                    <td data-toggle="collapse" data-target="#event-message-{{ $row->id }}">
                                        {{ $row->event_message_subtype }}
                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                                @if ($row->previous_message_type)
                                    <td data-toggle="collapse" data-target="#event-previous-{{ $row->id }}">
                                        {{ $row->previous_message_subtype }}
                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>{{ $row->created_at }}</td>
                            </tr>
                            @if ($row->event_message_type)
                            <tr id="event-message-{{ $row->id }}" class="collapse">
                                <td colspan="9">
                                    <p><strong>Event Message</strong></p>
                                    <ul>
                                        <li><strong>Type:</strong> {{ $row->event_message_type }}</li>
                                        <li><strong>SubType:</strong> {{ $row->event_message_subtype }}</li>
                                        <li><strong>Username:</strong> {{ $row->event_message_username }}</li>
                                        <li><strong>Bot Id:</strong> {{ $row->event_message_bot_id }}</li>
                                    </ul>

                                    <p><strong>Attachment</strong></p>
                                    <ul>
                                        <li><strong>Fallback:</strong> {{ $row->message_attachment_fallback }}</li>
                                        <li><strong>Text:</strong> {{ $row->message_attachment_text }}</li>
                                        <li><strong>Title:</strong> {{ $row->message_attachment_title }}</li>
                                        <li><strong>Footer:</strong> {{ $row->message_attachment_footer }}</li>
                                        <li><strong>Title Link:</strong> {{ $row->message_attachment_title_link }}</li>
                                        <li>
                                            <strong>Color:</strong>
                                            <span style="color: '#{{ $row->message_attachment_color }}';">
                                                {{ $row->message_attachment_color }}
                                            </span>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endif
                            @if ($row->previous_message_type)
                            <tr id="event-previous-{{ $row->id }}" class="collapse">
                                <td colspan="9">
                                    <strong>Event Previous Message</strong>
                                    <ul>
                                        <li><strong>Type:</strong> {{ $row->previous_message_type }}</li>
                                        <li><strong>SubType:</strong> {{ $row->previous_message_subtype }}</li>
                                        <li><strong>Username:</strong> {{ $row->previous_message_username }}</li>
                                        <li><strong>Bot Id:</strong> {{ $row->previous_message_bot_id }}</li>
                                    </ul>

                                    <p><strong>Attachment</strong></p>
                                    <ul>
                                        <li><strong>Author Name:</strong> {{ $row->previous_attachment_author_name }}</li>
                                        <li><strong>Fallback:</strong> {{ $row->previous_attachment_fallback }}</li>
                                        <li><strong>Text:</strong> {{ $row->previous_attachment_text }}</li>
                                        <li><strong>Title:</strong> {{ $row->previous_attachment_title }}</li>
                                        <li><strong>Title Link:</strong> {{ $row->previous_attachment_title_link }}</li>
                                        <li>
                                            <strong>Color:</strong>
                                            <span style="color: '#{{ $row->previous_attachment_color }}';">
                                                {{ $row->previous_attachment_color }}
                                            </span>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                    {{ $rows->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
