<?php

namespace App\Exports;

use App\Models\Users\User;
use App\Support\Payment\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DelegatesExport implements FromCollection
{
    public function headings()
    {
        return trans("delegates.excel-header");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collection()
    {
        $results = [$this->headings()];

        /** @var Transaction[] $transactions */
        $users = User::filter()
            ->where('type',User::Delegate)
            ->oldest()
            ->get();

        $data = [];
        foreach ($users as $key => $user) {
            $data[$key][] = [
                $user->id,
                $user->name,
                optional($user->city)->name ?: '---',
                $user->mobile,
                optional($user->delegate)->national_id ?? '---',
                optional($user->delegate)->vehicle_type ?? '---',
                optional($user->delegate)->vehicle_number ?? '---',
                optional($user->delegate)->vehicle_model ?? '---',
                abs($user->rate) ?? '---',
                $user->cancellation_attempts,
                abs($user->getBalance()) ?? 0,
                $user->created_at,
            ];
            $results[] = $data[$key];
        }

        return new Collection($results);
    }
}
