var conn = new ab.Session('ws://localhost:8080',
    function() {
        conn.subscribe('jestemPlejerem', function(topic, data) {
            console.log('Przyszou command: ' + data.command);
            invokePlayerHandler(data.command);
        });
    },
    function() {
        console.warn('WebSocket connection closed');
    },
    {'skipSubprotocolCheck': true}
);