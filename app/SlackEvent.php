<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlackEvent extends Model
{
    protected $fillable = [
        'content',

        'token',
        'team_id',
        'api_app_id',

        'type',
        'event_id',
        'event_time',

        'event_type',
        'event_subtype',
        'event_hidden',
        'event_text',
        'event_ts',
        'event_bot_id',
        'event_channel',
        'event_channel_type',

    // event -> message

        'event_message_type',
        'event_message_subtype',
        'event_message_username',
        'event_message_bot_id',

        'message_attachment_fallback',
        'message_attachment_text',
        'message_attachment_title',
        'message_attachment_footer',
        'message_attachment_title_link',
        'message_attachment_color',
        'message_attachment_fields',
        'message_attachment_actions',

    // event -> previous message

        'previous_message_type',
        'previous_message_subtype',
        'previous_message_username',
        'previous_message_bot_id',

        'previous_attachment_author_name',
        'previous_attachment_fallback',
        'previous_attachment_text',
        'previous_attachment_title',
        'previous_attachment_title_link',
        'previous_attachment_color',
        'previous_attachment_fields',
        'previous_attachment_actions',
    ];

    protected $casts = [
        'message_attachment_fields' => 'array',
        'message_attachment_actions' => 'array',
        'previous_attachment_fields' => 'array',
        'previous_attachment_actions' => 'array'
    ];
}