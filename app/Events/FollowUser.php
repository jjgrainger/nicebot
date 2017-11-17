<?php

namespace App\Events;

use Pimple\Container;

class FollowUser
{
    public $twitter;

    public function __construct(Container $app)
    {
        $this->twitter = $app['twitter'];
        $this->logger = $app['logger'];
    }

    public function run()
    {
        // get a random user id from the competitors list
        $member_id = $this->getListMembers();

        // get a random follower of that competitor
        $follow_id = $this->getFollower($member_id);

        // follow that user
        $response = $this->followUser($follow_id);

        $user = json_decode($response);

        var_dump($user);

        $this->logger->info("Following {$user->name} @{$user->screen_name}");
    }

    public function getListMembers()
    {
        // get members in a specific list of competitors
        $response = $this->twitter->request('GET', 'lists/members.json', [
            'query' => [
                'list_id' => '764109178923261952'
            ]
        ]);

        // grab a random member from that list
        $response = json_decode($response->getBody());

        // map members so its an array of user ids
        $members = array_map(function($item) {
            return $item->id;
        }, $response->users);

        // select a random member id
        return $members[array_rand($members)];
    }

    public function getFollower($user_id)
    {
        $response = $this->twitter->request('GET', 'followers/ids.json', [
            'query' => [
                'user_id' => $user_id,
            ]
        ]);

        $data = json_decode($response->getBody());

        return $data->ids[array_rand($data->ids)];
    }

    public function followUser($follow_id)
    {
        $response = $this->twitter->request('POST', 'friendships/create.json', [
            'query' => [
                'user_id' => $follow_id,
                'follow' => true
            ]
        ]);

        return $response->getBody();
    }
}
