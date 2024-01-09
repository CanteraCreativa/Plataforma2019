<?php

namespace App\Http\Controllers;

use App\Notifications\ReviewSubmission;
use Illuminate\Http\Request;

use \App\Enums\SubmissionState;
use \App\Models\Submission;


class ReviewSubmissionController extends Controller
{
    public function __invoke(Request $request, Submission $submission)
    {
        $request->validate([
            'review_observation' => 'sometimes|string|nullable',
            'action' => 'in:reject,accept',
        ]);

        $state = SubmissionState::Pending();

        switch($request->input('action')) {
            case 'reject':
                $state = SubmissionState::Rejected();
                break;
            case 'accept':
                $state = SubmissionState::Accepted();
                break;
        }

        $submission->update([
            'state' => $state,
            'review_observation' => $request->input('review_observation'),
        ]);

        $submission->creativeData->account->user->notifySubmissionReview($submission);

        return redirect()->back()->with('message', 'Pieza actualizada');
    }
}
