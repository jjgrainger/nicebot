<?php

require __DIR__ . '/../app/bootstrap.php';

$app->group('/webhooks', function() {

    $this->post('/netlify/submission', function ($request, $response, $args) {
        // get the submission data
        $submission = $request->getParsedBody();
        $website = false;

        if (isset($submission['data']['website'])) {
            $website = $submission['data']['website'];

            $url_data = parse_url($website);

            $name = str_replace('www.', '', $url_data['host']);
        }

        if ($website) {
            $submit_data = [
                'title' => "Add {$name}",
                'body' => $website,
                'labels' => ['submission'],
            ];

            $this->logger->info('send submission to github', $submit_data);

            // create a GitHub issue
            $res = $this->github->post('/repos/jjgrainger/ohthatsnice/issues', [
                'json' => $submit_data,
            ]);

            $data = json_decode($res->getBody());

            $this->logger->info("Issue created #{$data->number} {$data->title} ({$data->html_url})");
        }

        return $response->withJson(['message' => 'ok']);
    });

});

$app->run();
