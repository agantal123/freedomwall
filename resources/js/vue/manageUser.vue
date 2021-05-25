<template>
<div class="flex flex-wrap">   
    <div class="w-full lg:w-4/12 h-1/3 shadow overflow-hidden border border-gray-200 p-3 m-3 lg:pr-2">
            <h2 class="mb-3"><b>Add new user</b></h2>
                <form @submit.prevent="saveUser">
                    <div class="mt-4">
                       <label class="block text-sm font-medium leading-relaxed tracking-tighter text-gray-700">Username</label>
                       <input v-model="form.username" type="text" placeholder="Username " minlength="8"
                        class="w-full px-4 py-2 text-base text-black transition duration-500 ease-in-out transform bg-white-300 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 "
                        autofocus autocomplete required>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium leading-relaxed tracking-tighter text-gray-700">Password</label>
                        <input v-model="form.password" type="password" placeholder="Password" minlength="6"
                        class="w-full px-4 py-2 text-base text-black transition duration-500 ease-in-out transform bg-white-300 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 "
                        required>
                    </div>
                    <div class="mt-4">
                       <label class="block text-sm font-medium leading-relaxed tracking-tighter text-gray-700">Re-enter password</label>
                       <input v-model="form.password_confirmation" type="password" placeholder="Re-enter Password" minlength="6"
                       class="w-full px-4 py-2 text-base text-black transition duration-500 ease-in-out transform bg-white-300 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 "
                        required>
                    </div>
                        <div class="flex flex-row-reverse m-4">
                            <button type="submit"
                             class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                                 Add user
                            </button>
                        </div>
                 </form>
    </div>

    <div class="w-full lg:w-7/12 shadow overflow-hidden border border-gray-200 p-5 m-3 lg:pr-2">
         <h2 class="mb-3"><b>List of all users</b></h2>
            <form @submit.prevent="searchUser">
            <input type="text" placeholder="Search user..." v-model="searchdata" class="w-1/3 my-3 text-base text-black transition duration-500 ease-in-out transform bg-white-300 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2" >
            <button type="submit" class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline">Search</button>
            </form>
        <table id="myTable" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
					<thead class="bg-gray-50">
						<tr>
							<th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" data-priority="1">User ID</th>
							<th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" data-priority="2">Username</th>
                            <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" data-priority="3">Created on</th>
							<th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" data-priority="4">Action</th>
						</tr>
					</thead>
					<tbody class="bg-white text-xs divide-y divide-gray-200">
						<tr v-for="user in users.data" :key="user.id">
							<td class="px-2 py-4 whitespace-nowrap">{{user.id}}</td>
							<td class="px-2 py-4 whitespace-nowrap">{{user.username}}</td>
                            <td class="px-2 py-4 whitespace-nowrap">{{user.created_at | moment("MMMM Do YYYY, h:mm a")}}</td>
                            <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500">
									<div class="flex justify-start space-x-1">
                                        <router-link :to="{name: 'viewuser', params: {id: user.id}}">
                                            <button class="border-2 border-indigo-200 rounded-md p-1" >
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
											</svg>
										</button>
                                        </router-link>
										
										<button class="border-2 border-red-200 rounded-md p-1"  @click="deleteUser(user.id)">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-red-500">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
											</svg>
										</button>
									</div>
							</td>
						</tr>
					</tbody>
	    </table>
             <pagination class="flex flex-row m-2" :data="users" @pagination-change-page="getUser"></pagination>
	</div>
</div>

</template>

<script>
export default {
    data() {
            return {
                form: new Form({
                    username: '',
                    password: '',
                    password_confirmation: ''
                }),
                users: {},
                dataz: 1,
                searchdata: '',
                search_user:'',
            }
        },
        methods: {
            saveUser() {
                if(this.form.password != this.form.password_confirmation)
                {
                     Swal.fire({
                            icon: 'error',
                            text: 'Password does not match!',
                            })
                }
                else
                {
                    let data = new FormData();
                    data.append('username', this.form.username)
                    data.append('password', this.form.password)
                    data.append('password', this.form.password_confirmation)
                    axios.post('/manageuserData', data)
                    .then((response) =>
                    {
                       if(response.data == 'user already exists!')
                       {
                           Swal.fire({
                            icon: 'error',
                            text: 'Username already exists!',
                            })
                       }
                       else
                       {
                            this.form.reset(),   
                            this.getUser(),
                            Swal.fire({
                                    icon: 'success',
                                    text: 'User successfully added',
                                    })
                       }
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)  
                }
            },
             getUser(page = 1)
            {
                axios.get('/manageuserData?page=' + page).then((response) => 
                    {
                        this.users = response.data
                      //  console.log(this.users)
                    }).catch((error) => 
                    {
                        console.log(error)
                    })
                    
            },
            deleteUser(id)
            {
                Swal.fire({
                    text: "delete user id: " + id + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f47f7f',
                    cancelButtonColor: '#aeb0b4',
                    confirmButtonText: 'Delete'
                    }).then((result) => {
                        if (result.value == true){
                             axios.delete(`manageuserData/${id}`)
                              .then(response => {
                           // console.log(response)
                            this.getUser()
                        });
                            Swal.fire(
                                {
                                icon: 'success',
                                text: 'User successfully removed!',
                                }
                            )
                        } 
                        else 
                        {
                         result.dismiss;
                        }
                    })
            },
            viewUserprofile(id)
            {
                // axios.get(`userpage/${id}`)
                // .then((response) => {
                //     console.log(response)
                // })
                axios.get(route('viewuserpage', id));
            },

            searchUser()
            {
                if(this.searchdata == '')
                {
                    this.getUser();
                    this.searchdata = '';
                }
                else
                {
                 axios.post('/searchUser',{searchdata:this.searchdata}).then((response) =>
                    {
                         this.users = response.data
                         this.searchdata = '';
                        //console.log(response.data)
                    }
                ).catch((error) =>
                {
                    console.log(error)
                }
                )}
            },
        },

        mounted()
        {
            this.getUser()
        }   
}
</script>

       