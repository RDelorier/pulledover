<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Phone\TwilioClient;
use App\PhoneNumber;
use Illuminate\Log\Writer as Logger;

class NotifyFriendsOfRecording extends Job
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function handle(TwilioClient $twilio, Logger $logger)
    {
        $user = PhoneNumber::findByNumber($this->request->get('From'))->user;

        $text = sprintf(
            "Your friend {$user->name} made PulledOver recording. From %s : %s",
            $this->request->get("From"),
            $this->request->get("RecordingUrl")
        );

        $user->friends()->verified()->get()->each(function ($friend) use ($user, $twilio, $text) {
            $twilio->text($friend->number, $text);
        });

        $logger->info('Friends SMS sent: ' . $text);
    }
}
