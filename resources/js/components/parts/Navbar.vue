<template>
    <div>
        <div class="v-nav container-fluid  mb-2 color-white">
            <div class="row text-white p-3">
                <div class=" col-md-10">
                    <h4>{{currentTime|toCurrentTime}}</h4>
                </div>
                <div class="col-md-2 user-icon">
                    <div class="dropdown">
                        <a class="btn btn-user dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                            Your name
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</template>

<script>
import toCurrentTime from '../../filters/getCurrentTime'
import moment from "moment/moment";

export  default {
    data() {
        return{
            currentTime:new Date().getFullYear()
        }
    },
    filters:{
        toCurrentTime
    },


    created() {
        this.getCurrentTime();
        setInterval(this. getCurrentTime, 1000);
    },
    methods: {
        getCurrentTime: function () {

            this.currentTime = moment().format('MMMM Do YYYY, h:mm:ss a');
        }
    }
}
</script>


<style scoped>
.v-nav{
    background-color: #ff9900;
}
.user-icon{
    display: flex;
    justify-content: center;
}

.dropdown{
    background-color: #7f4c00;
}

.btn-user{
    background-color: #7f4c00;
    color: #ffffff;
}


</style>

