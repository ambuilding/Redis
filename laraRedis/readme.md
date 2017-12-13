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
- Sorted sets / Sort the top scoring basketball teams / a forum leaderboard / the most popular video
- When It comes to Redis, even two lines of code can accomplish so much.

- Hashes / Laravel's cache / Redis
- [Redis commands](https://redis.io/commands#hash)

- Caching with Redis
  - Caching is an incredible use-case for Redis. Caching database queries, API calls, or even HTML fragments.
  - Building up a custom remember function, before switching over to Laravel's Cache component.

- How to organize PHP to best take advantage of caching
  - Structure the Caching layer
  - Dry up the code
  - Turn the caching on and off

- Fetch in progress articles: A traditional MySQL pivot table / Redis
