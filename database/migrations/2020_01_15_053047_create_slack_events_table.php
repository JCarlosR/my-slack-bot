<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlackEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slack_events', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('content'); // original

            $table->string('token');
            $table->string('team_id');
            $table->string('api_app_id');
            $table->string('type');

            $table->string('event_id')->nullable();
            $table->string('event_time')->nullable();

            $table->string('event_type')->nullable();
            $table->string('event_subtype')->nullable();
            $table->boolean('event_hidden')->default(false);
            $table->text('event_text')->nullable();
            $table->string('event_ts')->nullable();
            $table->string('event_bot_id')->nullable();
            $table->string('event_channel')->nullable();
            $table->string('event_channel_type')->nullable();

            // event -> attachments[0]

            $table->text('attachment_author_name')->nullable();
            $table->text('attachment_fallback')->nullable();
            $table->text('attachment_text')->nullable();
            $table->text('attachment_title')->nullable();
            $table->string('attachment_color')->nullable();

            // event -> message

            $table->string('event_message_type')->nullable();
            $table->string('event_message_subtype')->nullable();
            $table->string('event_message_username')->nullable();
            $table->string('event_message_bot_id')->nullable();

            $table->string('message_attachment_fallback')->nullable();
            $table->text('message_attachment_text')->nullable();
            $table->string('message_attachment_title')->nullable();
            $table->string('message_attachment_footer')->nullable();
            $table->string('message_attachment_title_link')->nullable();
            $table->string('message_attachment_color')->nullable();
            $table->json('message_attachment_fields')->nullable();
            $table->json('message_attachment_actions')->nullable();

            // event -> previous message

            $table->string('previous_message_type')->nullable();
            $table->string('previous_message_subtype')->nullable();
            $table->string('previous_message_username')->nullable();
            $table->string('previous_message_bot_id')->nullable();

            $table->string('previous_attachment_author_name')->nullable();
            $table->string('previous_attachment_fallback')->nullable();
            $table->text('previous_attachment_text')->nullable();
            $table->string('previous_attachment_title')->nullable();
            $table->string('previous_attachment_title_link')->nullable();
            $table->string('previous_attachment_color')->nullable();
            $table->json('previous_attachment_fields')->nullable();
            $table->json('previous_attachment_actions')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slack_events');
    }
}
