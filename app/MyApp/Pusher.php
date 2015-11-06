<?php
namespace MyApp;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;
use Ratchet\Wamp\WampServerInterface;

class Pusher implements WampServerInterface {

    /**
     * @var array|Topic[]
     */
    protected $clients = [];

    /**
     * @param ConnectionInterface $conn
     * @param Topic|string $topic
     */
    public function onSubscribe(ConnectionInterface $conn, $topic) {
        $this->clients[$topic->getId()] = $topic;
    }

    public function onCommand($entry) {
        var_dump($entry);
        $entryData = json_decode($entry, true);

        foreach($this->clients as $client) {
            $client->broadcast($entryData);
        }
    }

    public function onUnSubscribe(ConnectionInterface $conn, $topic) {

    }
    public function onOpen(ConnectionInterface $conn) {

    }
    public function onClose(ConnectionInterface $conn) {

    }
    public function onCall(ConnectionInterface $conn, $id, $topic, array $params) {
        // In this application if clients send data it's because the user hacked around in console
        $conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }
    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible) {
        // In this application if clients send data it's because the user hacked around in console
        $conn->close();
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
        var_dump($e->getMessage());
    }
}