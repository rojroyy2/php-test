	// Страница загружена
window.onload = function(){
	booksListGet();
	authorListGet();
}

	// Функция получения списка книг для таблицы
function booksListGet(){
	axios({
		method: 'POST',
		headers: { "X-Requested-With": "XMLHttpRequest" },
		url: '../modules/bookList.php'
	})
	.then(function(response){

		adminFunctionConteiner.books.list = response['data']['list'];
	
	})
	.catch(function(error){
		console.log(error);
	});
}
	// Функция получения списка авторов для таблицы
function authorListGet(){
	axios({
		method: 'POST',
		headers: { "X-Requested-With": "XMLHttpRequest" },
		url: '../modules/authorList.php'
	})
	.then(function(response){

		adminFunctionConteiner.author.list = response['data']['list'];
		adminFunctionConteiner.books.selectList = response['data']['select'];
	
	})
	.catch(function(error){
		console.log(error);
	});
}
	// VUE JS
var adminFunctionConteiner = new Vue({
	el: '#adminFunctionConteiner',
	data: {
		books: {
			id: null,
			statusShow: '',
			list: [],
			selectList: [],
			info:{
				show: false,
				name: '',
				year: null,
				count: null,
				author: null,
				preview: ''
			}
		},
		author: {
			id: null,
			statusShow: false,
			list: [],
			info:{
				show: false,
				surname: '',
				name: null,
				patronymic: null
			}
		}
	},
	methods: {
		// Работа с таблицей содержащей книги
		booksTableClick(){
			this.bookInfoClear();
			this.books.id = event.target.parentNode.dataset.id;
			this.books.statusShow = '';
		},
		// Кнопка для открытия окна добавления новой книги
		addBookWindowShow(){
			this.bookInfoClear();
			this.books.info.show = true;
		},
		// Кнопка для открытия окна изменения информации об уже существующей книге
		editInfoBookWindowShow(){
			if (this.books.id != null){
				let id = this.books.id;
				axios({
						method: 'POST',
						headers: { "X-Requested-With": "XMLHttpRequest" },
						url: '../modules/books/getBookInfo.php',
						data: id
					})
					.then(function(response){

						adminFunctionConteiner.books.info.name = response['data']['name'];
						adminFunctionConteiner.books.info.year = response['data']['year_write'];
						adminFunctionConteiner.books.info.count = response['data']['count_pages'];
						adminFunctionConteiner.books.info.author = response['data']['author'];
						adminFunctionConteiner.books.info.preview = response['data']['preview'];
						adminFunctionConteiner.books.info.show = true;
					
					})
					.catch(function(error){
						console.log(error);
					});
			}else{
				this.bookInfoClear();
				this.books.statusShow = 'Сначала выберите книгу!';
			}
		},
		// Кнопка для удаления книги
		bookDel(){
			if (this.books.id != null){
				if (this.books.id != null){
					let id = this.books.id;
					axios({
							method: 'POST',
							headers: { "X-Requested-With": "XMLHttpRequest" },
							url: '../modules/books/delBook.php',
							data: id
						})
						.then(function(response){

							if (response['data']['status'] == true){
								adminFunctionConteiner.books.statusShow = 'Успешно!';
								booksListGet();
								authorListGet();
								setTimeout(function(){
									adminFunctionConteiner.bookInfoClear();
								}, 2000);
							}else{
								adminFunctionConteiner.books.statusShow = 'Ошибка!';
								setTimeout(function(){
									adminFunctionConteiner.bookInfoClear();
								}, 2000);
							}
						
						})
						.catch(function(error){
							console.log(error);
						});
				}else{
					this.bookInfoClear();
					this.books.statusShow = 'Сначала выберите книгу!';
				}
			}else{
				this.bookInfoClear();
				this.books.statusShow = 'Сначала выберите книгу!';
			}
		},
		// Отчистка полей ввода информаци о книге
		bookInfoClear(){
			let infoClear = {
				show: false,
				name: '',
				year: null,
				count: null,
				author: null,
				preview: ''
			};
			this.books.id = null;
			this.books.info = infoClear;
			this.books.statusShow = '';
		},
		// Сохранение информации о книге
		bookInfoSave(){

			let formData = {};
			let operationUrl = '';

			if (this.validInfoBook() == true){

				formData = {
					id: parseInt(this.books.id),
					name: this.books.info.name,
					year_write: parseInt(this.books.info.year),
					count_pages: parseInt(this.books.info.count),
					author: parseInt(this.books.info.author),
					preview: this.books.info.preview
				};

				if (this.books.id == null){

					// Запрос на добавление новой книги
					operationUrl = '../modules/books/addBooks.php';

				}else{

					// Запрос на изменение информации об уже существующей книге
					operationUrl = '../modules/books/editInfoBook.php';

				}

			}else{
				return false;
			}

			// Выполняем запрос на добавление новой книги или на изменение информации о выбранной

			axios({
				method: 'POST',
				headers: { "X-Requested-With": "XMLHttpRequest" },
				url: operationUrl,
				data: formData
			})
			.then(function(response){

				if (response['data']['status'] != 'good'){

					adminFunctionConteiner.books.statusShow = 'Ошибка!';
					setTimeout(function(){
						adminFunctionConteiner.bookInfoClear();
					}, 2000);

				}else{

					let authorName = '';

					adminFunctionConteiner.books.selectList.forEach(function(elem){
						if (elem['id'] == formData.author){
							authorName = elem['author'];
						}
					});

					adminFunctionConteiner.books.statusShow = 'Успешно!';

					if (operationUrl == '../modules/books/addBooks.php'){
						let newBook = {
							id: response['data']['id'],
							name: formData.name,
							author: authorName,
							year_write: formData.year_write,
							count_pages: formData.count_pages
						};
						adminFunctionConteiner.books.list.push(newBook);
						authorListGet();
					}else{
						booksListGet();
					}
					
					setTimeout(function(){
						adminFunctionConteiner.bookInfoClear();
					}, 2000);

				}
			
			})
			.catch(function(error){
				console.log(error);
			});

		},
		// Проверка полей с информацией о книге
		validInfoBook(){
			if ((this.books.info.name != '')&&(this.books.info.year != '')&&(this.books.info.count != '')&&(this.books.info.author != '')&&(this.books.info.preview != '')){
				return true;
			}else{
				this.books.statusShow = "Заполните все поля!";
				return false;
			}
		},
		// Работа с таблицей авторов
		authorTableClick(){
			this.author.id = event.target.parentNode.dataset.id;
		},
		// Удаление автора
		authorDel(){
			if (this.author.id == null){
				this.author.statusShow = "Сначала выберите автора!";
			}else{
				
				// Запрос

				axios({
					method: 'POST',
					headers: { "X-Requested-With": "XMLHttpRequest" },
					url: '../modules/author/delAuthor.php',
					data: parseInt(adminFunctionConteiner.author.id)
				})
				.then(function(response){

					switch(response['data']['status']){
						case 'good':
							adminFunctionConteiner.author.statusShow = "Успешно!";
							authorListGet();
							setTimeout(function(){
								adminFunctionConteiner.authorInfoClear();
							}, 2000);
							break;
						case 'error1':
							adminFunctionConteiner.author.statusShow = "Сначала удалите написанные данным автором книги!";
							setTimeout(function(){
								adminFunctionConteiner.authorInfoClear();
							}, 5000);
							break;
						default:
							adminFunctionConteiner.author.statusShow = "Ошибка!";
							setTimeout(function(){
								adminFunctionConteiner.authorInfoClear();
							}, 2000);
							break;
					}

				})
				.catch(function(error){
					console.log(error);
				});

			}
		},
		// Открыть окно для добавления нового автора
		addNewAuthor(){
			this.author.info.show = true;
		},
		// Открыть окно для изменения информации о авторе
		editInfoAuthor(){

			if (this.author.id == null){
				this.author.statusShow = "Сначала выберите автора!";
			}else{

				// Перенос информации (для редактирования) из списка авторов в поля ввода, чтобы не нагружать сервер запросами
				adminFunctionConteiner.author.list.forEach(function(elem){
					if (elem.id == adminFunctionConteiner.author.id){
						adminFunctionConteiner.author.info.surname = elem.surname;
						adminFunctionConteiner.author.info.name = elem.name;
						adminFunctionConteiner.author.info.patronymic = elem.patronymic;
					}
				});

				this.author.info.show = true;

			}
		},
		// Сохранить информацию об авторе
		saveInfoAuthor(){
			
			let operationUrl = '';

			// Проверка полей ввода
			
			if (this.validInfoAuthor() == true){

				if (this.author.id == null){
					operationUrl = '../modules/author/addNewAuthor.php';
				}else{
					operationUrl = '../modules/author/editInfoAuthor.php';
				}

				// Формирование данных для отправки

				formData = {
					id: this.author.id,
					surname: this.author.info.surname,
					name: this.author.info.name,
					patronymic: this.author.info.patronymic
				}

				// Запрос на создание нового автора или изменение информации об уже существующем

				axios({
					method: 'POST',
					headers: { "X-Requested-With": "XMLHttpRequest" },
					url: operationUrl,
					data: formData
				})
				.then(function(response){

					if (response['data']['status'] == false){

						adminFunctionConteiner.author.statusShow = 'Ошибка!';
						setTimeout(function(){
							adminFunctionConteiner.authorInfoClear();
						}, 2000);

					}else{

						if (operationUrl == '../modules/author/addNewAuthor.php'){

							let newAuthor = {
								id: response['data']['id'],
								surname: adminFunctionConteiner.author.info.surname,
								name: adminFunctionConteiner.author.info.name,
								patronymic: adminFunctionConteiner.author.info.patronymic,
								count: 0
							};

							adminFunctionConteiner.author.list.push(newAuthor);

						}else{

							authorListGet();

						}

						setTimeout(function(){
							adminFunctionConteiner.authorInfoClear();
						}, 2000);

					}
				
				})
				.catch(function(error){
					console.log(error);
				});

			}else{
				this.author.statusShow = "Заполните все поля!";
			}

		},
		// Проверка введённой информции об авторе
		validInfoAuthor(){
			if ((this.author.info.name != '')&&(this.author.info.surname != '')&&(this.author.info.patronymic != '')){
				return true;
			}else{
				this.author.statusShow = "Заполните все поля!";
				return false;
			}
		},
		// Отчистка введённой информации об авторе
		authorInfoClear(){
			this.author.id = null;
			this.statusShow = false;
			let clear = {
				show: false,
				surname: '',
				name: null,
				patronymic: null
			}
			this.author.info = clear;
		}
	}
});