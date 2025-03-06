<template>
    <div>
        <loading v-model="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage"/>
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


        // created() {
        //     let vm = this;
        //     let main = document.createElement("script");
        //     main.setAttribute("src", "assets/js/functions.js");
        //     document.head.appendChild(main);

        //     // Restore state from localStorage
        //     const restoreState = (key, action) => {
        //         try {
        //             const storedData = localStorage.getItem(key);
        //             if (storedData) {
        //                 const data = JSON.parse(storedData);
        //                 this.$store.dispatch(action, data);
        //                 localStorage.removeItem(key);
        //             }
        //         } catch (e) {
        //             console.error(`Error restoring ${key} from localStorage:`, e);
        //         }
        //     };

        //     if (localStorage.getItem("user")) {
        //         restoreState("user", "setUser");
        //         if (this.$store.getters.user) {
        //             restoreState("token", "setToken");
        //             restoreState("alert", "setAlert");
        //             restoreState("federal_tender", "setFederalTender");
        //             restoreState("state_tender", "setStateTender");
        //             restoreState("private_tender", "setPrivateTender");
        //             restoreState("international_tender", "setInternationalTender");
        //         }
        //     }

        //     // Save state to localStorage on page refresh
        //     window.addEventListener("beforeunload", () => {
        //         const saveState = (key, getter) => {
        //             const data = this.$store?.getters?.[getter];
        //             if (data) localStorage.setItem(key, JSON.stringify(data));
        //         };

        //         saveState("user", "user");
        //         saveState("token", "token");
        //         saveState("alert", "alert");
        //         saveState("federal_tender", "federal_tender");
        //         saveState("state_tender", "state_tender");
        //         saveState("private_tender", "private_tender");
        //         saveState("international_tender", "international_tender");
        //     });
        // },

        created() {
            //Read the status information in sessionStorage when the page is loaded
            if (localStorage.getItem("user")) {
                this.$store.dispatch("setUser", JSON.parse(localStorage.getItem("user")));
                // localStorage.removeItem("user");
            }
            if (localStorage.getItem("token")) {
                this.$store.dispatch("setToken", localStorage.getItem("token"));
                // localStorage.removeItem("token");
            }
            if (localStorage.getItem("state_tender")) {
                this.$store.dispatch("setStateTender", JSON.parse(localStorage.getItem("state_tender")));
                // localStorage.removeItem("state_tender");
            }
            if (localStorage.getItem("federal_tender")) {
                this.$store.dispatch("setFederalTender", JSON.parse(localStorage.getItem("federal_tender")));
                // localStorage.removeItem("federal_tender");
            }
            if (localStorage.getItem("private_tender")) {
                this.$store.dispatch("setPrivateTender", JSON.parse(localStorage.getItem("private_tender")));
                // localStorage.removeItem("private_tender");
            }
            if (localStorage.getItem("international_tender")) {
                this.$store.dispatch("setsetInternationalTenderUser", JSON.parse(localStorage.getItem("international_tender")));
                // localStorage.removeItem("international_tender");
            }

            //Save the information in vuex to localStorage when the page is refreshed
            window.addEventListener("beforeunload", () => {
                localStorage.setItem("user", JSON.stringify(this.$store?.getters?.user));
                localStorage.setItem("token", this.$store?.getters?.token);
                localStorage.setItem("state_tender", JSON.stringify(this.$store?.getters?.state_tender));
                localStorage.setItem("federal_tender", JSON.stringify(this.$store?.getters?.federal_tender));
                localStorage.setItem("private_tender", JSON.stringify(this.$store?.getters?.private_tender));
                localStorage.setItem("international_tender", JSON.stringify(this.$store?.getters?.international_tender));
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


    /* Add different background colors for each tag based on nth-child */
.v3ti .v3ti-tag:nth-child(1) {
    background: #007bff;
    color: white;
}

.v3ti .v3ti-tag:nth-child(2) {
    background: #28a745;
    color: white;
}

.v3ti .v3ti-tag:nth-child(3) {
    background: #dc3545;
    color: white;
}

.v3ti .v3ti-tag:nth-child(4) {
    background: #ffc107;
    color: black;
}

</style>