<?php

namespace App\Services\Student;

use App\Models\Student;
use App\Services\Admin\UploadImageService;
use Illuminate\Support\Arr;

class StudentService
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
     * @param Student $student
     * @param array $requestData
     * @return Student
     */
    public function updatePhoto(Student $student, array $requestData = []): Student
    {
        $this->uploadImageService->upload($student, 'profile_image', Arr::get($requestData, 'profile_image'));

        return $student;
    }

}
