<?php

namespace App\Services\Admin;

use App\Models\Student;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class StudentService
{
    /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Student[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
         /** @var Student|Builder */
        $query = Student::query()->select(['students.*']);

        if ($name = Arr::get($filters, 'name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($email = Arr::get($filters, 'email')) {
            $query->where('email', $email);
        }

        if ($cpf = Arr::get($filters, 'cpf')) {
            $query->where('cpf', $cpf);
        }

        if ($phone = Arr::get($filters, 'phone')) {
            $query->where('phone', $phone);
        }

        $active = Arr::get($filters, 'active');
        if (isset($active)) {
            $query->where('active', $active ? true : false);
        } else {
            $query->where('active', true);
        }

        if (in_array($orderBy, (new Student)->getFillable())) {
            $query->orderBy("students.{$orderBy}", $sort);
        }

        return $rowsPerPage ? $query->paginate($rowsPerPage) : $query->get();
    }

    /**
     * @param array $requestData
     * @return Student
     */
    public function store(array $requestData = []): Student
    {
        $student = Student::create(array_merge($this->transformData($requestData), [
            'password' => Str::random(20)
        ]));

        $this->handleAddress($student, Arr::get($requestData, 'address', []));

        return $student;
    }

    /**
     * @param Student $student
     * @param array $requestData
     * @return Student
     */
    public function update(Student $student, array $requestData = []): Student
    {
        $student->update($this->transformData($requestData));

        $this->handleAddress($student, Arr::get($requestData, 'address', []));

        return $student;
    }

    /**
     * @param Student $student
     * @return boolean|null
     */
    public function delete(Student $student): ?bool
    {
        $student->groups()->detach();
        $student->meetings()->detach();
        $student->liveEvents()->detach();
        $student->jobVacancies()->detach();
        $student->address()->delete();

        return $student->delete();
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($student = Student::find($id)) {
                $this->delete($student);
            }
        }
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        return [
            'name' => Arr::get($requestData, 'name'),
            'email' => Arr::get($requestData, 'email'),
            'active' => Arr::get($requestData, 'active'),
            'inactivated_at' => Arr::get($requestData, 'inactivated_at'),
            'cpf' => Arr::get($requestData, 'cpf'),
            'phone' => Arr::get($requestData, 'phone'),
            'profile_image' => Arr::get($requestData, 'profile_image'),
            'customer_cpf' => Arr::get($requestData, 'customer_cpf'),
            'customer_phone' => Arr::get($requestData, 'customer_phone'),
            'equal_data' => Arr::get($requestData, 'equal_data'),
        ];
    }

    /**
     * @param Student $student
     * @param array $requestDataAddress
     * @return void
     */
    private function handleAddress(Student $student, array $requestDataAddress = []): void
    {
        if (Arr::whereNotNull($requestDataAddress)) {
            $student->address()->updateOrCreate([], [
                'cep'  => Arr::get($requestDataAddress, 'cep'),
                'street' => Arr::get($requestDataAddress, 'street'),
                'number' => Arr::get($requestDataAddress, 'number'),
                'district' => Arr::get($requestDataAddress, 'district'),
                'complement' => Arr::get($requestDataAddress, 'complement'),
                'city' => Arr::get($requestDataAddress, 'city'),
                'state' => Arr::get($requestDataAddress, 'state'),
                'country' => Arr::get($requestDataAddress, 'country'),
            ]);
        } else {
            $student->address()->delete();
        }
    }

    /**
     * @param Student $student
     * @return Student
     */
    public function activate(Student $student): Student
    {
        $student->update(['active' => true]);

        return $student;
    }

    /**
     * @param Student $student
     * @return Student
     */
    public function inactivate(Student $student): Student
    {
        $student->update(['active' => false]);

        return $student;
    }

     /**
     * @param integer $month
     * @param integer|null|null $year
     * @return float
     */
    public function createdByMonthCount(int $month, int|null $year = null): float
    {
        $date = Carbon::create($year ?? now()->format('Y'), $month, 1);

        return Student::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->count();
    }
}
