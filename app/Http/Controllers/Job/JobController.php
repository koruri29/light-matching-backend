<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Resources\JobSummaryResource;
use App\UseCases\Jobs\CreateJobsAction;
use App\UseCases\Jobs\GetJobSummaryAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobController extends Controller
{
    public function store(StoreJobPostRequest $request, CreateJobsAction $action): JsonResponse
    {
        $result = $action->execute($request->validated());
        return response()->json([
            'success' => $result['success'],
            'data' => $result['success'] ? ['id' => $result['id']] : [],
            'message' => $result['success'] ? '投稿が完了しました。' : '投稿に失敗しました。',
        ], 200);
    }

    public function getJobSummary(Request $request, GetJobSummaryAction $getSummary): JsonResource
    {
        $jobSummary = $getSummary($request);
        return new JobSummaryResource($jobSummary);
    }
}
