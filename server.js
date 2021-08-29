const redis = require("redis");

const subscriber = redis.createClient();
const publisher = redis.createClient();

let messageCount = 0;

subscriber.on("subscribe", function(channel, count) {
    publisher.publish("d1", "a message");
    publisher.publish("d1", "another message");
});

subscriber.on("message", function(channel, message) {
    messageCount += 1;

    console.log("Subscriber received message in channel '" + channel + "': " + message);

    // if (messageCount === 2) {
    //     subscriber.unsubscribe();
    //     subscriber.quit();
    //     publisher.quit();
    // }
});

subscriber.subscribe("d1");
