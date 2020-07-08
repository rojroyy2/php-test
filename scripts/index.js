var autorisation = new Vue({
	el: '#autorisation',
	data:{
		login: null,
		password: null
	},
	methods: {
		input (){
			formData = {
				login: this.login,
				password: this.password
			};
			axios({
					method: 'POST',
					headers: { "X-Requested-With": "XMLHttpRequest" },
					url: '../modules/autorisation.php',
					data: formData
				})
				.then(function(response){
console.log(response['data']);
					switch(response['data']['status']) {
						case 'error0':
							alert('Неверный логин или пароль!');
							break;
						default:
							document.location.href = 'admin.php';
					    	break;
					}
					
				})
				.catch(function(error){
					console.log(error);
				});
		}
	}
});