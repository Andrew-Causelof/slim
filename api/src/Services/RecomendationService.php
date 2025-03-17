<?php

namespace Api\Services;

use Api\Models\Recomendation;
use CFile;
use Seogravity\Application\CachedContent;

class RecomendationService
{

    private Recomendation $recomendationModel;

    public function __construct(Recomendation $recomendationModel)
    {
        $this->recomendationModel = $recomendationModel;
    }

    public function getFormatted(): array
    {
        $data = $this->recomendationModel->getRecomendation();

        $videos = array_map(
            fn($video) => [
                'title' => htmlspecialchars_decode($video['NAME'] ?? ''),
                'url' => $video['URL']['VALUE'] ?? '',
                'img' => SITE_URL . CFile::GetPath($video['DETAIL_PICTURE'])
            ],
            $data['RECOMMENDATION_VIDEO'] ?? []
        );

        $files = array_map(
            fn($file) => [
                'title' => htmlspecialchars_decode($file['TITLE'] ?? ''),
                'url' => !empty($file['FILE']) ? SITE_URL . CFile::GetPath($file['FILE']) : ''
            ],
            $data['RECOMMENDATION_TEXT'] ?? []
        );

        return [
            'title' => htmlspecialchars_decode($data['RECOMMENDATION_TITLE'] ?? ''),
            "sections" => array_filter([
                [
                    "title" => htmlspecialchars_decode($data['RECOMMENDATION_VIDEO_TITLE'] ?? ''),
                    "type" => "video",
                    "items" => $videos,
                ],
                [
                    "title" => htmlspecialchars_decode($data['RECOMMENDATION_TEXT_TITLE'] ?? ''),
                    "type" => "file",
                    "items" => $files
                ],
            ], fn($section) => !empty($section['items']))
        ];
    }
}
