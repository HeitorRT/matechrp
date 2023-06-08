<?php

namespace App\Services\Admin;

use App\Enums\AnswerTypeEnum;
use App\Models\Question;
use App\Models\Quizz;
use Illuminate\Support\Arr;

class QuestionService
{
    /**
     * @var UploadImageService
     */
    protected UploadImageService $uploadImageService;

    /**
     * @param UploadImageService $uploadImageService
     */
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }

    /**
     * @param Quizz $quizz
     * @param null|array $requestQuestions
     * @return void
     */
    public function deleteRecordsOutsideTheIdRange(Quizz $quizz, null|array $requestQuestions = []): void
    {
        if (is_array($requestQuestions)) {
            $quizz->questions()
                ->whereNotIn('id', data_get($requestQuestions, '*.id'))
                ->each(fn(Question $question) => $question->delete());
        }
    }

    /**
     * @param Question $question
     * @return boolean
     */
    public function delete(Question $question): bool
    {
        $question->alternatives()->delete();

        $this->uploadImageService->delete($question, 'image');

        return $question->delete();
    }

    /**
     * @param Quizz $quizz
     * @param null|array $requestQuestions
     * @return void
     */
    public function createOrUpdateQuestions(Quizz $quizz, null|array $requestQuestions = []): void
    {
        $this->deleteRecordsOutsideTheIdRange($quizz, $requestQuestions);

        if($requestQuestions) {
            $count = 1;

            foreach ($requestQuestions as $requestQuestion) {
                $hasVideo = Arr::get($requestQuestion, 'has_video');
                $hasAudio = Arr::get($requestQuestion, 'has_audio');
                $hasImage = Arr::get($requestQuestion, 'has_image');

                /** @var Question */
                $question = $quizz->questions()->updateOrCreate(
                    [
                        'id' =>  Arr::get($requestQuestion, 'id')
                    ],
                    [
                        'title' => Arr::get($requestQuestion, 'title'),
                        'answer_type' => Arr::get($requestQuestion, 'answer_type'),
                        'number' => $count++,
                        'has_video' => $hasVideo,
                        'video' => $hasVideo ? Arr::get($requestQuestion, 'video') : null,
                        'has_audio' => $hasAudio,
                        'audio' => $hasAudio ? Arr::get($requestQuestion, 'audio') : null,
                        'has_image' => $hasImage,
                    ]
                );

                $this->uploadImageService->upload($question, 'image', Arr::get($requestQuestion, 'image'));

                if (! $question->wasRecentlyCreated) {
                    $question->alternatives()->delete();
                }

                if ($question->answer_type === AnswerTypeEnum::fechada()->value) {
                    $this->createAlternatives($question, Arr::get($requestQuestion, 'alternatives'));
                }
            }
        }
    }

     /**
     * @param Question $question
     * @param array $alternatives
     * @return void
     */
    private function createAlternatives(Question $question, array $alternatives = []): void
    {
        $count = 1;

        foreach ($alternatives as $alternative) {
            if ($name = Arr::get($alternative, 'name')) {
                $question->alternatives()->create([
                    'name' => $name,
                    'number' => $count++,
                    'is_correct' => Arr::get($alternative, 'is_correct', false)
                ]);
            }
        }
    }
}
