<template>
	<div class="modal" :class='openModal'>
	  <div class="modal-background"></div>
	  <div class="modal-card">
	    <header class="modal-card-head">
	      <p class="modal-card-title">Update {{ list.name }}'s details</p>
	      <button class="delete" aria-label="close" @click="close"></button>
	    </header>
	    <section class="modal-card-body">
		    <div class="field">
			    <div class="control">
			    	<input class="input is-primary" :class="{'is-danger':errors.name}" type="text" placeholder="Name" v-model="list.name">
			    </div>
			    <small v-if="errors.name" class="has-text-danger">{{ errors.name[0] }}</small>
		    </div>
		    <div class="field">
			  <div class="control">
			    <input class="input is-info" :class="{'is-danger':errors.phone}" type="number" placeholder="Phone" v-model="list.phone">
			  </div>
			  <small v-if="errors.phone" class="has-text-danger">{{ errors.phone[0] }}</small>
			</div>
			<div class="field">
			  <div class="control">
			    <input class="input is-success" :class="{'is-danger':errors.email}" type="email" placeholder="Email" v-model="list.email">
			  </div>
			  <small v-if="errors.email" class="has-text-danger">{{ errors.email[0] }}</small>
			</div>
	    </section>
	    <footer class="modal-card-foot">
	      <button class="button is-success" @click="update">Update</button>
	      <button class="button" @click="close">Cancel</button>
	    </footer>
	  </div>
	</div>
</template>

<script>
	export default{
		props: ['openModal'],
		data(){
			return{
				list:{},
				errors:{}
			}
		},
		methods:{
			close(){
				this.$emit('closeRequest')
			},
			update()
			{
				axios.patch(`myphonebook/${this.list.id}`,this.$data.list)
				.then((response) => this.close())
				.catch((error) => this.errors = error.response.data.errors)
			}
		}
	}
</script>