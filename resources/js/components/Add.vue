<template>
	<div class="modal" :class='openModal'>
	  <div class="modal-background"></div>
	  <div class="modal-card">
	    <header class="modal-card-head">
	      <p class="modal-card-title">Add New Entry</p>
	      <button class="delete" aria-label="close" @click='close'></button>
	    </header>
	    <section class="modal-card-body">
		    <div class="field">
			    <div class="control">
			    	<input class="input is-primary" :class="{'is-danger':errors.name}" type="text" placeholder="Name" v-model='list.name'>
			    </div>
			    <small v-if="errors.name">{{ errors.name[0] }}</small>
		    </div>
		    <div class="field">
			  <div class="control">
			    <input class="input is-info" :class="{'is-danger':errors.phone}" type="number" placeholder="Phone" v-model='list.phone'>
			  </div>
			  <small v-if="errors.phone">{{ errors.phone[0] }}</small>
			</div>
			<div class="field">
			  <div class="control">
			    <input class="input is-success" :class="{'is-danger':errors.email}" type="email" placeholder="Email" v-model='list.email'>
			  </div>
			  <small v-if="errors.email">{{ errors.email[0] }}</small>
			</div>
	    </section>
	    <footer class="modal-card-foot">
	      <button class="button is-success" @click='save'>Save</button>
	      <button class="button" @click='close'>Cancel</button>
	    </footer>
	  </div>
	</div>
</template>


<script>
	export default{
		props: ['openModal'],
		data(){
			return{
				list:{
					name: '',
					phone: '',
					email: '',
				},
				errors:{}
			}
		},
		methods: {
			close(){
				this.$emit('closeRequest')
			}, 
			save(){
				axios.post('myphonebook',this.$data.list)
				.then((response) => {
					this.close();
					this.$parent.lists.push(response.data);
					this.$parent.lists.sort(function(a,b){
						if(a.name.toLowerCase() > b.name.toLowerCase()){
							return 1;
						}else if(a.name.toLowerCase() < b.name.toLowerCase()){
							return -1;
						}
					});
					this.list.name = this.list.phone = this.list.email = ''
					this.errors = ''
				})
				.catch((error) => this.errors = error.response.data.errors)
			}
		}
	}
</script>