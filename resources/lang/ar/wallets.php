<?php

use App\Support\Payment\Models\Transaction;

return [
    'plural' => 'المحافظ',
    'singular' => 'المحفظة',
    'withdrawal' => 'طلبات السحب',
    'delegates' => 'محافظ المناديب',
    'users' => 'محافظ المستخدمين',
    'system' => 'محفظة النظام',
    'balance' => 'الرصيد',
    'total' => 'الاجمالي',
    'details' => 'تفاصيل المعاملة',
    'transactions' => 'المعاملات',
    'empty' => 'لا يوجد معاملات',
    'perPage' => 'عدد النتائج في الصفحة',
    'actions' => [
        'filter' => 'بحث',
        'all' => 'عرض الكل',
        'show' => 'عرض المحفظة',
        'recharge' => 'شحن او خصم رصيد',
        'recharge-submit' => 'تنفيذ',
    ],
    'messages' => [
        'recharge' => 'تم إضافة الرصيد بنجاح .',
        'discount' => 'تم خصم الرصيد بنجاح .',
    ],
    'attributes' => [
        'user_id' => 'المستخدم',
        'actor_id' => 'بواسطة',
        'checkout_id' => 'Hyper Pay Checkout ID',
        'amount' => 'المبلغ',
        'status' => 'الحالة',
        'type' => 'نوع المعاملة',
        'notes' => 'ملاحظات',
        'date' => 'التاريخ',
        'order_id' => 'الطلب',
        'account_name' => 'اسم الحساب',
        'bank_name' => 'اسم البنك',
        'account_number' => 'رقم الحساب',
        'iban_number' => 'رقم الايبان',
        'created_at' => 'تاريخ الاضافة',
        'user_type' => 'نوع المستخدم',
    ],
    'user_types' => [
        'users' => 'مستخدم',
        'delegates' => 'مندوب',
    ],
    'placeholders' => [
        'user_type' => 'الكل',
    ],
    'types' => [
        Transaction::PURCHASE_AMOUNT_TYPE => 'تكلفة الشراء',
        Transaction::DELEGATE_PROFITS_TYPE => 'ارباح المندوب',
        Transaction::APP_PROFITS_TYPE => 'قيمة التوصيل + قيمة الضريبة',
        Transaction::RECHARGE_TYPE => 'شحن رصيد',
        Transaction::WITHDRAWAL_TYPE => 'سحب من الرصيد',
        Transaction::TAX_VALUE_TYPE => 'القيمة الضريبية',
        Transaction::ORDER_TOTAL_AMOUNT_TYPE => 'تكلفة الطلب :order',
        Transaction::BALANCE_RECHARGE => 'شحن رصيد',
    ],
    'statuses' => [
        'all' => 'الكل',
        Transaction::BALANCE_STATUS => 'عملية ناجحة',
        Transaction::PENDING_STATUS => 'قيد المراجعة',
        Transaction::HOLED_STATUS => 'رصيد معلق',
        Transaction::REJECTED_STATUS => 'عملية مرفوضة',
        Transaction::WITHDRAWAL_REQUEST_STATUS => 'طلب سحب',
        Transaction::WITHDRAWAL_STATUS => 'تم السحب',
    ],
];
