<?php

namespace App\Services\Admin;

use App\Models\Question;
use App\Models\Quizz;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class QuizzService
{
    /**
     * @var QuestionService
     */
    protected QuestionService $questionService;

    /**
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Quizz[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        /** @var Quizz|Builder */
        $query  = Quizz::query()->select(['quizzes.*']);

        if ($name = Arr::get($filters, 'name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($orderBy === 'content_name') {
            $query->join('contents', 'quizzes.content_id', '=', 'contents.id')->orderBy('contents.name', $sort);
        } else if (in_array($orderBy, (new Quizz)->getFillable())) {
            $query->orderBy("quizzes.{$orderBy}", $sort);
        }

        return $rowsPerPage ? $query->paginate($rowsPerPage) : $query->get();
    }

    /**
     * @param array $requestData
     * @return Quizz
     */
    public function store(array $requestData = []): Quizz
    {
        /** @var Quizz */
        $quizz = Quizz::create($this->transform($requestData));

        $quizz->setLinkableTypeParse(Arr::get($requestData, 'linkable_type', 'content'));

        $this->questionService->createOrUpdateQuestions($quizz, Arr::get($requestData, 'questions', []));

        return $quizz;
    }

   /**
     * @param Quizz $quizz
     * @param array $requestData
     * @return Quizz
     */
    public function update(Quizz $quizz, array $requestData = []): Quizz
    {
        $quizz->update($this->transform($requestData));

        $quizz->setLinkableTypeParse(Arr::get($requestData, 'linkable_type', 'content'));

        $this->questionService->createOrUpdateQuestions($quizz, Arr::get($requestData, 'questions', []));

        return $quizz;
    }

    /**
     * @param Quizz $quizz
     * @return boolean|null
     */
    public function delete(Quizz $quizz): ?bool
    {
        $quizz->questions()->each(fn(Question $question) => $this->questionService->delete($question));

        return $quizz->delete();
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($quizz = Quizz::find($id)) {
                $this->delete($quizz);
            }
        }
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transform(array $requestData): array
    {
        return [
            'name' => Arr::get($requestData, 'name'),
            'description' => Arr::get($requestData, 'description'),
            'linkable_id' => Arr::get($requestData, 'linkable_id'),
            'content_id' => Arr::get($requestData, 'content_id'),
        ];
    }
}
