<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 验证语言行
    |--------------------------------------------------------------------------
    |
    | 以下语言行包含了验证器类使用的默认错误信息。一些规则有多个版本，
    | 例如大小规则。你可以在这里随意调整每一条信息。
    |
    */

    'accepted' => '必须接受 :attribute。',
    'active_url' => ':attribute 不是一个有效的 URL。',
    'after' => ':attribute 必须是 :date 之后的日期。',
    'after_or_equal' => ':attribute 必须是 :date 之后或相等的日期。',
    'alpha' => ':attribute 只能包含字母。',
    'alpha_dash' => ':attribute 只能包含字母、数字、破折号和下划线。',
    'alpha_num' => ':attribute 只能包含字母和数字。',
    'array' => ':attribute 必须是一个数组。',
    'before' => ':attribute 必须是 :date 之前的日期。',
    'before_or_equal' => ':attribute 必须是 :date 之前或相等的日期。',
    'between' => [
        'numeric' => ':attribute 必须在 :min 和 :max 之间。',
        'file' => ':attribute 必须在 :min 和 :max 千字节之间。',
        'string' => ':attribute 必须在 :min 和 :max 字符之间。',
        'array' => ':attribute 必须有 :min 和 :max 项。',
    ],
    'boolean' => ':attribute 字段必须为 true 或 false。',
    'confirmed' => ':attribute 确认值不匹配。',
    'date' => ':attribute 不是一个有效的日期。',
    'date_equals' => ':attribute 必须是 :date 相等的日期。',
    'date_format' => ':attribute 不匹配格式 :format。',
    'different' => ':attribute 和 :other 必须不同。',
    'digits' => ':attribute 必须是 :digits 位数字。',
    'digits_between' => ':attribute 必须是 :min 和 :max 位数字之间。',
    'dimensions' => ':attribute 具有无效的图像尺寸。',
    'distinct' => ':attribute 字段有重复的值。',
    'email' => ':attribute 必须是一个有效的电子邮件地址。',
    'ends_with' => ':attribute 必须以以下之一结尾：:values。',
    'exists' => '选择的 :attribute 无效。',
    'file' => ':attribute 必须是一个文件。',
    'filled' => ':attribute 字段必须有一个值。',
    'gt' => [
        'numeric' => ':attribute 必须大于 :value。',
        'file' => ':attribute 必须大于 :value 千字节。',
        'string' => ':attribute 必须大于 :value 字符。',
        'array' => ':attribute 必须有多于 :value 项。',
    ],
    'gte' => [
        'numeric' => ':attribute 必须大于或等于 :value。',
        'file' => ':attribute 必须大于或等于 :value 千字节。',
        'string' => ':attribute 必须大于或等于 :value 字符。',
        'array' => ':attribute 必须有 :value 项或更多。',
    ],
    'image' => ':attribute 必须是一个图像。',
    'in' => '选择的 :attribute 无效。',
    'in_array' => ':attribute 字段不存在于 :other 中。',
    'integer' => ':attribute 必须是一个整数。',
    'ip' => ':attribute 必须是一个有效的 IP 地址。',
    'ipv4' => ':attribute 必须是一个有效的 IPv4 地址。',
    'ipv6' => ':attribute 必须是一个有效的 IPv6 地址。',
    'json' => ':attribute 必须是一个有效的 JSON 字符串。',
    'lt' => [
        'numeric' => ':attribute 必须小于 :value。',
        'file' => ':attribute 必须小于 :value 千字节。',
        'string' => ':attribute 必须小于 :value 字符。',
        'array' => ':attribute 必须有少于 :value 项。',
    ],
    'lte' => [
        'numeric' => ':attribute 必须小于或等于 :value。',
        'file' => ':attribute 必须小于或等于 :value 千字节。',
        'string' => ':attribute 必须小于或等于 :value 字符。',
        'array' => ':attribute 必须不超过 :value 项。',
    ],
    'max' => [
        'numeric' => ':attribute 不能大于 :max。',
        'file' => ':attribute 不能大于 :max 千字节。',
        'string' => ':attribute 不能大于 :max 字符。',
        'array' => ':attribute 不能有超过 :max 项。',
    ],
    'mimes' => ':attribute 必须是以下类型的文件：:values。',
    'mimetypes' => ':attribute 必须是以下类型的文件：:values。',
    'min' => [
        'numeric' => ':attribute 必须至少是 :min。',
        'file' => ':attribute 必须至少是 :min 千字节。',
        'string' => ':attribute 必须至少是 :min 字符。',
        'array' => ':attribute 必须至少有 :min 项。',
    ],
    'multiple_of' => ':attribute 必须是 :value 的倍数。',
    'not_in' => '选择的 :attribute 无效。',
    'not_regex' => ':attribute 格式无效。',
    'numeric' => ':attribute 必须是一个数字。',
    'password' => '密码不正确。',
    'present' => ':attribute 字段必须存在。',
    'regex' => ':attribute 格式无效。',
    'required' => ':attribute 字段是必填的。',
    'required_if' => '当 :other 是 :value 时，:attribute 字段是必填的。',
    'required_unless' => '除非 :other 在 :values 中，否则 :attribute 字段是必填的。',
    'required_with' => '当 :values 存在时，:attribute 字段是必填的。',
    'required_with_all' => '当 :values 都存在时，:attribute 字段是必填的。',
    'required_without' => '当 :values 不存在时，:attribute 字段是必填的。',
    'required_without_all' => '当 :values 都不存在时，:attribute 字段是必填的。',
    'prohibited' => ':attribute 字段是禁止的。',
    'prohibited_if' => '当 :other 是 :value 时，:attribute 字段是禁止的。',
    'prohibited_unless' => '除非 :other 在 :values 中，否则 :attribute 字段是禁止的。',
    'same' => ':attribute 和 :other 必须匹配。',
    'size' => [
        'numeric' => ':attribute 必须是 :size。',
        'file' => ':attribute 必须是 :size 千字节。',
        'string' => ':attribute 必须是 :size 字符。',
        'array' => ':attribute 必须包含 :size 项。',
    ],
    'starts_with' => ':attribute 必须以以下之一开头：:values。',
    'string' => ':attribute 必须是字符串。',
    'timezone' => ':attribute 必须是一个有效的时区。',
    'unique' => ':attribute 已被占用。',
    'uploaded' => ':attribute 上传失败。',
    'url' => ':attribute 格式无效。',
    'uuid' => ':attribute 必须是一个有效的 UUID。',

    /*
    |--------------------------------------------------------------------------
    | 自定义验证语言行
    |--------------------------------------------------------------------------
    |
    | 你可以为属性指定自定义验证信息，使用 “attribute.rule” 的约定来命名。
    | 这使得为特定规则指定自定义消息变得非常快速。
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 自定义验证属性
    |--------------------------------------------------------------------------
    |
    | 以下语言行用于将属性占位符替换为更易于阅读的内容，
    | 例如将 "email" 替换为 "电子邮件地址"。
    |
    */

    'attributes' => [],

];
