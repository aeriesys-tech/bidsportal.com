<template>

    <div class="catalog-list-wrap">
<!--  -->
        <div style=" overflow: hidden; width: 100%; height: 100%;">
            <div style="">
                <div class="catalog-list cv-catalog-list">
                  
                    <div class="cc-catalog-list__item">
                        <div class="cv-catalog-list-item cv-catalog-list-item__level_1 has-checkboxes" >
                            <label class="cv-catalog-list-item__label-checkbox"><input type="checkbox" class="cv-catalog-list-item__checkbox" :value="item.naics_id" v-model="item.selected" @click="toggleSelectedItem(item)" /><span class="cv-catalog-list-item__fake-checkbox"></span></label>
                            <div class="cv-catalog-list-item__expand-button">
                               
                                <span v-if="item.children.length!=0" class="cv-expand-button">
                                    <span @click="toggle()" v-if="isOpen"><i class="fa fa-minus-circle" aria-hidden="true" style="font-size:13px" ></i></span>
                                    <span @click="toggle()" v-else><i class="fa fa-plus-circle" aria-hidden="true" style="font-size:13px" ></i></span>
                                </span>
                                                
                                
                            </div>
                          
                            <div class="cv-catalog-list-item__code">
                                <div class="catalog-code">
                                    <div class="catalog-code__id is-disabled">
                                        <span class="catalog-code__number" style="font-size:12px;">{{item.psc_code}}</span>
                                    </div>
                                </div>
                            </div>
                            <a class="cv-catalog-list-item__title cv-catalog-list-item__link">
                                <span autoescape="true" ><div v-html="highlight(item.name)"></div></span>
                            </a>
                            
                            <!-- <div class="cv-catalog-list-item__supplier-amount">
                                <a target="_blank" class="catalog-suppliers-amount" href="/search/suppliers/?&amp;filters=%7B%22offerings%22%3A%7B%22checked%22%3A%5B7498%5D%7D%7D">view 60+ suppliers</a>
                            </div> -->
                        </div>
                        <ul v-show="isOpen" v-if="isFolder">
                            <TreeItem
                                class="item"
                                v-for="(child, index) in item.children"
                                :key="index"
                                :item="child"
                                :tdr_psc="tdr_psc"
                                :search="search"
                                :clear_all_psc="clear_all_psc"
                            ></TreeItem>
                        </ul>
                    </div>
                   
                </div>
                 
            </div>
            
            <div style="position: absolute; height: 6px; right: 2px; bottom: 2px; left: 2px; border-radius: 3px;">
                <div class="custom-scroll-thumb" style="visibility: hidden; width: 0px;"></div>
            </div>
            <div style="position: absolute; width: 6px; right: 2px; bottom: 2px; top: 2px; border-radius: 3px;">
                <div class="custom-scroll-thumb" style="position: initial; display: block; width: 5px; background-color: var(--accent); cursor: pointer; border-radius: inherit; height: 146px; transform: translateY(0px);"></div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "TreeItem",
        props: {
            item: Object,
            tdr_psc:Array,
            search: String,
            clear_all_psc:Boolean
        },

        data() {
            return {
                isOpen: false,
                item_tdr_psc:[]
            }
        },

         watch: {
            "clear_all_psc": function () {
                this.item.selected = false
            },

            "$store.getters.selected_pscs": {
                handler() {
                    this.isSeletedItem();
                },
                immediate: true,
                deep: true,
            }
        },

        computed: {
            isFolder: function() {
                return this.item.children && this.item.children?.length;
            }
        },

        mounted(){
            if(!this.item.name)
                this.isOpen = true
        },
        methods: {
            
            isSeletedItem() {
                const selected_pscs = this.$store.getters.selected_pscs
                if (selected_pscs.length) {
                    this.item.selected = selected_pscs.includes(this.item.psc_id)
                } else {
                    this.item.selected = false
                }
            },

            highlight(name) {
                if(!this.search) {
                    return '<span class="hovertext" style="color: rgb(89, 93, 110);font-size:13px">'+name+'</span>'
                }
                name = name.replace(new RegExp(this.search, "gi"), match => {
                    
                    return '<span class="hovertext" style="background:yellow;color: rgb(89, 93, 110);font-size:13px">' + match + '</span>';
                });
                return name                
            },

            toggle: function() {
                if (this.isFolder) {
                    this.isOpen = !this.isOpen;
                }
            },
            toggleSelectedItem(item){
                item.selected = !item.selected
                // if(item.psc_code != 'PSC'){
                //     if (item.psc_code.match(/^[0-9]+$/)){
                //         this.pushParentCode('PSC')
                //         this.pushParentCode(item.psc_code.slice(0, 2))
                //     }else{
                //         this.pushParentCode(item.psc_code.slice(0, 1))
                //         this.pushParentCode(item.psc_code.slice(0, 2))
                //     }

                // }
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
            pushParentCode(parent_code){
                console.log(parent_code)
                let selected_psces = []
                selected_psces = this.$store.getters.selected_psces
                if(parent_code){
                    if(!selected_psces.includes(parent_code)){
                        selected_psces.push(parent_code)
                    }
                }else{
                    let psc = selected_psces.filter(function(element){
                        return element != parent_code
                    })
                    selected_psces = psc
                }
                this.$store.dispatch("setSelectedPsces", selected_psces)
            },
            pushSpliceItem(item){
                let psc_id = item.psc_id
                let selected_psces = []
                let selected_psc_items = []
                selected_psces = this.$store.getters.selected_psces
                selected_psc_items = this.$store.getters.selected_psc_items
                // selected_psc_items.push(item)
                if(item.selected){
                    if(!selected_psces.includes(psc_id)){
                        selected_psces.push(psc_id)
                    }
                }else{
                    let psc = selected_psces.filter(function(element){
                        return element != psc_id
                    })
                    selected_psces = psc
                    // if(selected_psces.includes(psc_code)){
                    //     selected_psces.splice(selected_psces.indexOf(psc_code), 1)
                    // }
                }
                this.$store.dispatch("setSelectedPsces", selected_psces)
                if(item.selected){
                    var index = selected_psc_items.findIndex(function(element) {
                        return element.psc_id == psc_id
                    });
                    if(index <= 0)
                        selected_psc_items.push(item)
                }else{
                    let naics = selected_psc_items.filter(function(element){
                        return element.psc_id !== psc_id
                    })
                    selected_psc_items = naics
                }
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
    min-width: 65px;
    height: 17px;
    font-size: 12px;
    background-color: #ececec;
    transition-property: color,background-color;
    transition-duration: .3s;
    cursor: default;
}

   /* govshop css */
    .cv-catalog-list-item__fake-checkbox:before {
    top: 1px;
    left: 0;
    width: 13px;
    height: 13px;
    border: 1px solid #cfd5e0;
    border-radius: 1px;
    transition-property: background-color,border-color;
    transition-duration: .3s;
}

.catalog-filter-modal__content .catalog-list-wrap {
    flex: 1 1;
}
.catalog-list-select-all {
    display: inline-block;
    position: relative;
    padding-left: 21px;
    margin-bottom: 10px;
}
.catalog.has-scrollbar .catalog-list {
    padding-bottom: 24px;
}
.catalog-filter-modal__content .catalog-list {
    padding-bottom: 20px;
}

.cv-catalog-list {
    padding-bottom: none;
}
.catalog-list-select-all__checkbox {
    display: none;
}
.catalog-list-select-all__button.button {
    position: static;
    cursor: pointer;
}
.button-text {
    border-bottom: 1px dotted var(--accent);
    color: var(--accent);
    padding: 0;
    transition-property: color,border-color;
    transition-duration: .3s;
}

.button_weight-regular {
    font-weight: 400;
}
.cv-catalog-list-item.has-checkboxes {
    padding-left: 41px;
}
.cv-catalog-list-item {
    position: relative;
    display: flex;
    padding-left: 20px;
    margin-bottom: 5px;
}
.cv-catalog-list-item__label-checkbox {
    display: inline-block;
    position: absolute;
    top: 1px;
    left: 0;
    width: 13px;
    height: 13px;
    cursor: pointer;
}
.cv-catalog-list-item.has-checkboxes .cv-catalog-list-item__expand-button {
    left: 21px;
}
.cv-catalog-list-item__expand-button {
    position: absolute;
    top: 6px;
    left: 0;
}
.cv-expand-button {
    position: relative;
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 11px;
    height: 11px;
    border-radius: 50%;
    border: 1px solid #9b9b9b;
    background: none;
    background-color: transparent;
    cursor: pointer;
    line-height: 1;
}
.cv-expand-button svg {
    width: 5px;
    height: 5px;
    line-height: 1;
    fill: #6b6b6b;
}

.icon {
    width: 1em;
    height: 1em;
}
.cv-catalog-list-item__code {
    margin-right: 8px;
}
.hovertext:hover{
    color:#40a4f1!important
}
.ex3 {
  background-color: lightblue;
 
  height: 110px;
  overflow: auto;
}
.cv-catalog-list-item__fake-checkbox:before {
    top: 1px;
    left: 0;
    width: 13px;
    height: 13px;
    border: 1px solid #cfd5e0;
    border-radius: 1px;
    transition-property: background-color,border-color;
    transition-duration: .3s;
}
.cv-catalog-list-item__title, .cv-catalog-list-item__link{
        color: rgb(89, 93, 110);
        font-size: 13px;
    }
</style>