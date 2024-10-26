<template>
    <div>
        <div>
            <input type="checkbox" :value="item.naics_id" v-model="item.selected" @click="toggleSelectedItem(item)">
            <span v-if="item.children.length!=0">
                <span @click="toggle" v-if="isOpen"><i class="fa fa-minus-circle" aria-hidden="true" style="padding:5px"></i></span>
                <span @click="toggle" v-else><i class="fa fa-plus-circle" aria-hidden="true" style="padding:5px"></i></span>
            </span>
            <span class ="catalog-code" style="background:#e7ebf2; padding-left:2px;padding-right:2px;">{{item.naics_code}}</span>
            <span class="hovertext" @click="toggleSelectedItem(item)" style="padding:5px">{{ item.name  }}</span>
        </div>
        <ul v-show="isOpen" v-if="isFolder">
            <TreeItem
                class="item"
                v-for="(child, index) in item.children"
                :key="index"
                :item="child"
                :tdr_naics="tdr_naics"
            ></TreeItem>
        </ul>
    </div>
</template>
<script>
    export default {
        name: "TreeItem",
        props: {
            item: Object,
            tdr_naics:Array
        },

        data() {
            return {
                isOpen: false,
                item_tdr_naics:[]
            }
        },
        watch: {
            "tdr_naics": function () {
                vm.item.selected = false
                // let vm = this
                // let selected_tdr_naics = vm.tdr_naics.filter(function(element){
                //     return element == vm.item.naics_id
                // })
                // if(selected_tdr_naics.length > 0)
                //     vm.item.selected = true
                // else
                //     vm.item.selected = false
            }
        },

        computed: {
            isFolder: function() {
                return this.item.children && this.item.children.length;
            }
        },
        mounted(){
            // console.log(this.item)
            // if(this.tdr_naics)
            //     console.log(this.tdr_naics)
        },
        methods: {
            toggle: function() {
                if (this.isFolder) {
                    this.isOpen = !this.isOpen;
                }
            },
            toggleSelectedItem(item){
                item.selected = !item.selected
                this.pushSpliceItem(item)
                this.setSelectedItem(item)
            },
            setSelectedItem(item){
                let vm = this
                if(item.children.length)
                {
                    item.children.map(function(element){
                        vm.toggleSelectedChildren(element, item.selected)
                    })
                }
            },
            pushSpliceItem(item){
                let naics_id = item.naics_id
                let selected_naicses = []
                let selected_naics_items = []
                selected_naicses = this.$store.getters.selected_naicses
                selected_naics_items = this.$store.getters.selected_naics_items
                // selected_naics_items.push(item)
                if(item.selected){
                    if(!selected_naicses.includes(naics_id)){
                        selected_naicses.push(naics_id)
                    }
                }else{
                    if(selected_naicses.includes(naics_id)){
                        selected_naicses.splice(selected_naicses.indexOf(naics_id), 1)
                    }
                }
                this.$store.dispatch("setSelectedNaics", selected_naicses)
                if(item.selected){
                    var index = selected_naics_items.findIndex(function(element) {
                        return element.naics_id == naics_id
                    });
                    if(index <= 0)
                        selected_naics_items.push(item)
                }else{
                    let naics = selected_naics_items.filter(function(element){
                        return element.naics_id !== naics_id
                    })
                    selected_naics_items = naics
                }
                // this.$store.dispatch("setSelectedNaicsItems", selected_naics_items)
            },
            toggleSelectedChildren(item, selected){
                item.selected = selected
                this.pushSpliceItem(item)
                this.setSelectedItem(item)
            },
        },
    };
</script>

<style scoped>
    .item {
        cursor: pointer;
    }
    .catalog-code {
    display: inline-flex;
    justify-content: space-between;
    flex-shrink: 0;
    min-width: 84px;
    height: 17px;
    font-size: 12px;
    background-color: #ececec;
    transition-property: color,background-color;
    transition-duration: .3s;
    cursor: default;
}
.hovertext:hover{
    color:#40a4f1
}
</style>