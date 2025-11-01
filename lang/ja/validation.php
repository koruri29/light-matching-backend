<?php

return [
    'required' => ':attributeは必須です',
    'string' => ':attributeは文字列で入力してください',
    'email' => '有効なメールアドレスを入力してください',
    'unique' => '入力した:attributeは登録済みのため、指定できません',
    'confirmed' => ':attributeが一致しません',
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください',
    ],

    'attributes' => [
        'name' => '氏名（本名）',
        'email' => 'メールアドレス',
        'line' => 'LINE ID',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード（確認）',
    ],
];
