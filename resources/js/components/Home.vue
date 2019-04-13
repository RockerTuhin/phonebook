<template>
	<div>
		<nav class="panel column is-offset-2 is-8">
		  <p class="panel-heading">
		    Vuejs Phonebook
		    <button class="button is-primary is-outlined" @click="openAdd">
		      Add New
		    </button>
		    <span class="is-pulled-right" v-if="loading">
		    	<i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
		    </span>
		  </p>
		  <div class="panel-block">
		    <p class="control has-icons-left">
		      <input class="input is-small" type="text" placeholder="search" v-model="searchQuery">
		      <span class="icon is-small is-left">
		        <i class="fas fa-search" aria-hidden="true"></i>
		      </span>
		    </p>
		  </div>
		  <a class="panel-block" v-for="item,key in temp">
		    <span class="column is-9">
		       {{ item.name }}
		    </span>
		    <button class="button is-small is-outlined is-primary" @click="openShow(key)">
		    	View
		    </button>
		    <button class="button is-small is-outlined is-info" @click="updateShow(key)">
		    	Edit
		    </button>
		    <button class="button is-small is-outlined is-danger" @click="deleteItem(key,item.id)">
		    	Delete
		    </button>
		  </a>
		</nav>

		<Add :openModal='addActive' @closeRequest='close'></Add>
		<Show :openModal='showActive' @closeRequest='close'></Show>
		<Update :openModal='updateActive' @closeRequest='close'></Update>

	</div>
</template>

<script>
	let Add = require('./Add.vue').default;
	let Show = require('./Show.vue').default;
	let Update = require('./Update.vue').default;

	export default {
		components: {Add,Show,Update},
		data(){
			return {
				addActive: '',
				showActive: '',
				updateActive: '',
				lists:{},
				errors:{},
				loading: false,
				searchQuery: '',
				temp: '',
			}
		},
		watch:{
			searchQuery(){
				if(this.searchQuery.length > 0){
					this.temp = this.lists.filter((item) => {
						return Object.keys(item).some((key) => {
							let string = String(item[key])
							return string.toLowerCase().indexOf(this.searchQuery.toLowerCase())>-1
						})
					});
				}
				else{
					this.temp = this.lists;
				}
			}
		},
		mounted(){
			axios.post('getData')
				.then((response) => this.lists = this.temp = response.data)
				.catch((error) => this.errors = error.response.data.errors)
		},
		methods: {
			openAdd(){
				this.addActive = 'is-active';
			},
			openShow(key){
				this.$children[1].list = this.temp[key]
				this.showActive = 'is-active';
			},
			updateShow(key){
				this.$children[2].list = this.temp[key]
				this.updateActive = 'is-active';
			},
			deleteItem(key,id){
				if(confirm("Are you sure?")){
					this.loading = !this.loading
					axios.delete(`myphonebook/${id}`)
					.then((response) => {this.lists.splice(key,1);this.loading = !this.loading})
					.catch((error) => this.errors = error.response.data.errors)
				}
				console.log(`${key} ${id}`)
			},
			close(){
				this.addActive = this.showActive = this.updateActive = '';
			}
		}
	}
</script>