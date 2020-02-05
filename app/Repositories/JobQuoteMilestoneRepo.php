<?php

namespace App\Repositories;

use App\Models\JobQuote;
use App\Models\JobQuoteMilestone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobQuoteMilestoneRepo
{
    public function store(JobQuote $jobQuote, array $data)
    {
        $milestones = $this->composeMilestones($jobQuote->id, $data ?? null);
        if ($milestones && count($milestones) > 0) {
            foreach ($milestones as $milestone) {
                JobQuoteMilestone::create($milestone);
            }
        }
    }

    public function update(JobQuote $jobQuote, array $data)
    {
        JobQuoteMilestone::where('job_quote_id', $jobQuote->id)->delete();
        $milestones = $this->composeMilestones($jobQuote->id, $data);

        foreach ($milestones as $milestone) {
            JobQuoteMilestone::create($milestone);
        }
    }

    private function composeMilestones($jobQuoteId, array $data)
    {
        if (!isset($data['percents']) || !isset($data['due_dates']) || !isset($data['descs'])) {
            return null;
        }

        $percents = $data['percents'];
        $dueDates = $data['due_dates'];
        $descs = $data['descs'];
        $milestones = [];

        foreach ($percents as $key => $percent) {
            if ($percent > 0 ) {
                $milestones[] = [
                    'job_quote_id' => $jobQuoteId,
                    // 'percent' => round($percent, 2),
                    'percent' => $percent,
                    'due_date' => $dueDates[$key] ?? null,
                    'desc' => $descs[$key] ?? null,
                ];
            }
        }

        return $milestones;
    }
}
