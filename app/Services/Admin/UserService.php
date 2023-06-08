<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class UserService
{
    /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return User[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
         /** @var User|Builder */
        $query = User::query()->select(['users.*']);

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

        if ($orderBy === 'roles_name') {
            $query->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->orderBy('roles.name', $sort);
        } else if (in_array($orderBy, (new User)->getFillable())) {
            $query->orderBy("users.{$orderBy}", $sort);
        }

        return $query->paginate($rowsPerPage);
    }

    /**
     * @param array $requestData
     * @return User
     */
    public function store(array $requestData = []): User
    {
        $user = User::create(array_merge($this->transformData($requestData), [
            'password' => Str::random(20)
        ]));

        $user->roles()->sync(Arr::get($requestData, 'role_ids'));

        $this->handleAddress($user, Arr::get($requestData, 'address', []));

        return $user;
    }

    /**
     * @param User $user
     * @param array $requestData
     * @return User
     */
    public function update(User $user, array $requestData = []): User
    {
        $user->update($this->transformData($requestData));

        $user->roles()->sync(Arr::get($requestData, 'role_ids'));

        $this->handleAddress($user, Arr::get($requestData, 'address', []));

        return $user;
    }

    /**
     * @param User $user
     * @return boolean|null
     */
    public function delete(User $user): ?bool
    {
        /** @var User */
        $authUser = auth('admin')->user();

        if ($user->id === $authUser->id) {
            throw new \Exception("Não é permitido apagar o usuário logado.", 1);
        }

        $user->roles()->detach();

        return $user->delete();
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($user = User::find($id)) {
                $this->delete($user);
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
            'is_system_user' => Arr::get($requestData, 'is_system_user', false),
            'is_teacher' => Arr::get($requestData, 'is_teacher', false),
            'is_partner' => Arr::get($requestData, 'is_partner', false),
            'whereby_link' => Arr::get($requestData, 'whereby_link'),
        ];
    }

    /**
     * @param User $user
     * @param array $requestDataAddress
     * @return void
     */
    private function handleAddress(User $user, array $requestDataAddress = []): void
    {
        if (Arr::whereNotNull($requestDataAddress)) {
            $user->address()->updateOrCreate([], [
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
            $user->address()->delete();
        }
    }

    /**
     * @param User $user
     * @return User
     */
    public function activate(User $user): User
    {
        $user->update(['active' => true]);

        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function inactivate(User $user): User
    {
        $user->update(['active' => false]);

        return $user;
    }
}
