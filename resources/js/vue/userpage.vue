<template>
<div class="flex flex-wrap"> 

    <div class="w-full lg:w-4/12 p-5 m-1 lg:pr-1">
      <div class="bg-white rounded">
        <div class="py-4 px-6">
            <h1 class="text-2xl font-semibold text-gray-800">USER INFO</h1>
            <div class="flex items-center mt-5 text-gray-700">
                <h1 class="px-2 text-sm">User ID: <b>{{this.id}}</b></h1>
            </div>
            <div class="flex items-center mt-5 text-gray-700">
                <h1 class="px-2 text-sm">Username: <b>{{this.username}}</b></h1>
            </div>
            <div class="flex items-center mt-5 text-gray-700">
                <h1 class="px-2 text-sm">Joined on: <b>{{ this.dateCreated | moment("MMMM Do YYYY, h:mm A") }}</b></h1>
            </div>

            <h1 class=" mt-10 text-2xl font-semibold text-gray-800">USER ACTIVITES</h1>
            <div class="flex items-center mt-5 text-gray-700">
                <h1 class="px-2 text-sm">Total posts: <b>{{this.totalpost}}</b></h1>
            </div>
            <div class="flex items-center mt-5 text-gray-700">
                <h1 class="px-2 text-sm">Total approved posts: <b>{{this.useractivities_totalapprovedPost}}</b></h1>
            </div>
            <div class="flex items-center mt-5 text-gray-700">
                <h1 class="px-2 text-sm">Total comments: <b>{{useractivities_comments}}</b></h1>
            </div>
        </div>
      </div>
    </div>

     <div id="qwer" ref="qwer" class="w-full lg:w-7/12 p-5 m-1 lg:pr-1">
        <div v-for="userpost in userposts" :key="userpost.id">
        <div v-if="userpost.anonymous == ''">
        <div id="post" class="px-5 mb-3 py-4 bg-white hover:bg-gray-10 dark:bg-gray-800 shadow rounded-lg max-w-full">
        <div class="flex justify-between items-center">
            <div class="flex mb-4">
            <img class="w-12 h-12 rounded-full" src="https://www.logolynx.com/images/logolynx/97/97e88682fa82ed11f3bf96dcf8479635.png"/>
            <div class="ml-2 mt-0.5">
                <div>
                <span class="block font-medium text-base leading-snug text-black dark:text-gray-100 font-bold">{{ userpost.username }}</span>
                </div>
                <span class="block text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">{{ userpost.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
            </div>
            </div>
            <div>
            <div class="relative inline-block text-left" >
                <div>
                <button type="button" @click="showitems = userpost" class="inline-flex justify-center w-full rounded-md px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-expanded="true" aria-haspopup="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
                </div>
            <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <div class="py-1"  role="none" v-show="showitems == userpost">
                    <button @click="deletePost(userpost.id)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                        Delete
                    </button>
                    <div v-if="userpost.status == '0'">
                    <button @click="seenPost(userpost.id)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                        Mark post as <b>Seen by Admin</b>   
                    </button>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
            <div class="flex mr-5" v-if="userpost.status == '1'">
                <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white text-green-500 dark:bg-gray-800 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-green-500 dark:text-gray-400 font-light">Noticed by USeP admin</span>
            </div> 
            <div v-else>

            </div>

            <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal text-lg font-bold mb-3">
            {{userpost.title}}
            </p>
        
            <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal">
            {{userpost.description}}
            </p>
            <a :href="('/post/' + userpost.id)">
            <div class="flex justify-right items-center mt-5 pt-3 border-t-2 border-gray-200">
                <div class="flex mr-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                        <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{userpost.upvote_count}}</span>
                </div> 
                <div class="flex mr-5">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{userpost.downvote_count}}</span>
                </div>
                <div class="flex mr-5">
                        <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white dark:bg-gray-800 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{userpost.count_comments}}</span>
                </div> 
            </div>
            </a>
        </div>
        </div>
        </div>
    </div>

</div>
</template>

<script>
export default {
  name: 'dropdown',
    data() {
            return {
                id: '',
                username: '',
                dateCreated: '',
                userposts: '',
                totalpost: '',
                useractivities_totalapprovedPost: '',
                useractivities_comments: '',
                showitems: true,
            }
        },
        methods: {
             getUserdata()
            {
                axios.get(`/user/${this.$route.params.id}`).then((response) => 
                    {
                        this.userposts = response.data.userpost
                        this.id = response.data.userdetails[0].id;
                        this.username = response.data.userdetails[0].username;
                        this.dateCreated = response.data.userdetails[0].created_at;

                        this.totalpost = response.data.useractivities_totalPost;
                        this.useractivities_totalapprovedPost = response.data.useractivities_totalapprovedPost;
                        this.useractivities_comments = response.data.useractivities_comments;
                        //console.log(response.data.userdetails)
                    }).catch((error) => 
                    {
                        console.log(error)
                    })
            },
             deletePost(id)
              {
                  axios.delete(`destroyUserpost/${id}`)
                      .then(response => {
                          this.getUserdata()
                      });
              },
              seenPost(id)
              {
                  axios.patch(`updateUserpost/${id}`)
                  .then(response => {
                      this.getUserdata()
                  });
              },
              close (e) {
                  if (!this.$refs["qwer"].contains(e.target)) {
                      //this.state = false
                      this.showitems = false;
                  }
              },
        },
        mounted()
        {
        
            this.getUserdata()
             document.addEventListener('click', this.close)
        },
            beforeDestroy () {
            document.removeEventListener('click',this.close)
            }
           
}
</script>

       