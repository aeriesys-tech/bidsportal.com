<template>
    <div class="catalog-list-wrap">
        <div style="overflow: hidden; width: 100%; height: 100%;">
            <div style="">
                <div class="catalog-list cv-catalog-list">
                    <div class="cc-catalog-list__item">
                        <div class="cv-catalog-list-item cv-catalog-list-item__level_1 has-checkboxes d-flex">
                            <label class="cv-catalog-list-item__label-checkbox">
                                <input type="checkbox" class="cv-catalog-list-item__checkbox me-2" />
                            </label>
                            <div class="cv-catalog-list-item__expand-button">
                                <span class="cv-expand-button">
                                    <i class="fa fa-minus-circle me-2" aria-hidden="true"></i>
                                </span>
                            </div>

                            <div class="cv-catalog-list-item__code">
                                <div class="catalog-code">
                                    <div class="catalog-code__id is-disabled">
                                        <span class="catalog-code__number" style="font-size: 12px; margin-left: 5px;">Select All</span>
                                    </div>
                                </div>
                            </div>
                            <a class="cv-catalog-list-item__title cv-catalog-list-item__link">
                                <span autoescape="true">
                                    &emsp;&emsp;&emsp;&emsp;
                                </span>
                            </a>
                        </div>
                        <ul>
                            <div style="margin-top: 5px;">
                                <div data-v-23d9fd7e="">
                                    <div class="catalog-list cv-catalog-list" data-v-23d9fd7e="">
                                        <div class="cc-catalog-list__item" data-v-23d9fd7e="">
                                            <div class="cv-catalog-list-item cv-catalog-list-item__level_1 has-checkboxes" data-v-23d9fd7e="" v-for="n in 10" :key="n">
                                                <label class="cv-catalog-list-item__label-checkbox" data-v-23d9fd7e="">
                                                    <input type="checkbox" class="cv-catalog-list-item__checkbox" data-v-23d9fd7e="" style="font-size: 13px;" />
                                                    <span class="cv-catalog-list-item__fake-checkbox" data-v-23d9fd7e="" style="font-size: 13px;"></span>
                                                </label>
                                                <div class="cv-catalog-list-item__expand-button" data-v-23d9fd7e="">
                                                    <span class="cv-expand-button" data-v-23d9fd7e=""><i class="fa fa-plus-circle" aria-hidden="true" data-v-23d9fd7e="" style="font-size: 13px;"></i></span>
                                                </div>
                                                <div class="cv-catalog-list-item__code" data-v-23d9fd7e="">
                                                    <div class="catalog-code sub1" data-v-23d9fd7e="">
                                                        <div class="catalog-code__id is-disabled" data-v-23d9fd7e="">
                                                            <span class="catalog-code__number" data-v-23d9fd7e="" style="font-size: 12px; margin-left: 5px;">&emsp;&emsp;&emsp; </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="cv-catalog-list-item__title cv-catalog-list-item__link" data-v-23d9fd7e="">
                                                    <span autoescape="true" data-v-23d9fd7e="">
                                                        <div data-v-23d9fd7e="">
                                                            <span class="sub1 hovertext" style="color: rgb(89, 93, 110); font-size: 14px;">
                                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;
                                                            </span>
                                                        </div>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div data-v-23d9fd7e="" style="position: absolute; height: 6px; right: 2px; bottom: 2px; left: 2px; border-radius: 3px;">
                                    <div class="custom-scroll-thumb" data-v-23d9fd7e="" style="visibility: hidden; width: 0px;"></div>
                                </div>
                                <div data-v-23d9fd7e="" style="position: absolute; width: 6px; right: 2px; bottom: 2px; top: 2px; border-radius: 3px;">
                                    <div
                                        class="custom-scroll-thumb"
                                        data-v-23d9fd7e=""
                                        style="position: initial; display: block; width: 5px; background-color: var(--accent); cursor: pointer; border-radius: inherit; height: 146px; transform: translateY(0px);"
                                    ></div>
                                </div>
                            </div>
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

<style scoped>
    .sub1 {
        height: 16px;
        border-radius: 2px;
        background: rgba(130, 130, 130, 0.2);
        background: -webkit-gradient(linear, left top, right top, color-stop(8%, rgba(130, 130, 130, 0.2)), color-stop(18%, rgba(130, 130, 130, 0.3)), color-stop(33%, rgba(130, 130, 130, 0.2)));
        background: linear-gradient(to right, rgba(130, 130, 130, 0.2) 8%, rgba(130, 130, 130, 0.3) 18%, rgba(130, 130, 130, 0.2) 33%);
        background-size: 800px 100px;
        animation: wave-lines 2s infinite ease-out;
    }

    @keyframes pulse-bg {
        0% {
            background-color: #eee;
        }
        50% {
            background-color: #eaeaea;
        }
        100% {
            background-color: #eee;
        }
    }

    @keyframes wave-lines {
        0% {
            background-position: -468px 0;
        }
        100% {
            background-position: 468px 0;
        }
    }

    .catalog-code {
        display: inline-flex;
        justify-content: space-between;
        flex-shrink: 0;
        min-width: 65px;
        height: 17px;
        font-size: 12px;
        background-color: #ececec;
        transition-property: color, background-color;
        transition-duration: 0.3s;
        cursor: default;
    }
</style>
