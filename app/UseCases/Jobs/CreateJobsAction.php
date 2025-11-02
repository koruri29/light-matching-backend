<?php

namespace App\UseCases\Jobs;

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

        // トランザクション
        $result = DB::transaction(function () use ($jobPost, $tags, $dates) {
            // 募集情報の登録
            try {
                $jobPostResult = $this->postRepository->create($jobPost);
            } catch (Exception $e) {
                Log::error('募集の登録に失敗しました。エラー', ['error' => $e->getMessage()]);
                return [
                    'success' => false,
                    'error' => '募集の登録に失敗しました。エラー: ' . $e,
                ];
            }

            // タグの登録
            try {
                foreach($tags as $key => $value) {
                    if ($value) {
                        $tag = ['tag' => $key, 'job_post_id' => $jobPostResult->id];
                        $this->tagRepository->create($tag);
                    }
                }
            } catch (Exception $e) {
                Log::error('募集タグの登録に失敗しました。エラー', ['error' => $e->getMessage()]);
                return [
                    'success' => false,
                    'error' => '募集タグの登録に失敗しました。エラー: ' . $e,
                ];
            }

            // 日付の登録
            try {
               foreach($dates as $date) {
                    $date['job_post_id'] = $jobPostResult->id;
                    $this->dateRepository->create($date);
                }
            } catch (Exception $e) {
                Log::error('募集日付の登録に失敗しました。エラー', ['error' => $e->getMessage()]);
                return [
                    'success' => false,
                    'error' => '募集日付の登録に失敗しました。エラー: ' . $e,
                ];
            }

            return [
                'success' => true,
                'id' => $jobPostResult->id,
            ];
        });

        return $result;
    }
}
