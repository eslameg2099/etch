<?php

namespace App\Exports;

use App\Support\Payment\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class WithdrawalTransactionsExport implements FromCollection
{
    public function headings()
    {
        return [
            '#',
            'User Name',
            'Date',
            'Amount',
            'Status',
            'Account Name',
            'Bank Name',
            'Account Number',
            'Iban Number',
            'Notes',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collection()
    {
        $results = [$this->headings()];

        /** @var Transaction[] $transactions */
        $transactions = Transaction::filter()
            ->parentsOnly()
            ->oldest()
            ->get();

        $data = [];
        foreach ($transactions as $key => $transaction) {
            $data[$key][] = [
                $transaction->id,
                optional($transaction->user)->name ?: '---',
                $transaction->date,
                abs($transaction->amount),
                trans('wallets.statuses.'.$transaction->status),
                $transaction->account_name,
                $transaction->bank_name,
                $transaction->account_number,
                $transaction->iban_number,
                $transaction->notes,
            ];
            $results[] = $data[$key];
        }

        return new Collection($results);
    }
}
