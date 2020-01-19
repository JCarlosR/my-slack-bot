<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Slack\ApiClient;
use App\SlackEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SlackController extends Controller
{

    public function action(Request $request)
    {
        /*
         * If an OpsGenie ticket is closed, it produces a "bot_message" notifying it, but also
         * a "message_changed" updating the button actions in the original bot notification message of a new ticket
         */
        $requestContent = $request->getContent();
        $contentData = json_decode($requestContent);

        $slackEvent = $this->storeSlackEvent($requestContent, $contentData);

        // acknowledge OpsGenie ticket when appropriate
        if (env('ACK_OG_TICKETS', false) && $ticketNumber = $this->iWantToAck($slackEvent)) {
            return $this->ackTicket($slackEvent->event_channel, $ticketNumber);
        }

        return $request->input('challenge');
    }

    private function sanitizeAbsentProperties(&$object, $propertyNames)
    {
        foreach ($propertyNames as $propertyName) {
            $object = $this->sanitizeAbsentProperty($object, $propertyName);
        }

        return $object;
    }

    private function sanitizeAbsentProperty(&$object, $propertyName, $defaultValue=null)
    {
        if (!isset($object->{$propertyName}))
            $object->{$propertyName} = $defaultValue;

        return $object;
    }

    private function storeSlackEvent($requestContent, $contentData)
    {
        $targetChannels = [
            env('TARGET_CHANNEL_ID'),
            env('IM_CHANNEL_ID'),
        ];

        $event = $contentData->event;

        if (!in_array($event->channel, $targetChannels))
            return null;

        // sanitize no present properties
        $this->sanitizeAbsentProperties($event, [
            'type', 'subtype',
            'text',
            'bot_id', 'channel_type',
            'message',
            'previous_message'
        ]);

        $this->sanitizeAbsentProperty($event, 'hidden', false);

        $slackEventData = [
            'content' => $requestContent,

            'token' => $contentData->token,
            'team_id' => $contentData->team_id,
            'api_app_id' => $contentData->api_app_id,

            'type' => $contentData->type,
            'event_id' => $contentData->event_id,
            'event_time' => $contentData->event_time,

            'event_type' => $event->type,
            'event_subtype' => $event->subtype,

            'event_hidden' => $event->hidden,
            'event_text' => $event->text,
            'event_ts' => $event->ts,
            'event_bot_id' => $event->bot_id,
            'event_channel' => $event->channel,
            'event_channel_type' => $event->channel_type
        ];

        if (isset($event->attachments[0])) {
            $eventAttachment = $event->attachments[0];

            $this->sanitizeAbsentProperties($eventAttachment, [
                'author_name', 'fallback', 'text', 'title', 'color'
            ]);

            $slackEventData += [
                'attachment_author_name' => $eventAttachment->author_name,
                'attachment_fallback' => $eventAttachment->fallback,
                'attachment_text' => $eventAttachment->text,
                'attachment_title' => $eventAttachment->title,
                'attachment_color' => $eventAttachment->color
            ];
        }

        if ($event->message) {
            $slackEventData += [
                'event_message_type' => $event->message->type,
                'event_message_subtype' => $event->message->subtype,
                'event_message_username' => $event->message->username,
                'event_message_bot_id' => $event->message->bot_id
            ];

            if (isset($event->message->attachments[0])) {
                $messageAttachment = $event->message->attachments[0];

                $this->sanitizeAbsentProperties($messageAttachment, [
                   'fallback', 'text', 'title', 'title_link', 'footer', 'color', 'fields', 'actions'
                ]);

                $slackEventData += [
                    'message_attachment_fallback' => $messageAttachment->fallback,
                    'message_attachment_text' => $messageAttachment->text,
                    'message_attachment_title' => $messageAttachment->title,
                    'message_attachment_title_link' => $messageAttachment->title_link,
                    'message_attachment_footer' => $messageAttachment->footer,
                    'message_attachment_color' => $messageAttachment->color,
                    'message_attachment_fields' => $messageAttachment->fields,
                    'message_attachment_actions' => $messageAttachment->actions
                ];
            }
        }

        if ($event->previous_message) {
            $slackEventData += [
                'previous_message_type' => $event->previous_message->type,
                'previous_message_subtype' => $event->previous_message->subtype,
                'previous_message_username' => $event->previous_message->username,
                'previous_message_bot_id' => $event->previous_message->bot_id,
            ];

            if (isset($event->previous_message->attachments[0])) {
                $previousAttachment = $event->previous_message->attachments[0];

                $this->sanitizeAbsentProperties($previousAttachment, [
                    'author_name', 'fallback', 'text', 'title', 'title_link', 'color', 'fields', 'actions'
                ]);

                $slackEventData += [
                    'previous_attachment_author_name' => $previousAttachment->author_name,
                    'previous_attachment_fallback' => $previousAttachment->fallback,
                    'previous_attachment_text' => $previousAttachment->text,
                    'previous_attachment_title' => $previousAttachment->title,
                    'previous_attachment_title_link' => $previousAttachment->title_link,
                    'previous_attachment_color' => $previousAttachment->color,
                    'previous_attachment_fields' => $previousAttachment->fields,
                    'previous_attachment_actions' => $previousAttachment->actions
                ];
            }
        }

        return SlackEvent::create($slackEventData);
    }

    private function ackTicket($channel, $ticketNumber)
    {
        $slackApiClient = new ApiClient();

        $response = $slackApiClient->postCommand(
            $channel,
            '/genie',
            "ack $ticketNumber"
        );

        return (string) $response->getBody();
    }

    private function iWantToAck(SlackEvent $slackEvent)
    {
        $isNewTicket = $slackEvent->event_subtype === 'bot_message'
            && $slackEvent->event_channel === env('TARGET_CHANNEL_ID')
            && $slackEvent->attachment_author_name === 'New Alert created via Zendesk';

        if (!$isNewTicket)
            return null;

        $containsKeywords = Str::contains($slackEvent->attachment_title, [
            'LCA SVS Redwings'
        ]);

        if ($containsKeywords) {
            return $slackEvent->getOpsGenieTicketNumber();
        }

        return null;
    }
}
