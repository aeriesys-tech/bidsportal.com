<template>
    <div class="regions">
        <div class="container-fluid justify-content-center pt-3">
            <ul class="nav nav-tabs nav-justified">
                <li class="nav-item">
                    <router-link to="/bids/state-opportunities" class="nav-link" :class="state_active">
                        <img class="icon" :src="state_image" alt="icon" />
                        State Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/federal-opportunities" class="nav-link" :class="federal_active">
                        <img class="icon" :src="federal_image" alt="icon" />
                        Federal Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/private-commercial" class="nav-link" :class="commercial_active">
                        <img class="icon" :src="commercial_image" alt="icon" />
                        Private / Commercial
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/international-opportunities" class="nav-link" :class="international_active">
                        <img class="icon" :src="international_image" alt="icon" />
                        International Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/documents" class="nav-link" :class="document_active">
                        <img class="icon" :src="document_image" alt="icon" />
                        Document Search
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            state_active:'active',
            federal_active:'',
            commercial_active:'',
            international_active:'',
            document_active:'',
            state_image:'/assets/icons/statewhite.svg',
            federal_image:'/assets/icons/federalwhite.svg',
            commercial_image:'/assets/icons/privatewhite.svg',
            international_image:'/assets/icons/internationalwhite.svg',
            document_image:'/assets/icons/documentwhite.svg'
        }
    },

    mounted(){
        if(this.$route.name == 'state_opportunities'){
            this.state_active = 'active'
            this.federal_active = ''
            this.commercial_active = ''
            this.international_active = '',
            this.document_active = ''
            this.state_image = '/assets/icons/stateblue.svg'
        }else if(this.$route.name == 'federal_opportunities'){
            this.state_active = ''
            this.federal_active = 'active',
            this.commercial_active = '',
            this.international_active = '',
            this.document_active = ''
            this.federal_image = '/assets/icons/federalblue.svg'
        }else if(this.$route.name == 'private_opportunities'){
            this.state_active = ''
            this.federal_active = '',
            this.commercial_active = 'active',
            this.international_active = '',
            this.document_active = ''
            this.commercial_image = '/assets/icons/privateblue.svg'
        }else if(this.$route.name == 'international_opportunities'){
            this.state_active = ''
            this.federal_active = '',
            this.commercial_active = '',
            this.international_active = 'active',
            this.document_active = ''
            this.international_image = '/assets/icons/internationalblue.svg'
        }else{
            this.state_active = ''
            this.federal_active = '',
            this.commercial_active = '',
            this.international_active = '',
            this.document_active = 'active'
            this.document_image = '/assets/icons/documentblue.svg'
        } 


    }
}
</script>