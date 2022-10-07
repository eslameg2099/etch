<?php

return [
    'delegate' => [
        'approved' => 'تمت تفعيل عضويتك من قبل الادارة',
        'declined' => 'تمت الغاء تفعيل عضويتك من قبل الادارة',
        'add_offer' => 'قام :delegate باضافة عرض على طلبك :order',
        'withdrawal' => 'لقد تم انسحاب المندوب :delegate من طلبك :order يرجى اختيار مندوب اخر',
        'invoice_added' => 'لقد تم انشاء فاتورة الطلب :order',
        'under_delivery' => 'طلبك :order قيد التوصيل',
        'delivered' => 'تم انهاء الطلب :order',
    ],
    'user' => [
        'new_order' => 'لديك طلب جديد :order',
        'new_message' => 'قام :user بارسال رسالة جديدة على طلب :order',
        'accept_offer' => 'قام :user بالموافقة على عرضك على طلب :order',
        'cancel_order' => 'قام :user بإلغاء طلب :order',
        'pay_order' => 'قام :user بدفع فاتورة الطلب :order',
        'change_delegate' => 'قام :user بإستبعادك من طلب :order',
        'schedule' => 'طلبت اتمام طلب في الوقت الحالي هل تريد اتمام الطلب ؟',
        'rate_order' => 'يرجى تقييم الطلب :order',
        'rate_shop' => 'يرجى تقييم المتجر :shop',
        'wallet-recharge' => 'تم شحن :amount الى محفظتك',
        'wallet-discount' => 'تم خصم :amount من محفظتك',
        'cancellation-attempts-0' => 'تم إيقاف عضويتك لتجاوز عدد مرات إلغاء الطلب برجاء التواصل مع الإدارة بهذا الشأن.',
        'cancellation-attempts-add' => 'تم تفعيل حسابك مرة أخرى بإمكانك استخدام التطبيق الآن.',

    ],
    'messages' => [
      'active' => 'تم تغيير حالة الإعلان بنجاح.',
        'admin_notification' => 'إشعار من الإدارة.',
    ],
    'dialogs' => [
        'enable' => [
            'title' => "إظهار الإعلان.",
            'body' => "هل انت متأكد من انك تريد إظهار هذا الإعلان ؟ .. تأكد من انه آخر إعلان او أن باقي الإعلانات مخفية.",
            'cancel' => 'إلغاء',
            'confirm' => 'تأكيد',
        ],
        'disable' => [
            'title' => "إظهار الإعلان.",
            'body' => "هل انت متأكد من انك تريد إظهار هذا الإعلان ؟",
            'cancel' => 'إلغاء',
            'confirm' => 'تأكيد',
        ]
    ],
    'actions' => [
      'enable' => "هل انت متأكد من انك تريد إظهار هذا الإعلان ؟ .. تأكد من انه آخر إعلان او أن باقي الإعلانات مخفية.",
      'disable' => "هل انت متأكد من انك تريد إخفاء هذا الإعلان ؟"
    ],
    'attributes' => [
        'id' => 'رقم الإعلان',
        'label' => 'العنوان',
        'body' => 'الرسالة',
        'image' => 'الصورة',
        'user_type' => 'نوع المستخدم',
        'active' => 'التفعيل',
        'created_at' => 'تاريخ الإنشاء',
    ],
    'user_type' => [
        \App\Models\AdminNotification::TYPE_USER => 'مستخدمين',
        \App\Models\AdminNotification::TYPE_DELEGATE => 'مناديب',
        \App\Models\AdminNotification::TYPE_ALL => 'الكل',
    ]
];
