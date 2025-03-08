<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | บรรทัดภาษาต่อไปนี้มีข้อความข้อผิดพลาดเริ่มต้นที่ใช้โดยคลาส validator
    | บางกฎมีหลายรูปแบบ เช่น ข้อความสำหรับขนาด (size) คุณสามารถปรับเปลี่ยนข้อความเหล่านี้ได้ตามต้องการ
    |
    */

    'accepted' => 'ฟิลด์ :attribute ต้องได้รับการยอมรับ',
    'active_url' => 'ฟิลด์ :attribute ไม่ใช่ URL ที่ถูกต้อง',
    'after' => 'ฟิลด์ :attribute ต้องเป็นวันที่หลังจาก :date',
    'after_or_equal' => 'ฟิลด์ :attribute ต้องเป็นวันที่หลังหรือเท่ากับ :date',
    'alpha' => 'ฟิลด์ :attribute ต้องประกอบด้วยตัวอักษรเท่านั้น',
    'alpha_dash' => 'ฟิลด์ :attribute ต้องประกอบด้วยตัวอักษร, ตัวเลข, ขีดกลาง และขีดล่างเท่านั้น',
    'alpha_num' => 'ฟิลด์ :attribute ต้องประกอบด้วยตัวอักษรและตัวเลขเท่านั้น',
    'array' => 'ฟิลด์ :attribute ต้องเป็นอาเรย์',
    'before' => 'ฟิลด์ :attribute ต้องเป็นวันที่ก่อน :date',
    'before_or_equal' => 'ฟิลด์ :attribute ต้องเป็นวันที่ก่อนหรือเท่ากับ :date',
    'between' => [
        'numeric' => 'ฟิลด์ :attribute ต้องมีค่าอยู่ระหว่าง :min และ :max',
        'file' => 'ฟิลด์ :attribute ต้องมีขนาดไฟล์อยู่ระหว่าง :min และ :max กิโลไบต์',
        'string' => 'ฟิลด์ :attribute ต้องมีความยาวระหว่าง :min และ :max ตัวอักษร',
        'array' => 'ฟิลด์ :attribute ต้องมีระหว่าง :min และ :max รายการ',
    ],
    'boolean' => 'ฟิลด์ :attribute ต้องเป็นค่าจริงหรือเท็จ',
    'confirmed' => 'ฟิลด์ :attribute ยืนยันไม่ตรงกัน',
    'date' => 'ฟิลด์ :attribute ไม่ใช่วันที่ที่ถูกต้อง',
    'date_equals' => 'ฟิลด์ :attribute ต้องเป็นวันที่เท่ากับ :date',
    'date_format' => 'ฟิลด์ :attribute ไม่ตรงกับรูปแบบ :format',
    'different' => 'ฟิลด์ :attribute และ :other ต้องแตกต่างกัน',
    'digits' => 'ฟิลด์ :attribute ต้องมี :digits หลัก',
    'digits_between' => 'ฟิลด์ :attribute ต้องมีระหว่าง :min และ :max หลัก',
    'dimensions' => 'ฟิลด์ :attribute มีขนาดรูปภาพที่ไม่ถูกต้อง',
    'distinct' => 'ฟิลด์ :attribute มีค่าที่ซ้ำกัน',
    'email' => 'ฟิลด์ :attribute ต้องเป็นอีเมลที่ถูกต้อง',
    'ends_with' => 'ฟิลด์ :attribute ต้องลงท้ายด้วยหนึ่งในค่าต่อไปนี้: :values',
    'exists' => 'ฟิลด์ :attribute ที่เลือกไม่ถูกต้อง',
    'file' => 'ฟิลด์ :attribute ต้องเป็นไฟล์',
    'filled' => 'ฟิลด์ :attribute ต้องมีค่า',
    'gt' => [
        'numeric' => 'ฟิลด์ :attribute ต้องมากกว่า :value',
        'file' => 'ฟิลด์ :attribute ต้องมีขนาดมากกว่า :value กิโลไบต์',
        'string' => 'ฟิลด์ :attribute ต้องมีความยาวมากกว่า :value ตัวอักษร',
        'array' => 'ฟิลด์ :attribute ต้องมีมากกว่า :value รายการ',
    ],
    'gte' => [
        'numeric' => 'ฟิลด์ :attribute ต้องมากกว่าหรือเท่ากับ :value',
        'file' => 'ฟิลด์ :attribute ต้องมีขนาดมากกว่าหรือเท่ากับ :value กิโลไบต์',
        'string' => 'ฟิลด์ :attribute ต้องมีความยาวมากกว่าหรือเท่ากับ :value ตัวอักษร',
        'array' => 'ฟิลด์ :attribute ต้องมีอย่างน้อย :value รายการ',
    ],
    'image' => 'ฟิลด์ :attribute ต้องเป็นรูปภาพ',
    'in' => 'ฟิลด์ :attribute ที่เลือกไม่ถูกต้อง',
    'in_array' => 'ฟิลด์ :attribute ไม่อยู่ใน :other',
    'integer' => 'ฟิลด์ :attribute ต้องเป็นจำนวนเต็ม',
    'ip' => 'ฟิลด์ :attribute ต้องเป็นที่อยู่ IP ที่ถูกต้อง',
    'ipv4' => 'ฟิลด์ :attribute ต้องเป็นที่อยู่ IPv4 ที่ถูกต้อง',
    'ipv6' => 'ฟิลด์ :attribute ต้องเป็นที่อยู่ IPv6 ที่ถูกต้อง',
    'json' => 'ฟิลด์ :attribute ต้องเป็น JSON ที่ถูกต้อง',
    'lt' => [
        'numeric' => 'ฟิลด์ :attribute ต้องน้อยกว่า :value',
        'file' => 'ฟิลด์ :attribute ต้องมีขนาดน้อยกว่า :value กิโลไบต์',
        'string' => 'ฟิลด์ :attribute ต้องมีความยาวน้อยกว่า :value ตัวอักษร',
        'array' => 'ฟิลด์ :attribute ต้องมีน้อยกว่า :value รายการ',
    ],
    'lte' => [
        'numeric' => 'ฟิลด์ :attribute ต้องน้อยกว่าหรือเท่ากับ :value',
        'file' => 'ฟิลด์ :attribute ต้องมีขนาดน้อยกว่าหรือเท่ากับ :value กิโลไบต์',
        'string' => 'ฟิลด์ :attribute ต้องมีความยาวน้อยกว่าหรือเท่ากับ :value ตัวอักษร',
        'array' => 'ฟิลด์ :attribute ต้องไม่เกิน :value รายการ',
    ],
    'max' => [
        'numeric' => 'ฟิลด์ :attribute ต้องไม่เกิน :max',
        'file' => 'ฟิลด์ :attribute ต้องไม่เกิน :max กิโลไบต์',
        'string' => 'ฟิลด์ :attribute ต้องไม่เกิน :max ตัวอักษร',
        'array' => 'ฟิลด์ :attribute ต้องไม่เกิน :max รายการ',
    ],
    'mimes' => 'ฟิลด์ :attribute ต้องเป็นไฟล์ประเภท: :values',
    'mimetypes' => 'ฟิลด์ :attribute ต้องเป็นไฟล์ประเภท: :values',
    'min' => [
        'numeric' => 'ฟิลด์ :attribute ต้องมีค่าไม่น้อยกว่า :min',
        'file' => 'ฟิลด์ :attribute ต้องมีขนาดไม่น้อยกว่า :min กิโลไบต์',
        'string' => 'ฟิลด์ :attribute ต้องมีความยาวไม่น้อยกว่า :min ตัวอักษร',
        'array' => 'ฟิลด์ :attribute ต้องมีรายการไม่น้อยกว่า :min รายการ',
    ],
    'multiple_of' => 'ฟิลด์ :attribute ต้องเป็นจำนวนที่คูณของ :value',
    'not_in' => 'ฟิลด์ :attribute ที่เลือกไม่ถูกต้อง',
    'not_regex' => 'ฟิลด์ :attribute รูปแบบไม่ถูกต้อง',
    'numeric' => 'ฟิลด์ :attribute ต้องเป็นตัวเลข',
    'password' => 'รหัสผ่านไม่ถูกต้อง',
    'present' => 'ฟิลด์ :attribute ต้องมีอยู่',
    'regex' => 'ฟิลด์ :attribute รูปแบบไม่ถูกต้อง',
    'required' => 'ฟิลด์ :attribute จำเป็นต้องกรอก',
    'required_if' => 'ฟิลด์ :attribute จำเป็นต้องกรอกเมื่อ :other คือ :value',
    'required_unless' => 'ฟิลด์ :attribute จำเป็นต้องกรอกเว้นแต่ :other อยู่ใน :values',
    'required_with' => 'ฟิลด์ :attribute จำเป็นต้องกรอกเมื่อ :values มีอยู่',
    'required_with_all' => 'ฟิลด์ :attribute จำเป็นต้องกรอกเมื่อ :values ทั้งหมดมีอยู่',
    'required_without' => 'ฟิลด์ :attribute จำเป็นต้องกรอกเมื่อ :values ไม่มีอยู่',
    'required_without_all' => 'ฟิลด์ :attribute จำเป็นต้องกรอกเมื่อไม่มี :values อยู่',
    'prohibited' => 'ฟิลด์ :attribute ถูกห้าม',
    'prohibited_if' => 'ฟิลด์ :attribute ถูกห้ามเมื่อ :other คือ :value',
    'prohibited_unless' => 'ฟิลด์ :attribute ถูกห้ามเว้นแต่ :other อยู่ใน :values',
    'same' => 'ฟิลด์ :attribute และ :other ต้องตรงกัน',
    'size' => [
        'numeric' => 'ฟิลด์ :attribute ต้องมีค่า :size',
        'file' => 'ฟิลด์ :attribute ต้องมีขนาด :size กิโลไบต์',
        'string' => 'ฟิลด์ :attribute ต้องมีความยาว :size ตัวอักษร',
        'array' => 'ฟิลด์ :attribute ต้องมีรายการ :size รายการ',
    ],
    'starts_with' => 'ฟิลด์ :attribute ต้องเริ่มต้นด้วยหนึ่งในค่าต่อไปนี้: :values',
    'string' => 'ฟิลด์ :attribute ต้องเป็นสตริง',
    'timezone' => 'ฟิลด์ :attribute ต้องเป็นเขตเวลาที่ถูกต้อง',
    'unique' => 'ฟิลด์ :attribute นี้ถูกใช้แล้ว',
    'uploaded' => 'ฟิลด์ :attribute ไม่สามารถอัปโหลดได้',
    'url' => 'ฟิลด์ :attribute รูปแบบไม่ถูกต้อง',
    'uuid' => 'ฟิลด์ :attribute ต้องเป็น UUID ที่ถูกต้อง',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | ที่นี่คุณสามารถระบุข้อความ validation แบบกำหนดเองสำหรับแต่ละ attribute
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | บรรทัดภาษาต่อไปนี้จะใช้ในการแทนที่ :attribute ด้วยชื่อที่อ่านง่ายขึ้น
    |
    */

    'attributes' => [],

];
