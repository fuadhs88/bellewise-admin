
<template>
	

	<div class="container"> <!-- Container tag open -->

		<div class="pageloader purple-bg" v-bind:class="{ 'is-active': loadPromoLoader }"><span class="title"> Bellewise loading </span></div>


		<div class="notification purple-bg-light is-bold has-text-black" v-if="loadPromoNotification">
			Task Succeesful
		</div>


		<nav class="level">

			<div class="level-item has-text-centered">

				<div class="field has-addons">
					<div class="control">
						<input class="input" type="text" placeholder=" Search promotion by name" v-model="searchQuery" v-on:keyup="searchMethod" @keyup="searchSpinner">
					</div>
					<div class="control">
						<a class="button purple-color" v-bind:class="{ 'is-loading': isSpinning }">
							Search
						</a>
					</div>
				</div>

			</div>

			<div class="level-item has-text-centered">
				<div class="tabs is-toggle">
					<ul>

						<li>
							<router-link :to="{ name: 'add-promotion' }" exact>
								<span class="icon is-small"><i class="fas fa-plus purple-color" aria-hidden="true"></i></span>
								<span> Add Promo</span>
							</router-link>
						</li>

					</ul>
				</div>

			</div>
		</nav>

		<div class="columns is-multiline"> <!-- Columns wrapper tag open -->


			<div class="column is-6" v-for="promo in searchQuery.length  > 1  ? loadPromoSearch : loadPromo "> <!-- column tag open-->

				<div class="card is-relative">

					<router-link class="absolute-position-left" :to="{name: 'edit-promotion', params: {id: promo.id} }" exact> <i class="fas fa-edit fa-lg has-text-danger"> </i> </router-link>
					<a class="absolute-position-right" @click="showModal = true"> <i class="fas fa-trash fa-lg has-text-danger" v-if=" (loadAuthUser.admin == 'super_admin') || (loadAuthRole.promo_delete == 1) "> </i> </a>

					<div class="card-content purple-bg border-curve has-text-centered has-text-white">
						<p class="title has-text-white"> {{ promo.name }} </p>
						<p class="subtitle is-bold has-text-white"> {{ promo.discount }} % OFF </p>
						<p class=""> Expiry Date: {{ promo.validity }} </p>
					</div>

					<div class="card-content">
						<div class="content is-bold">
							<ul>
								<li>
									Min. Order Amount is -  ₦{{ promo.amount }}
								</li>
								<li>
									No. of vouchers - {{ promo.voucher}}
								</li>
								<li>
									Customers - {{ promo.user}}
								</li>
							</ul>
							<div class="card-footer"> <!-- card footer tag open -->
								<router-link class="card-footer-item purple-color" :to="{name: 'view-promo-restaurants', params: {id: promo.id}}" exact>
									View Restaurants 
								</router-link>
							</div> <!-- card footer tag close -->

						</div>
					</div>
				</div>

				<!-- Delete modal option -->
				<div class="modal is-active" v-if="showModal">
					<div class="modal-background"></div>
					<div class="modal-content">
						<!-- Any other Bulma elements you want -->
						<div class="card">
							<div class="card-content has-text-centered">
								<p class="subtitle is-bold">
									Are you sure
								</p>
							</div>
							<footer class="card-footer">
								<p class="card-footer-item is-bold purple-color pointer" v-on:click="deleteData(promo.id)">
									Delete
								</p>
								<p class="card-footer-item is-bold purple-color pointer" @click="showModal = false">
									Cancel
								</p>
							</footer>
						</div>              
					</div>
					<button class="modal-close is-large" aria-label="close" @click="showModal = false"></button>
				</div>


			</div> <!-- column tag close -->


		</div> <!-- Columns wrapper tag close -->


		<!-- Pagination section -->
		<div class="buttons has-addons is-centered" v-if="loadPromo.length >= 1">
			<a class="button" v-if="loadPromoPagination.previousPageUrl" @click="paginationHandler(loadPromoPagination.previousPageUrl)">
				<span class="icon is-small">
					<i class="fas fa-arrow-left purple-color"></i>
				</span>
				<span> Previous </span>
			</a>


			<a class="button">

				{{ loadPromoPagination.to}} 0f {{loadPromoPagination.total}}
			</a>


			<a class="button" v-if="loadPromoPagination.nextPageUrl" @click="paginationHandler(loadPromoPagination.nextPageUrl)">
				<span class="icon is-small">
					<i class="fas fa-arrow-right purple-color"></i>
				</span>
				<span> Next </span>
			</a>
		</div>

		<div class="card" v-if="loadPromo.length <= 0">
			<div class="card-content">
				<div class="content is-bold has-text-centered subtitle">

					<span class="fa"> No promotion found. Add a promotion instead. </span>

				</div>
			</div>
		</div>


	</div> <!-- Container tag close -->


</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';

export default {

	data: () => ({
		showModal: false,
		searchQuery: '',
		isSpinning: null,
	}),

	created() {
		this.fetchPromoDatas()
		this.clearPromoNotification()
	},

	methods: {
		...mapActions(['fetchPromoDatas', 'clearPromoNotification', 'destroyPromoData', 'searchPromoDatas']),
    // Local method

    deleteData(id) {
    	this.destroyPromoData(id)
    	this.fetchPromoDatas()
    	this.showModal = false
    },

    paginationHandler(uri) {
    	this.fetchPromoDatas(uri)
    },

    searchMethod() {
    	if(this.searchQuery.length > 1) {
    		this.searchPromoDatas(this.searchQuery)
    	}
    },

    searchSpinner() {
    	if ( this.searchQuery.length > 1 ) {
    		this.isSpinning = true
    		setTimeout(() => {
    			this.isSpinning = false
    		}, 800)
    	}
    },

},


computed: {
	...mapGetters(['loadPromo', 'loadPromoLoader', 'loadPromoNotification', 'loadPromoPagination', 'loadPromoSearch', 'loadAuthUser', 'loadAuthRole']),
    // Local computed properties

},


}

</script>
