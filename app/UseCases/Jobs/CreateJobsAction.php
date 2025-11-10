<?php

namespace App\UseCases\Jobs;

use App\Models\JobTag;
use App\Repositories\JobPost\JobPostRepositoryInterface;
use App\Repositories\JobPostDate\JobPostDateRepositoryInterface;
use App\Repositories\JobPostTags\JobPostTagsRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateJobsAction
{
    private JobPostRepositoryInterface $postRepository;

    private JobPostTagsRepositoryInterface $tagRepository;

    private JobPostDateRepositoryInterface $dateRepository;

    public function __construct(
        JobPostRepositoryInterface $postRepository,
        JobPostTagsRepositoryInterface $tagRepository,
        JobPostDateRepositoryInterface $dateRepository,
    )
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->dateRepository = $dateRepository;
    }

    public function execute(array $data) {
        $userId = Auth::user()->id;

        // タグとそれ以外に分離
        $jobPost = $data['job_post'];
        $jobPost['client_id'] = $userId;
        $tags = $data['tags'];
        $dates = $data['dates'];

        try {
            $result = DB::transaction(function () use ($jobPost, $tags, $dates) {
                // 募集情報
                $jobPostResult = $this->postRepository->create($jobPost);

                // タグ
                foreach ($tags as $name => $value) {
                    if ($value) {
                        $tag = JobTag::where('name', $name)->first();
                        if ($tag) {
                            $this->tagRepository->create([
                                'job_post_id' => $jobPostResult->id,
                                'job_tag_id'  => $tag->id,
                            ]);
                        }
                    }
                }

                // 日付
                foreach ($dates as $date) {
                    $date['job_post_id'] = $jobPostResult->id;
                    $this->dateRepository->create($date);
                }

                return $jobPostResult->id;
            });

            return [
                'success' => true,
                'id' => $result,
            ];
        } catch (Exception $e) {
            Log::error('CreateJobsAction failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
