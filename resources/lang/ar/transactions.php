<?php

use App\Support\Payment\Models\Transaction;

return [
    'recharge' => 'شحن رصيد المحفظة',
    'withdrawal' => 'سحب من رصيد المحفظة',
    'order' => [
        Transaction::PURCHASE_AMOUNT_TYPE => 'استرداد قيمة مشتريات الطلب رقم :order',
        Transaction::DELEGATE_PROFITS_TYPE => 'استرداد قيمة توصيل الطلب رقم :order',
        Transaction::ORDER_TOTAL_AMOUNT_TYPE => 'قيمة الطلب رقم :order',
        Transaction::APP_PROFITS_TYPE => 'عمولة التطبيق من الطلب رقم :order',
    ],
    'admin-recharge' => 'شحن رصيد المحفظة من قبل الادرارة',
    'admin-withdrawal' => 'خصم من رصيد المحفظة من قبل الادرارة',
    'types' => [
        'deposit' => 'ايداع',
        'withdrawal' => 'سحب',
    ],
    'messages' => [
        'withdrawal' => 'سيتم إجراء سحب الرصيد خلال 3 أيام عمل و سيتم خصم المصاريف الإدارية لعملية السحب',
    ],
    'errors' => [
        'withdrawal' => [
            'not-enough' => 'رصيدك الحالي لا يكفي لاتمام عملية السحب',
        ],
        'cash' => [
            'not-enough' => 'رصيدك الحالي لا يكفي لتمكين خاصية الاشتراك بطلبات الكاش',
        ],
        'order' => [
            'not-enough' => 'رصيدك الحالي لا يكفي لدفع قيمة الطلب',
        ],
    ],
];
