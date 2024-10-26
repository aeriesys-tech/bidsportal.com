<template>
    <div class="regions">
        <div class="container-fluid justify-content-center pt-3">
            <ul class="nav nav-tabs nav-justified">
                <li class="nav-item">
                    <router-link to="/bids/federal-opportunities" class="nav-link active">
                        <img class="icon" src="@/assets/icons/federalblue.svg" alt="icon" />
                        Federal Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/state-opportunities" class="nav-link">
                        <img class="icon" src="@/assets/icons/statewhite.svg" alt="icon" />
                        State Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/private-commercial" class="nav-link">
                        <img class="icon" src="@/assets/icons/privatewhite.svg" alt="icon" />
                        Private / Commercial
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/international-opportunities" class="nav-link">
                        <img class="icon" src="@/assets/icons/internationalwhite.svg" alt="icon" />
                        International Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/documents" class="nav-link">
                        <img class="icon" src="@/assets/icons/documentwhite.svg" alt="icon" />
                        Document Search
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>