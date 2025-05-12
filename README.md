# online store mobiles php
 created website online store mobiles used php 
السلام عليكم ورحمة الله وبركاته

اولاً
القاعدة باستخدام mysql 
يجب انشاء ما يلي : 
table cart     => id	user_id	product_id	quantity	created_at
table contacts => id	name   	email	subject 	message 	created_at	
table offers   => id    offer_name      discount    product_image   offer_description       created_at
table orders   => id    user_id  total   created_at   
table products => id    name    description     price   image   created_at      quantity
table users    => id    username    email   pass    profile_pic         last_login      role

ثانياَ
تم الإعماد على ال  في التصميم 
Bootstrap

ثالثاً 
يجب معالجة عملية الدفع عن طريق 
Api 

رابعا
يوجد خطأ لم يحل معي وهو عرض صورة العرض
و يوجد خطأ في صفحات الأدمن وهو أول كم سطر معلق بحيث يمكنه المستخدم العادي الدخول الى صفحات الأدمان ازا كتب المسار الصحيح للصفحة 
فكرت في الحل ان اعمل عمود اسمه رول يعني الدور و اضيف فقط للأدمن اسم الأدمن بحيث 
أقم باستخدام هذا العمود للتحق من ان هذا هو حساب الأدمن فقط و لكن 
بعد ما كتبت الكود لم يعمل معي فقمت بتعليقه 


اللهم صل وسلم وبارك على سيدنا محمد و على آله وصحبه وسلم 