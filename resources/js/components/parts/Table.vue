<template>
    <div>
        <v-modal
            v-show="modalShow"
            :edit="edit"
            :name="post.name"
            :email="post.email"
            :address="post.address"
            :postId="post.id"
            :modalBtnName="modalBtnName"
            :modalTitle="modalTitle"
            @updated="closeModal()"
        ></v-modal>
        <div class="container mt-4 table-responsive">
            <div class="row">
                <div class="col-md-9">
                    <h3>Contacts</h3>
                </div>
                <div class="col-md-3 col-btn-create">
                        <button v-if="allCheckboxChecked"  type="button" class="btn btn-add-user btn-danger">
                            <i class="fas fa-trash-alt"></i>
                            Delete all
                        </button>
                    <button @click="preparationCreateContact" type="button" class="btn btn-add-user btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        Add contact
                    </button>
                </div>
            </div>
            <table class="table table-sm">
                <thead>
                <tr>
               <th class="th-item"><input  v-on:change="allCheckboxChecked=!allCheckboxChecked"  type="checkbox"   ></th>
                    <th class="th-item"></th>
                    <th class="th-item" scope="col">Name</th>
                    <th class="th-item" scope="col">Email</th>
                    <th class="th-item" scope="col">Address</th>
                    <th class="th-item" scope="col">Created</th>
                    <th scope="col">
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="post in posts" :key="post.id">
                    <td><input v-model="allCheckboxChecked"  type="checkbox" disabled="disabled"></td>
                    <td class="close-square">
                        <i class="far fa-window-close"></i>
                    </td>
                    <td><a href="#">{{ post.name }}</a></td>
                    <td>{{ post.email }}</td>
                    <td>{{ post.address }}</td>
                    <td>{{ getTime(post.created_at) }}</td>
                    <td>
                        <div>
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li class="dropdown-menu-item">
                                        <a class="dropdown-item" @click="preparationUpdateContact(post)" href="#">
                                            <i class="fas fa-bars"></i>
                                            View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" @click="deletePost(post.id)" href="#">
                                            <i style="color:red" class="fas fa-times"></i>
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>


    </div>
</template>

<script>
import moment from "moment/moment";
export default {
    data() {
        return {
            posts: [],
            post: {
                id: '',
                name: '',
                address: '',
                email: ''
            },
            postId: '',
            edit: false,
            modalShow: false,
            loading: false,
            modalBtnName: '',
            modalTitle: '',
            maineCheckboxChecked:'',
            allCheckboxChecked:false

        }
    },
    mounted() {
        this.getData()
    },

    methods: {
        getData() {
            axios
                .get('/api')
                .then(response => {
                    this.posts = response.data
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
        },

        deletePost(id) {
            axios
                .head(`/api/delete/${id}`)
                .then(response => {
                    this.getData()
                })
                .catch(error => console.log(error))
                .finally()
        },

        preparationUpdateContact(post) {
            this.post.name = post.name;
            this.post.email = post.email;
            this.post.address = post.address;
            this.post.id = post.id;
            this.edit = true;
            this.modalShow = true
            this.edit = true
            this.modalBtnName = 'Save Changes'
            this.modalTitle = 'Update Contact'

        },

        preparationCreateContact() {
            this.modalShow = true
            this.edit = false
            this.modalBtnName = 'Add contact'
            this.modalTitle = 'Create Contact'
        },
        closeModal() {
            this.post.name = '';
            this.post.email = '';
            this.post.address = '';
            this.post.id = '';
            this.edit = false
            this.modalShow = false
            this.getData()
        },

        getTime(date) {
          return moment().startOf('minute').from(date);
        }
    }
}

</script>

<style scoped>

* {
    font-family: 'Nunito', sans-serif;
}

.col-btn-create{
    display: flex;
    justify-content: space-between;
    flex-direction: row-reverse;
}

.table-responsive {
    border: solid 2px #1c1c1c;
    padding: 20px;
}

tbody {
    color: #9e9e9e;
}

.btn-add-user {
    color: #ffffff;
}

.th-item {
    color: #9e9e9e;
}

.dropdown-menu {
    border: solid 1px #000000;
}

.dropdown-menu-item {
    border-bottom: solid 1px #000000;
}

.btn-group {
    color: black;
}

.close-square {
    color: black;
}

</style>
