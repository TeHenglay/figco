<?php

namespace App\Services;

class FigmaUrlParser
{
    public function parse(string $url): array
    {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '';
        $query = $parsed['query'] ?? '';

        preg_match('#/(?:file|design)/([a-zA-Z0-9]+)#', $path, $fileMatches);
        parse_str($query, $queryParams);

        $fileKey = $fileMatches[1] ?? null;
        $nodeId = isset($queryParams['node-id'])
            ? str_replace(':', '-', $queryParams['node-id'])
            : null;

        return [
            'file_key' => $fileKey,
            'node_id'  => $nodeId,
            'valid'    => $fileKey !== null,
        ];
    }
}
