<?php

return [
    "manf" => [
        "services" => "Услуги производителя",
        "action" => [
            "create-service" => "Создать услугу",
            "delete" => "Удалить",
        ],
    ],
    "manf-service" => [
        "printers" => "Доступные принтеры",
        "materials" => "Доступные материалы",
        "orders" => "Заказы",
        "name" => "Название",
        "description" => "Описание",
        "price_base" => "Базовая цена",
        "price_min" => "Минимальная цена",
        "price_per_time" => "Цена за минуту печати",
        "price_per_volume" => "Цена за кубический сантиметр печати",
        "list" => [
            "title" => "Список услуг",
            "manf" => "Фильтр по производителю",
            "model" => "Фильтр по модели",
            "material-color" => "Фильтр по цвету материала",
            "action" => [
                "filter" => "Фильтровать услуги",
            ],
        ],
        "action" => [
            "create-order" => "Создать заказ",
            "add-printer" => "Добавить принтер в список",
            "remove-printer" => "Удалить",
            "edit-materials" => "Редактировать доступные материалы и цвета",
            "delete" => "Удалить",
            "create" => "Создать услугу",
            "create-submit" => "Создать",
            "edit-materials-submit" => "Сохранить материалы",
        ],
    ],
    "order" => [
        "display-name" => "Заказ #:code",
        "address" => "Адрес",
        "model" => "Модель",
        "material_color" => "Цвет материала",
        "material" => "Материал",
        "amount" => "Количество",
        "comment" => "Комментарий",
        "service" => "Услуга",
        "time" => "Время",
        "time-not-defined" => "не определено",
        "price" => "Рассчитанная цена",
        "price-cant-calculate" => "Не удалось рассчитать цену",
        "action" => [
            "list" => "Список заказов",
            "create" => "Создать заказ",
            "submit-create" => "Создать",
            "create-address" => "Создать адрес",
        ],
    ],
    "print-model" => [
        "parameters" => "Параметры",
        "name" => "Название",
        "length" => "Длина",
        "width" => "Ширина",
        "height" => "Высота",
        "volume" => "Объем",
        "list" => [
            "title" => "Мои модели",
            "action" => [
                "create-new" => "Загрузить и создать новую",
                "create" => "Создать",
                "submit-create" => "Создать",
            ],
        ],
        "action" => [
            "download" => "Скачать",
            "edit" => "Редактировать",
            "delete" => "Удалить",
            "save" => "Сохранить",
        ],
    ],
    "user-address" => [
        "missing" => "У вас нет ни одного адреса. Создать?",
        "contact_name" => "Имя контактного лица (имя и фамилия)",
        "phone_number_prefix" => "Префикс телефонного номера",
        "phone_number" => "Номер телефона",
        "address_street" => "Адрес",
        "address_apt" => "Квартира, офис, этаж (необязательно)",
        "address_province" => "Область",
        "address_city" => "Город",
        "address_zipcode" => "Почтовый индекс",
        "comment" => "Комментарий",
        "action" => [
            "create" => "Создать адрес",
            "submit" => "Создать",
        ],
    ],
];