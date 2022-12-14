<?php

use App\Models\Orders\Order;

return [
    'plural' => 'الطلبات',
    'singular' => 'الطلب',
    'trashed' => 'الطلبات المحذوفة',
    'empty' => 'لا يوجد مندوبين',
    'select' => 'اختر الطلب',
    'perPage' => 'عدد النتائج في الصفحة',
    'purchase' => 'طلبات الشراء',
    'delivery' => 'طلبات التوصيل',
    'actions' => [
        'list' => 'كل الطلبات',
        'show' => 'عرض',
        'delete' => 'حذف الطلب',
        'restore' => 'استعادة',
        'save' => 'حفظ',
        'filter' => 'بحث',
        'edit' => 'تعديل'
    ],
    'messages' => [
        'created' => 'تم إضافة الطلب بنجاح .',
        'updated' => 'تم تعديل الطلب بنجاح .',
        'deleted' => 'تم حذف الطلب بنجاح .',
        'restored' => 'تم استعادة الطلب بنجاح .',
        'cannot_edit' => 'لا يمكن تعديل هذا الطلب'
    ],
    'admin_change_status' => [
        Order::Delivered => 'تم التوصيل',
        Order::CanceledBySystem => 'تم الغاء من قبل النظام',
    ],
    'attributes' => [
        'user_id' => 'المستخدم',
        'delegate_id' => 'المندوب',
        'receiving_address_id' => 'عنوان الاستلام',
        'delivery_address_id' => 'عنوان التوصيل',
        'type' => 'نوع الطلب',
        'is_schedule' => 'مؤجل',
        'schedule_date' => 'تاريخ التأجيل',
        'shop_id' => 'المتجر',
        'status' => 'الحالة',
        'reference_number' => 'رقم الطلب',
        'order_description' => 'تفاصيل الطلب',
        'created_at' => 'تاريخ الاضافة',
        'start_at' => 'تاريخ البدأ',
        'closed_at' => 'تاريخ الانتهاء',
        'rate' => 'التقييم',
        'payment_type' => 'طريقة الدفع',
        'payment' => [
            'sub_total' => 'الاجمالي الفرعي',
            'discount' => 'قيمة الخصم',
            'total' => 'الاجمالي',
            'status' => 'الحالة',
            'coupon' => 'الكوبون',
            'items' => 'المشتريات',
            'item_name' => 'اسم السلعة',
            'item_cost' => 'التكلفة',
            'item_type' => 'النوع',
        ],
    ],
    'payment_types' => [
        Order::PAYMENT_ON_DELIVERY => 'دفع عند الاستلام',
        Order::PAYMENT_FROM_WALLET => 'دفع من المحفظة',
        Order::ONLINE_PAYMENT => 'دفع مباشر',
    ],
    'placeholders' => [
        'status' => 'اختر الحالة',
    ],
    'types' => [
        Order::Purchase => 'طلب شراء',
        Order::Delivery => 'طلب توصيل',
    ],
    'statuses' => [
        Order::WaitingForOffers => 'بانتظار العروض',
        Order::WaitingForAcceptOffer => 'بانتظار الموافقه علي العروض',
        Order::WaitingForPayment => '{1} بانتظار تأكيد الفاتورة | {2} بانتظار دفع الفاتورة',
        Order::ChangeDelegate => 'تغيير المندوب',
        Order::PaymentDone => '{1} تم تأكيد الفاتورة | {2} تم دفع الفاتورة',
        Order::UnderReview => 'جاري المراجعة',
        Order::UnderDelivery => 'جاري التوصيل',
        Order::Delivered => 'تم التوصيل',
        Order::CanceledByDelegate => 'تم الغاء من قبل المندوب',
        Order::CanceledByUser => 'تم الغاء من قبل المستخدم',
        Order::CanceledBySystem => 'تم الغاء من قبل النظام',
        Order::CanceledAutomatic => 'تم الغاء تلقائيا',
        Order::RefusedByAdmin => 'تم الرفض من قبل الادارة',
        Order::Schedule => 'مؤجل',
        Order::WaitingForAddPayment => 'بانتظار انشاء الفاتورة',
    ],
    'filter' => [
        'statuses' => [
            Order::WaitingForOffers => 'بانتظار العروض',
            Order::WaitingForAcceptOffer => 'بانتظار الموافقه علي العروض',
            Order::WaitingForPayment => 'بانتظار دفع الفاتورة',
            Order::ChangeDelegate => 'تغيير المندوب',
            Order::PaymentDone => 'تم دفع الفاتورة',
            Order::UnderReview => 'جاري المراجعة',
            Order::UnderDelivery => 'جاري التوصيل',
            Order::Delivered => 'تم التوصيل',
            Order::CanceledByDelegate => 'تم الغاء من قبل المندوب',
            Order::CanceledByUser => 'تم الغاء من قبل المستخدم',
            Order::CanceledBySystem => 'تم الغاء من قبل النظام',
            Order::CanceledAutomatic => 'تم الغاء تلقائيا',
            Order::RefusedByAdmin => 'تم الرفض من قبل الادارة',
            Order::Schedule => 'مؤجل',
            Order::WaitingForAddPayment => 'بانتظار انشاء الفاتورة',
        ],
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف هذا الطلب ?',
            'confirm' => 'حذف',
            'cancel' => 'إلغاء',
        ],
    ],
];
