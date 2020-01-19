@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">Slack Events</div>

            <div class="card-body">
                <form class="form-inline" method="get">
                    <select name="event_subtype" class="form-control">
                        <option value="">All Event SubTypes</option>
                        <option value="message_changed" @if ($eventSubType === 'message_changed') selected @endif>
                            message_changed
                        </option>
                        <option value="bot_message" @if ($eventSubType === 'bot_message') selected @endif>
                            bot_message
                        </option>
                    </select>

                    <select name="event_channel" class="form-control">
                        <option value="">All Channels</option>
                        <option value="{{ env('TARGET_CHANNEL_ID') }}" @if ($channel === env('TARGET_CHANNEL_ID')) selected @endif>
                            {{ env('TARGET_CHANNEL_ID') }}
                        </option>
                        <option value="{{ env('IM_CHANNEL_ID') }}" @if ($channel === env('IM_CHANNEL_ID')) selected @endif>
                            {{ env('IM_CHANNEL_ID') }}
                        </option>
                    </select>

                    <select name="json_structure" class="form-control">
                        <option value="">Any JSON Structure</option>
                        <option value="event_attachment" @if ($jsonStructure === 'event_attachment') selected @endif>
                            Has Event > Attachments[0]
                        </option>
                        <option value="event_message" @if ($jsonStructure === 'event_message') selected @endif>
                            Has Event > Message
                        </option>
                    </select>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </form>


                <p>Total captured events: {{ $rows->total() }}</p>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event SubType</th>
                            <th>Event Ts</th>
                            <th>Channel</th>
                            <th title="Event > Attachments[0]">Attachment</th>
                            <th title="Message SubType">Event > Message</th>
                            <th title="Previous Message SubType">Event > Previous</th>
                            <th>Created At</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($rows as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->event_subtype }}</td>
                                <td>{{ $row->event_ts }}</td>
                                <td title="Channel Type: {{ $row->event_channel_type }}">
                                    {{ $row->event_channel }}
                                </td>
                                @if ($row->attachment_fallback)
                                    <td>
                                        <button class="btn btn-outline-info" data-toggle="collapse" data-target="#attachment-{{ $row->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                                @if ($row->event_message_type)
                                    <td>
                                        <a href="#" data-toggle="collapse" data-target="#event-message-{{ $row->id }}">
                                            {{ $row->event_message_subtype }}
                                        </a>
                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                                @if ($row->previous_message_type)
                                    <td>
                                        <a href="#" data-toggle="collapse" data-target="#event-previous-{{ $row->id }}">
                                            {{ $row->previous_message_subtype }}
                                        </a>
                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>{{ $row->created_at }}</td>
                                <td>
                                    <a href="{{ url('events/'.$row->id) }}" class="btn btn-primary" target="_blank">
                                        <i class="fa fa-external-link"></i>
                                    </a>
                                </td>
                            </tr>
                            @if ($row->attachment_fallback)
                                <tr id="attachment-{{ $row->id }}" class="collapse">
                                    <td colspan="9">
                                        <p><strong>Event > Attachments[0]</strong></p>
                                        <ul>
                                            <li><strong>Fallback:</strong> {{ $row->attachment_fallback }}</li>
                                            <li><strong>Text:</strong> {{ $row->attachment_text }}</li>
                                            <li>
                                                <strong>Color:</strong>
                                                <span style="color: '#{{ $row->attachment_color }}';">
                                                {{ $row->attachment_color }}
                                            </span>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                            @if ($row->event_message_type)
                            <tr id="event-message-{{ $row->id }}" class="collapse">
                                <td colspan="9">
                                    <p><strong>Event > Message</strong></p>
                                    <ul>
                                        <li><strong>Type:</strong> {{ $row->event_message_type }}</li>
                                        <li><strong>SubType:</strong> {{ $row->event_message_subtype }}</li>
                                        <li><strong>Username:</strong> {{ $row->event_message_username }}</li>
                                        <li><strong>Bot Id:</strong> {{ $row->event_message_bot_id }}</li>
                                    </ul>

                                    <p><strong>Message > Attachment</strong></p>
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
                                    <p><strong>Event > Previous Message</strong></p>
                                    <ul>
                                        <li><strong>Type:</strong> {{ $row->previous_message_type }}</li>
                                        <li><strong>SubType:</strong> {{ $row->previous_message_subtype }}</li>
                                        <li><strong>Username:</strong> {{ $row->previous_message_username }}</li>
                                        <li><strong>Bot Id:</strong> {{ $row->previous_message_bot_id }}</li>
                                    </ul>

                                    <p><strong>Previous Message > Attachment</strong></p>
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
