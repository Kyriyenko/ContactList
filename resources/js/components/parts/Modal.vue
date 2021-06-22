<template>
    <div>
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="container modal-container">
                    <div class="row">
                        <div class="col">
                            <h3>{{ modalTitle }}</h3>
                            <div class="input-row">
                                <h5>Name</h5>
                                <input class="modal-input" v-model="userName" type="text"  placeholder="Please enter your name" aria-describedby="emailHelp">
                            </div>
                            <div class="input-row">
                                <h5>Email</h5>
                                <input class="modal-input" v-model="userEmail" type="text"  placeholder="test@domain.com" aria-describedby="emailHelp">
                            </div>
                            <div class="input-row">
                                <h5>Address</h5>
                                <input class="modal-input" v-model="userAddress" type="text"  placeholder="New Channel name"  aria-describedby="emailHelp">
                            </div>
                            <div class="alert-box">
                                <div v-if="requestStatus===false">
                                    <div  v-for="(error,item) in messageFromServer"   class="alert alert-danger" role="alert">
                                       {{error.toString()}}
                                    </div>
                                </div>
                                <div v-if="requestStatus===true">
                                    <div  class="alert alert-success" role="alert">
                                       {{messageFromServer}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="item-row">
                                <button  @click="$emit('updated')" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="picture-box">
                                <i style="font-size: 190px; " class="far fa-window-close"></i>
                            </div>
                            <div class="btn-box">
                                <button  @click="isUpdateOrCreateContact" type="button" class="btn btn-primary">
                                    <i class="fas fa-check"></i>
                                    {{modalBtnName}}
                                </button>
                                <button @click="$emit('updated')" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name: 'modal',
    props: ['edit', 'name', 'email', 'address', 'postId','modalBtnName','modalTitle'],
    data() {
        return {
            isUpdated: false,
            isCreated: false,
            validateErrors: [],
            userName: '',
            userEmail: '',
            userAddress: '',
            userPostId: '',
            isCorrectData:'',
            messageFromServer:[],
            requestStatus:''
        }
    },

    watch: {
        'name': function (value, oldValue) {
            this.userName = value;
        },
        'email': function (value, oldValue) {
            this.userEmail = value;
        },
        'address': function (value, oldValue) {
            this.userAddress = value;
        },
        'postId': function (value, oldValue) {
            this.userPostId = value;
        },
    },

    methods: {
        isUpdateOrCreateContact(){
            let dataObject = {
                name: this.userName,
                email: this.userEmail,
                address: this.userAddress,
                id: this.userPostId
            };

            if(this.validateErrors.length<1){
                if(this.edit)
                    this.updateData(dataObject)
                else
                    this.addData(dataObject)
            }
        },

        updateData(dataObject){
                axios
                    .post(`api/edit`,dataObject)
                    .then(response => {
                        this.requestStatus=response.data.status
                        if(this.requestStatus===false) {
                            this.messageFromServer=response.data.errors
                        }

                        if(this.requestStatus===true){
                            this.messageFromServer=response.data.message
                        }

                        setTimeout(()=>this.requestStatus='', 2000);
                        this.isUpdated=true
                    })
                    .catch(error => console.log(error))
                    .finally()
        },

        addData(dataObject) {
                axios
                    .post('api/posts', dataObject)
                    .then(response => {
                        this.requestStatus=response.data.status
                        if(this.requestStatus===false) {
                            this.messageFromServer=response.data.errors
                        }

                        if(this.requestStatus===true){
                            this.messageFromServer=response.data.message
                            this.userName=''
                            this.userEmail=''
                            this.userAddress=''
                        }

                        setTimeout(()=>this.requestStatus='', 2000);
                        this.isCreated = true
                    })
                    .catch(error => console.log(error))
                    .finally()
        },

        validation(name,email,address){
            let regEmailCheck=/^[^]+@[^ ]+\.[a-z]{2,3}$/;
            let regNumCheck=/[0-9]/;
            this.validateErrors = []
            this.isCorrectData=true
            if(name===''||email===''||address===''){
                this.validateErrors.unshift('all fields are required')
                this.isCorrectData=false
                return;
            }
            if(!email.match(regEmailCheck))
                this.validateErrors.unshift('invalid field email');
                this.isCorrectData=false
            if(regNumCheck.test(name)){
                this.validateErrors.unshift('invalid field name');
                this.isCorrectData=false
            }
        },
    },

}
</script>

<style scoped>

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

.modal-input{
    width: 290px;
}

.modal-container{
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
    width: 800px;
    min-height: 350px;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    background-color: #ffffff;
    padding: 10px;
    border-radius: 10px;
    z-index: 100;
}

.input-row{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
}

.item-row{
    display: flex;
    flex-direction: row-reverse;
}

.picture-box{
    margin-top: 15px;
    height: 250px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.btn-box{
    display: flex;
    flex-direction: row-reverse;
    padding-right: 45px;
}

button{
    margin-right: 20px;
}

</style>
