<template>
	<div>
		<h2>List of Books</h2>

		<div class="full">
			<div class="half">
				<form @submit.prevent="onSubmit">
					<h4>Add New Book</h4>
					<div>
			          	<label for="email">Book Title: </label>
			          	<input
							type="text"
							id="title"
							v-model="title">

			        </div>
			        <div>
			            <label for="email">Book Author: </label>
						<input
							type="text"
							id="author"
							v-model="author">

			        </div>
					<div class="submit">
						<button type="submit">Submit</button>
					</div>
			    </form>
			</div>

			<div class="half" v-if="editMode">
				<form @submit.prevent="updateBook(editData.id)">
					<h4>Edit Book</h4>
					<div>
			          	<label for="title">Book Title: </label>
			          	<input
							type="text"
							id="title"
							v-model="editData.title">

			        </div>
			        <div>
			            <label for="author">Book Author: </label>
						<input
							type="text"
							id="author"
							v-model="editData.author">

			        </div>
					<div class="submit">
						<button type="submit">Submit</button>
					</div>
			    </form>
			</div>
		</div>

		<ul v-if="books.length">
			<li v-for="book in books" :key="book.id">
				<h4>Title: {{book.title}} 
					<button @click="deleteBook(book.id)">Delete</button> 
					<button @click="editBook(book.id)">Edit</button>
				</h4>
				<p>Author: {{book.author}}</p>
			</li>
		</ul>
		<h3 v-else>Book List is empty!</h3>
	</div>
</template>

<script>
export default {

	name: 'Books',

	data () {
		return {
			apiUrl: '/api',
			token_type: 'Bearer',
			token: localStorage.getItem('book-management-token'),
			books: [],
			title: '',
			author: '',
			editData: null,
			editMode: false
		}
	}, 

	methods: {
		fetchBooks() {
			const url = `${this.apiUrl}/books`;
			fetch(url, {
					headers: {
						'Authorization': this.token_type + ' ' + this.token,
						'Content-Type': 'application/json'
					}
				})
				.then(response => response.json())
				.then(data => this.books = data.books);
		},
		updateBook(val) {
			const url = `${this.apiUrl}/books/${val}`;
			const formData = {
		     	author: this.editData.author,
		     	title: this.editData.title
		    }

			this.editMode = false;
    		this.editData = null;

		    fetch(url, {
		    		method: 'PUT',
		    		body: JSON.stringify(formData),
					headers: {
						'Authorization': this.token_type + ' ' + this.token,
						'Content-Type': 'application/json'
					}
				})
				.then(response => response.json())
				.then(data => {
					this.books.find(book => book.id === val).title = formData.title;
					this.books.find(book => book.id === val).author = formData.author;
				})
				.catch(function() {
			        console.log("error");
			    });
		},
		editBook(val) {
			let book = this.books.find(book => book.id === val);
			this.editData = {title: book.title, author: book.author, id: book.id};
			this.editMode = true
		},
		deleteBook(val) {
			const url = `${this.apiUrl}/books/${val}`;
			const formData = {
		      forceDelete : confirm("Do you want to delete this permanently?"),
		    }

		    fetch(url, {
		    		method: 'DELETE',
		    		body: JSON.stringify(formData),
					headers: {
						'Authorization': this.token_type + ' ' + this.token,
						'Content-Type': 'application/json'
					}
				})
				.then(response => response.json())
				.then(data => {
					let index = this.books.findIndex(book => book.id === val);
    				this.books.splice(index, 1);
				})
				.catch(function() {
			        console.log("error");
			    });
		},
		onSubmit () {
		    const formData = {
		      title : this.title,
		      author : this.author,
		    }
		    this.clearInputs()
		    const url = `${this.apiUrl}/books`;
		    fetch(url, {
		    		method: 'POST',
		    		body: JSON.stringify(formData),
					headers: {
						'Authorization': this.token_type + ' ' + this.token,
						'Content-Type': 'application/json'
					}
				})
				.then(response => response.json())
				.then(data => {this.books.push(data.book)})
				.catch(function() {
			        console.log("error");
			    });
		},
		clearInputs() {
			this.title = ''
			this.author = ''
		}
	},

	created: function() {
		this.fetchBooks();
	}
}
</script>

<style lang="css" scoped>
.half {
	padding: 5px 20px;
}

.full {
	width: 100%;
	display: flex;
}
</style>