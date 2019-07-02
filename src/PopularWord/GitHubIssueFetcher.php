<?php

namespace App\PopularWord;

use App\PopularWord\Model\PopularWord;

/**
 * Class GitHubIssueFetcher
 *
 * @package App\PopularWord
 *
 * Class that make request to GitHub for issue and pull
 * requests and fetches data.
 */
class GitHubIssueFetcher implements PopularWordFetcherInterface
{
    /** @var string */
    private $githubIssueApiUrl = 'https://api.github.com/search/issues';

    /**
     * {@inheritdoc}
     * @throws \RuntimeException
     */
    public function fetch(string $term): PopularWord
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "{$this->githubIssueApiUrl}?q={$term}");
        curl_setopt($ch, CURLOPT_USERAGENT, 'popular-word');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $errorNo = curl_errno($ch);

        if (is_resource($ch)) {
            curl_close($ch);
        }

        if (0 !== $errorNo) {
            throw new \RuntimeException($error, $errorNo);
        }

        return new PopularWord('php', json_decode($response)->total_count);
    }
}
