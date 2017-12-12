<!DOCTYPE html>
<html>
	<head>
		<title>LaraRedis</title>
	</head>
	<body>
		<div id="event">
			<h1>New Users</h1>

			<ul>
	            <li v-for="user in users">@{{ user }}</li>
	        </ul>
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.9/vue.min.js"></script>

		<script>
			var socket = io('http://127.0.0.1:3000');

	        new Vue({
	            el: '#event',

	            data: {
	                users: []
	            },

	            mounted: function() {
	                socket.on('private-test-channel:App\\Events\\UserSignedUp', function(data) {
	                    this.users.push(data.username);
	                }.bind(this));
	            }
	        });
		</script>
	</body>
</html>
