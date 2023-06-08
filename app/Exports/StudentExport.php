<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class StudentExport implements FromCollection, Responsable, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * @var string
     */
    private string $fileName;

    /**
     * @var string
     */
    private string $writerType = Excel::XLSX;

    /**
     * @var Collection
     */
    private Collection $students;

    /**
     * @param Collection|Student[] $student
     */
    public function __construct(Collection $students)
    {
        $this->fileName = "aluno_". date('dmYHis'). ".xlsx";
        $this->students = $students;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->students;
    }

    /**
     * @param Student $student
     * @var array
     */
    public function map($student): array
    {
        return [
            'name' => $student->name,
            'email' => $student->email,
            'cpf' => $student->cpf,
            'active' => $student->active ? 'Ativo' : 'Inativo',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Nome",
            "E-mail",
            "CPF",
            "Status",
        ];
    }
}
