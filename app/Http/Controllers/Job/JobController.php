<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Resources\JobPostViewResource;
use App\UseCases\Jobs\CreateJobsAction;
use App\UseCases\Jobs\GetJobPostCountsAction;
use App\UseCases\Jobs\GetJobPostsAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

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

    public function getJobPostCountsByDate(GetJobPostCountsAction $getCounts): Collection
    {
        return $getCounts();
    }

    public function getJobs(Request $request, GetJobPostsAction $getJobPosts): JsonResponse
    {
        $paginator = $getJobPosts($request->perPage || 20);
        // $paginator->setCollection(
        //     $paginator->getCollection()->flatMap(fn ($job) => JobPostViewResource::make($job)->toArray(request()))->values()
        // );
        return response()->json($paginator);
    }
}
