<template>
	<div v-if="$store.getters.user">
		<Header></Header>
		<div class="main main-app p-4 pt-2">
			<router-view />
		</div>
	</div>
	<div v-else>
		<router-view />
	</div>
</template>
<script>
import Sidebar from "./components/Sidebar.vue";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import moment from 'moment';

export default {
	name: 'App',
	components: { Sidebar, Header, Footer },

	created() {
		//Read the status information in sessionStorage when the page is loaded
		if (sessionStorage.getItem("user")) {
			this.$store.dispatch("setUser", JSON.parse(sessionStorage.getItem("user")));
			sessionStorage.removeItem("user");
		}
		if (sessionStorage.getItem("token")) {
			this.$store.dispatch("setToken", sessionStorage.getItem("token"));
			sessionStorage.removeItem("token");
		}

		//Save the information in vuex to sessionStorage when the page is refreshed
		window.addEventListener("beforeunload", () => {
			sessionStorage.setItem("user", JSON.stringify(this.$store?.getters?.user));
			sessionStorage.setItem("token", this.$store?.getters?.token);
		});
	},
};
</script>
<style scoped>
.mt-35 {
	margin-top: 10px;
}

/* @media only screen and (max-width: 991px) {
	.main {
		margin-top: 35px;
	}
} */
@media (min-width: 992px) {
	.header-main {
		left: 0px !important;
		border-left: 1px solid #f8f9fc;
	}

}

@media (min-width: 992px) {
	.main {
		margin-left: 0px;
	}
}
</style>
<style>
	::-webkit-scrollbar{
        /* height: 5px; */
		height: 8px;
        width: 10px;
        background: gray;
    }

    /* Track */
    ::-webkit-scrollbar-track {
    	background: #f1f1f1; 
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
    	background: #506fd9; 
		/* background: #F5D34F #E7C845 #F68529 #D51D25 #991010; */
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
    	background: #555; 
    }

    ::-webkit-scrollbar-thumb:horizontal{
        background: #506fd9;
		/* background: #F5D34F #E7C845 #F68529 #D51D25 #991010; */
        border-radius: 10px;
    }
	::-webkit-scrollbar-thumb:vertical{
        background: #506fd9;
		/* background: #F5D34F #E7C845 #F68529 #D51D25 #991010; */
        border-radius: 10px;
    }
</style>