<template>
    <div :class="[isOpen ? 'search search-open' : 'search']" class="dropdown-container">
        <div class="search-inner">
            <input class="form-control form-control-sm search-selected" 
                ref="toggle" 
                :tabindex="tabindex"
                :value="selectedText"
                :class="customClass"
                @click="onToggle"
                @keydown="onKey"
            >
            <transition name="fade" mode="out-in">
                <div class="state-search-dropdown" v-if="isOpen">
                    <div class="search-input_wrap">
                        
                        <input type="text" class="form-control form-control-sm search-input" autocomplete="off" placeholder="Search..."
                            ref="search" @blur="onBlur"
                            @input="onSearch"
                            @keydown.esc="onEsc"
                            @keydown.up="onUpKey"
                            @keydown.down="onDownKey"
                            @keydown.enter="onEnterKey"
                        >
                    </div>
                    <table class="table table-responsive-sm table-bordered table-striped table-sm search-list" v-if="results && results.length">
                        <tbody>
                            <tr class="search-item" v-for="(result, index) in results" @mousedown.prevent="select(result)" @mouseover.prevent="onMouse(index)" :class="['search-link', selectIndex === index ? 'search-active':'']" :key="index">
                               
                                <td>
                                {{ result[label] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </transition>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: {
            customClass: {
                default: ''
            },
            initialize: {
                default: null
            },
            id: {
                default: null
            },
            label: {
                default: null
            },
            placeholder: {
                default: "Select One"
            },
            data:{
                default:null
            },
            tabindex: {
                default: 0
            }
        },
        data () {
            return {
                selectIndex: -1,
                isOpen: false,
                search: '',
                results: [],
                query: {
                    search: ''
                },
                temp:[],
            }
        },
        computed: {
            selectedText() {
                let vm =this;
                if(vm.initialize) {
                    let result = vm.data.filter(function (el) {
                        return el[vm.id]==vm.initialize
                    });
                    if(result && result.length!=0) {
                        return result[0][vm.label]
                    }
                    else {
                        return vm.placeholder;
                    }
                }
                else {
                    return vm.placeholder;
                }
            }
        },
        
        methods: {
            focus: function () {
                this.$refs.toggle.focus()
            },

            onToggle() {
                if(this.isOpen) {
                    this.isOpen = false
                } else {
                    this.open()
                }
            },
            onKey(e) {
                const KeyCode = e.KeyCode || e.which
                if(!e.shiftKey && KeyCode !== 9 && !this.isOpen) {
                    this.open()
                }
            },
            open() {
                this.fetchData('')
                this.isOpen = true
                this.$nextTick(() => {
                    this.$refs.search.focus()
                })
            },
            fetchData(query) {
                let vm = this;
                if(query=="") {
                    vm.results = vm.data;
                }
                else {
                    vm.results = vm.data.filter(function (el) {
                        return el[vm.label].toLowerCase().includes(query.toLowerCase())
                    });
                
                }
            },
            onBlur() {
                this.close()
            },
            onEsc() {
                this.close()
            },
            close() {
                this.results = []
                this.isOpen = false
                this.search = ''
                this.selectIndex = -1
            },
            onSearch(e) {
                const q = e.target.value
                this.selectIndex = 0
                this.fetchData(q)
            },
            onUpKey() {
                if(this.selectIndex > 0) {
                    this.selectIndex--
                }
            },
            onDownKey() {
                if(this.results.length - 1 > this.selectIndex) {
                    this.selectIndex++
                }
            },
            onEnterKey() {
                const found = this.results[this.selectIndex]
                if(found) {
                    this.select(found)
                }
            },
            select(result) {
                console.log(result)
                console.log(this.id)
                this.$emit('input', result[this.id])
                this.close()
            },
            onMouse(index) {
                this.selectIndex = index
               
             
            }
         }
    }
</script>

<style>
    .search {
      position: relative;
      display: block;
      background: #fff;
    }

    .search-open {
      border-bottom: 0;
    }

    .search-open .form-control {
        background: #fff;
        -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        border: 1px solid #f2f2f2;
    }

    .search-inner {
        position: relative;
    }

    .search-selected {
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        display: -webkit-box !important;
        display: -ms-flexbox !important;
        display: flex !important;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        line-height: 15px;
    }

    .state-search-dropdown {
        width: 150%;
        position: absolute;
        z-index:10000 !important;
        padding: 5px;
        background: #fff;
        border-right: 1px solid #f2f2f2;
        border-left: 1px solid #f2f2f2;
        -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        overflow-y: scroll !important;
        max-height: 300px !important;       
    }

    .search-input {
      line-height: 13px;
      font-size: 13px;
      background: #fafafa;
      border: none;
      min-height: 10px !important;
      border-radius: 1px;
      -webkit-box-shadow: inset 0 1px 1px 0 rgba(0, 0, 0, 0.1);
              box-shadow: inset 0 1px 1px 0 rgba(0, 0, 0, 0.1);
      padding: 4px 4px;
      width: 100%;
      display: block;
     
    }

    .search-input:focus {
      outline-style: dotted;
      outline-width: 1px;
      outline-offset: 1px;
    }

    .search-input_wrap {
      position: relative;
    }

    .search-list {
      /* display: block; */
      margin: 0;
      padding: 0;
    }

    .search-link {
      cursor: pointer;
      padding: 2px;
      background: #fff;
    }

    .search-active {
      background: #3aa3e3 !important;
      color: #fff;
    }

    .search-list td, th { 
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow:ellipsis; 
    }
</style>