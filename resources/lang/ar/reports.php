<?php

return [
    'plural' => 'البلاغات',
    'singular' => 'البلاغ',
    'trashed' => 'البلاغات المحذوفة',
    'empty' => 'لا توجد بلاغات',
    'select' => 'اختر البلاغ',
    'perPage' => 'عدد النتائج في الصفحة',
    'actions' => [
        'list' => 'كل البلاغات',
        'show' => 'عرض',
        'edit' => 'تعديل  البلاغ',
        'delete' => 'حذف البلاغ',
        'save' => 'حفظ',
        'restore' => 'استعادة',
        'filter' => 'بحث',
    ],
    'messages' => [
        'created' => 'تم إضافة البلاغ بنجاح .',
        'updated' => 'تم تعديل البلاغ بنجاح .',
        'deleted' => 'تم حذف البلاغ بنجاح .',
        'restored' => 'تم استعادة البلاغ بنجاح .',
    ],
    'attributes' => [
        'user_id' => 'المستخدم',
        'delegate_id' => 'المندوب',
        'order_id' => 'الطلب',
        'status' => 'الحالة',
        'message' => 'البلاغ',
        'created_at' => 'تاريخ الاضافة',
    ],
    'statuses' => [
        \App\Models\Report::NEW_REPORT => 'شكوى جديدة',
        \App\Models\Report::IN_PROGRESS => 'جاري العمل عليها',
        \App\Models\Report::DONE => 'تم حل المشكلة',
        \App\Models\Report::CLOSED => 'مغلقة',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف هذا البلاغ ?',
            'confirm' => 'حذف',
            'cancel' => 'إلغاء',
        ],
        'status' => [
            'title' => 'تغيير حالة البلاغ',
        ],
    ],
];
