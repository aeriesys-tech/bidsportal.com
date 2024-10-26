<template>
    <div class="card shadow mb-2" v-for="i in 10" :key="i">
        <div class="card-body py-md-2 d-flex flex-column h-100 position-relative" id="hovershadow">
            <div class="d-flex justify-content-between align-items-center">
                <strong class="card-title mb-1">
                    <div>
                        <a href="javascript:vodi(0)" style="text-transform: uppercase;"></a>
                    </div>
                </strong>
            </div>
            <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                <li class="nav-item"><img class="small w-15px me-1" src="" /><span class="sub1">&emsp;&emsp;&emsp;&emsp;</span></li>
                <li class="nav-item"><img class="small w-15px me-1" src="" /><span class="sub1">&emsp;&emsp;&emsp;&emsp;</span></li>
                <li class="nav-item"><img class="small w-15px me-1" src="" /><span class="sub1">&emsp;&emsp;&emsp;&emsp;</span></li>
                <li class="nav-item">
                    <img class="small w-15px me-1" src="" /><span class="sub1">&emsp;&emsp;&emsp;&emsp;</span>
                    <span class="col-red"><span class="sub1">&emsp;&emsp;</span></span>
                </li>
            </ul>
            <ul class="list-group list-group-borderless small mb-2 mt-2">
                <li class="list-group-item d-flex text-success p-0">
                    <p class="limited-text" style="color: #595d6e; text-align: justify;"></p>
                </li>
            </ul>
            <div class="border-top d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                <div class="d-flex align-items-center">
                    <ul class="nav nav-divider small mt-3" style="color: #595d6e;">
                        <li class="nav-item text-primary"><span class="sub1">&emsp;&emsp;&emsp;&emsp;</span></li>
                        <li class="nav-item"><span class="sub1">&emsp;&emsp;&emsp;&emsp;</span>, <span class="sub1">&emsp;&emsp;&emsp;&emsp;</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .nav.nav-divider .nav-item + .nav-item:before {
        content: "";
        color: inherit;
        padding-left: 0.65rem;
        padding-right: 0.75rem;
        opacity: 0.8;
    }
    .w-15px {
        width: 15px;
    }
    p {
        width: 80%;
        height: 16px;

        border-radius: 2px;
        background: rgba(130, 130, 130, 0.2);
        background: -webkit-gradient(linear, left top, right top, color-stop(8%, rgba(130, 130, 130, 0.2)), color-stop(18%, rgba(130, 130, 130, 0.3)), color-stop(33%, rgba(130, 130, 130, 0.2)));
        background: linear-gradient(to right, rgba(130, 130, 130, 0.2) 8%, rgba(130, 130, 130, 0.3) 18%, rgba(130, 130, 130, 0.2) 33%);
        background-size: 800px 100px;
        animation: wave-lines 2s infinite ease-out;
    }
    .card-title {
        width: 250px;
        height: 24px;
        border-radius: 2px;
        background: rgba(130, 130, 130, 0.2);
        background: -webkit-gradient(linear, left top, right top, color-stop(8%, rgba(130, 130, 130, 0.2)), color-stop(18%, rgba(130, 130, 130, 0.3)), color-stop(33%, rgba(130, 130, 130, 0.2)));
        background: linear-gradient(to right, rgba(130, 130, 130, 0.2) 8%, rgba(130, 130, 130, 0.3) 18%, rgba(130, 130, 130, 0.2) 33%);
        background-size: 800px 100px;
        animation: wave-lines 2s infinite ease-out;
    }
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
</style>
