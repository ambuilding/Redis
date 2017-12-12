## Real-time Laravel with Socket.io and Redis

- Redis / Cache drive
- Setup a Redis client on the Node side. Catch the events.
- Laravel's event broadcasting

###Publish events, and catch them from our Node server.

- Publish event with Redis
- Node.js + Redis subscribes to the event
- Use socket.io to emit to all clients

- npm

	$ npm install socket.io ioredis --save

### Related Repo
- [A basic chat App](https://github.com/ambuilding/Enjoy/tree/master/chat)


- A visitor counter / Followers / Number of video downloads / Article views
- Key name-spacing 'users.1.followers' / 'videos.2.downloads'
