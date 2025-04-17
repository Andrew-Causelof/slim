<?php

namespace Api\Services;

use Api\Models\Rules;
use CFile;
use Seogravity\Application\CachedContent;

class RulesService
{

    private Rules $rulesModel;

    public function __construct(Rules $rulesModel)
    {
        $this->rulesModel = $rulesModel;
    }

    public function getFormattedRules(): array
    {
        $result = CachedContent::get('rules-service', 'get-formated-rules', 3600, function () {
            $data = $this->rulesModel->getRules();

            $sections = [
                "GENERAL_REQUIREMENTS" => "Общие требования",
                "PROCEDURE" => "Порядок действий при госпитализации",
                "HOSPITALIZATION" => "В день госпитализации",
                "ADDITIONAL_RECOMMENDATIONS" => "Дополнительные рекомендации"
            ];

            $rules = [
                'title' => $data['RULES_TITLE'],
                'pdfUrl' => $data['RULES_FILE'],
                'sections' => array_map(
                    fn($key, $title) => [
                        'title' => htmlspecialchars_decode($data['RULES_TITLE'] ?? ''),
                        "items" => array_map(
                            fn($item, $index) => [
                                "number" => $index + 1,
                                "text" => htmlspecialchars_decode($item['TEXT'] ?? ''),
                                "notice" => htmlspecialchars_decode($item['NOTICE'] ?? ''),
                                "description" => htmlspecialchars_decode($item['DESCRIPTION'] ?? ''),
                            ],
                            $data[$key] ?? [], // Проверяем, существует ли массив данных
                            array_keys($data[$key] ?? [])
                        )
                    ],
                    array_keys($sections),
                    $sections
                )
            ];

            return $rules;
        });


        return $result;
    }
}
