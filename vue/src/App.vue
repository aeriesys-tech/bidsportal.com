<template>
<loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage"/>
<div id="page-container">
    <div id="content-wrap">
        <Header></Header>
        <main>
            <router-view />
        </main>
    </div>
    <div id="footer">
        <Footer></Footer>
    </div>
</div>
</template>
<script>
    import Header from '@/components/Header.vue'
	import Footer from '@/components/Footer.vue'
      import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
    export default {
        name: "App",
        components: { Header, Footer,Loading },
        data(){
            return{
            isLoading: false,
            fullPage: true
            }
        },


 	created() {
            let vm = this
			let main = document.createElement("script");
			main.setAttribute("src", "assets/js/functions.js");
			document.head.appendChild(main);
            //Read the status information in sessionStorage when the page is loaded
            if (sessionStorage.getItem("user")) {
                this.$store.dispatch("setUser", JSON.parse(sessionStorage.getItem("user")));
                this.$store.dispatch("setCartProducts", JSON.parse(sessionStorage.getItem("cartItems")));
                this.$store.dispatch("setAlert", JSON.parse(sessionStorage.getItem("alert")));
                this.$store.dispatch("setFederalTender", JSON.parse(sessionStorage.getItem("federal_tender")));
                this.$store.dispatch("setStateTender", JSON.parse(sessionStorage.getItem("state_tender")));
                this.$store.dispatch("setPrivateTender", JSON.parse(sessionStorage.getItem("private_tender")));
                this.$store.dispatch("setInternationalTender", JSON.parse(sessionStorage.getItem("international_tender")));
                this.$store.dispatch("setToken", sessionStorage.getItem("token"));

            }

            //Save the information in vuex to sessionStorage when the page is refreshed
            window.addEventListener("beforeunload", () => {
                sessionStorage.setItem("user", JSON.stringify(this.$store?.getters?.user));
                sessionStorage.setItem("token", this.$store?.getters?.token);
                sessionStorage.setItem("cartItems", JSON.stringify(this.$store?.getters?.cartItems))
                sessionStorage.setItem("alert", JSON.stringify(this.$store?.getters?.alert))
                sessionStorage.setItem("federal_tender", JSON.stringify(this.$store?.getters?.federal_tender))
                sessionStorage.setItem("state_tender", JSON.stringify(this.$store?.getters?.state_tender))
                sessionStorage.setItem("private_tender", JSON.stringify(this.$store?.getters?.private_tender))
                sessionStorage.setItem("international_tender", JSON.stringify(this.$store?.getters?.international_tender))
            });

        },

		 methods: {
            logout() {
                let vm = this;
               vm.isLoading = true
                vm.$store
                    .dispatch("auth", { uri: "logout", data: vm.$store.getters.user })
                    .then(function () {
                        vm.isLoading = false
                        vm.store.commit('setUser', null);
                        vm.store.commit('setToken', null)
                        // vm.$store.dispatch("logout");
                        vm.$router.push("/login");
                    })
                    .catch(function (error) {
                        vm.isLoading = false
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

        },


	}
</script>
<style>
.v3ti .v3ti-content {
    width: 100%;
    display: flex;
    flex-wrap: nowrap!important;
    overflow:hidden;
    overflow-x:auto;
    cursor:pointer;
}
.gridblockcolor{
   /* color:#47b1ee; */
   color:#ababab
}
.myshadow {


  -webkit-box-shadow: 0px -4px 3px rgba(50, 50, 50, 0.75);
  -moz-box-shadow: 0px -4px 3px rgba(50, 50, 50, 0.75);
 box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
}
#filtershadow{
    /* box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; */
}
#hovershadow:hover{
   box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
   border-radius: var(--bs-card-border-radius);
}
.filtertagcss{background:#0cbc87;border-radius:10px;padding-left:5px !important}
 .textclose{
        color:rgb(86, 84, 109) !important
    }

    .v3ti .v3ti-tag{
    background: #e1f1ff!important;
    color: #00639a!important;
    }
     .v3ti .v3ti-tag .v3ti-remove-tag {
        color: #00639a!important;
        opacity: 1!important;
        /* transition: color 0.3s; */
    }
     .v3ti-content input:focus::placeholder {
  color: transparent !important;
}
  .col-green{color:green

    }
.scroll-div {
    width:100%;
    max-height:250px;
    overflow-y:scroll;
}
</style>
<style scoped>
    #page-container {
        position: relative;
        min-height: 92.5vh;
    }

    #content-wrap {
        padding-bottom: 2.5rem;    /* Footer height */
    }

    #footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 2.5rem;            /* Footer height */
    }
    .title-green{
    color: #16a34a!important;
    }
</style>