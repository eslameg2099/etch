<?php

namespace App\Exports;

use App\Models\Users\User;
use App\Support\Payment\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    public function headings()
    {
        return trans("users.excel-header");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collection()
    {
        $results = [$this->headings()];

        /** @var Transaction[] $transactions */
        $users = User::filter()
            ->where('type',User::User)
            ->oldest()
            ->get();

        $data = [];
        foreach ($users as $key => $user) {
            $data[$key][] = [
                $user->id,
                $user->name,
                optional($user->city)->name ?: '---',
                $user->mobile,
                $user->email ?? '---',
                $user->rate ?? '---',
                $user->cancellation_attempts,
                abs($user->getBalance()) ?? 0,
                $user->created_at

            ];
            $results[] = $data[$key];
        }

        return new Collection($results);
    }
}
