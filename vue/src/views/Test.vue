<template>
    <section class="">
        <div class="container h-100 d-flex px-0 px-sm-4">
            <div class="row justify-content-center align-items-center m-auto">
                <div class="col-12">
                    <div class="bg-mode shadow rounded-3 overflow-hidden">
                        <div class="row g-0">
                            
                            <div class="col-lg-12">
                                <ul id="demo">
                                    <TreeItem
                                        class="item"
                                        :item="treeData"
                                        @selectedItems="selectedItems"
                                        @selectedChildItems = "selectedChildItems"
                                    >
                                    </TreeItem>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import TreeItem from "@/components/TreeItem.vue";
export default {
    components: { TreeItem },
    data() {
        return {
            treeData: {
                name: "NAICS CODE",
                children: [],
            },
            selectedNaicses:[],
            childItems:[],
            errors:[]
        }
    },
    mounted(){
        this.getNaics()
    },
    methods:{
        selectedItems(selected){
            this.selectedNaicses = selected
            console.log("Parent: " +this.selectedNaicses)
        },
        selectedChildItems(childItems){
            this.childItems = childItems
            console.log("Parent:")
            console.log(childItems)
        },
        getNaics(){
            let vm = this;
            vm.$store.dispatch("post", { uri: "getNaics" })
            .then(function (response) {
                console.log(response.data.data)
                vm.treeData.children = response.data.data
            })
            .catch(function (error) {
                vm.errors = error.response.data.errors;
                vm.$store.dispatch("error", error.response.data.message);
            });
        }
    }
}
</script>
